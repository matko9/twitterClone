<?php
use Phalcon\Tag,
  TwitterClone\Forms\SignUpForm,
  TwitterClone\Forms\LoginForm,
  TwitterClone\Models\Users,
  TwitterClone\Auth\Exception as AuthException,
  \Phalcon\Filter;

class SessionController extends \Phalcon\Mvc\Controller {

  public function indexAction () {

  }

  public function signupAction () {
    $form = new SignUpForm();

    if ($this->request->isPost()) {
      if ($form->isValid($this->request->getPost()) != false) {
        $user = new Users();
        $user->assign(array(
          'name' => $this->request->getPost('name', 'striptags'),
          'surname' => $this->request->getPost('surname', 'striptags'),
          'nickname' => $this->request->getPost('nickname', 'striptags'),
          'email' => $this->request->getPost('email'),
          'password' => $this->security->hash($this->request->getPost('password', 'striptags'))
        ));
        if ($user->save()) {
          return $this->dispatcher->forward(array(
            'controller' => 'session',
            'action' => 'login'
          ));
        }
        $this->flash->error($user->getMessages());
      }
    }
    $this->view->form = $form;
  }

  public function loginAction () {
    $form = new LoginForm();

    try {
      if ($this->request->isPost()) {
        if ($form->isValid($this->request->getPost()) != false) {
          $this->auth->check(array(
            'email' => $this->request->getPost('email', 'striptags'),
            'password' => $this->request->getPost('password', 'striptags'),
          ));
          return $this->response->redirect('posts');
        }
      }
    } catch (AuthException $e) {
      $this->flash->error($e->getMessage());
    }

    $this->view->form = $form;
  }

  public function logoutAction () {
    $this->auth->remove();

    return $this->response->redirect('session');
  }
}
