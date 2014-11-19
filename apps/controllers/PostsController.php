<?php
use Phalcon\Tag,
  TwitterClone\Forms\PostForm,
  TwitterClone\Models\Posts,
  \Phalcon\Filter;

class PostsController extends \Phalcon\Mvc\Controller {

  public function indexAction () {
    if (!$this->auth->getIdentity()) {
      return $this->response->redirect("session");
    }
    $currentPage = $this->request->getQuery('page', 'int');
    $phql = 'SELECT TwitterClone\Models\Posts.id AS id, TwitterClone\Models\Posts.message AS message,
            TwitterClone\Models\Users.nickname as nickname, TwitterClone\Models\Users.id as users_id
                  FROM TwitterClone\Models\Posts JOIN TwitterClone\Models\Users ORDER BY TwitterClone\Models\Posts.id DESC';
    $posts = $this->modelsManager->executeQuery($phql);

    $this->view->pagination = $posts->count() > 5 ? 1 : 0;
    $paginator = new \Phalcon\Paginator\Adapter\Model(
      array(
        "data" => $posts,
        "limit" => 5,
        "page" => $currentPage
      )
    );

    $identity = $this->auth->getIdentity();
    $this->view->identity = $identity['id'];
    $this->view->page = $paginator->getPaginate();
    $this->view->form = new PostForm();
  }

  public function createAction () {
    $form = new PostForm();

    if ($this->request->isPost()) {
      if ($form->isValid($this->request->getPost()) != false) {
        $identity = $this->auth->getIdentity();
        $post = new Posts();
        $post->assign(array(
          'users_id' => $identity[id],
          'message' => $this->request->getPost('message', 'striptags')
        ));
        if ($post->save()) {
          $this->flash->success("Post succesfull!");
          Tag::resetInput();
          return $this->response->redirect("posts");
        }
        $this->flash->error($post->getMessages());
      }
    }
    $currentPage = $this->request->getQuery('page', 'int');
    $phql = 'SELECT TwitterClone\Models\Posts.id AS id, TwitterClone\Models\Posts.message AS message,
            TwitterClone\Models\Users.nickname as nickname, TwitterClone\Models\Users.id as users_id
                  FROM TwitterClone\Models\Posts JOIN TwitterClone\Models\Users ORDER BY TwitterClone\Models\Posts.id DESC';
    $posts = $this->modelsManager->executeQuery($phql);

    $this->view->pagination = $posts->count() > 5 ? 1 : 0;
    $paginator = new \Phalcon\Paginator\Adapter\Model(
      array(
        "data" => $posts,
        "limit" => 5,
        "page" => $currentPage
      )
    );

    $identity = $this->auth->getIdentity();
    $this->view->identity = $identity['id'];
    $this->view->page = $paginator->getPaginate();
    $this->view->form = new PostForm();
  }

  public function deleteAction () {
    $this->view->disable();
    $id = $_POST['id'];
    $post = Posts::findFirstById($id);
    if (!$post) {
      $message = 'Post was not found!';
    } else {
      $identity = $this->auth->getIdentity();
      if ($identity['id'] == $post->users_id) {
        if (!$post->delete()) {
          $message = 'Post was not found!';
        } else {
          $message = 'Success';
        }
      } else {
        $message = "You can't delete this post!";
      }
    }
    echo $message;
  }
}
