<?php

namespace Test;

use TwitterClone\Models\Posts,
  TwitterClone\Models\Users;

/**
 * Class UnitTest
 */
class UnitTest extends \UnitTestCase {
  public function test_addPost () {
    $post = new Posts();
      $post->assign(array(
        'users_id' => '12345678',
        'message' => 'test message for unit test only'
      ));

      $post->save();

    $testPost = Posts::findFirstByMessage('test message for unit test only');

    $this->assertEquals($testPost->message,
      'test message for unit test only',
      'Adding post does not work'
    );
  }

  public function test_deletePostWhichYouCant () {
    $post = Posts::findFirstByMessage('test message for unit test only');

    if ($post->isDeletableByUser('12345679')) {
      $this->assertEquals($post->delete(),
        false,
        "We can delete posts which we didn't post"
      );
    }
  }

  public function test_deletePost () {
    $post = Posts::findFirstByMessage('test message for unit test only');

    if ($post->isDeletableByUser('12345678')) {
      $post->delete();
    }

    $this->assertEquals(Posts::findFirstByMessage('test message for unit test only'),
      false,
      'Deleting post does not work'
    );
  }

  public function test_addUser () {
    $user = new Users();

    $user->assign(array(
      'name' => 'test user name',
      'surname' => 'test user surname',
      'nickname' => 'test user nickname',
      'email' => 'test.user.email@testemail.com',
      'password' => 'testpassword',
    ));

    $this->assertEquals($user->save(),
      true,
      'Adding user does not work'
    );
  }

  public function test_addUserWithTheSameEmail () {
    $user = new Users();

    $user->assign(array(
      'name' => 'test user name 2',
      'surname' => 'test user surname 2',
      'nickname' => 'test user nickname 2',
      'email' => 'test.user.email@testemail.com',
      'password' => 'testpass',
    ));

    $this->assertEquals($user->save(),
      false,
      'We can add users with the same email address.'
    );

    $testUser = Users::findFirstByEmail('test.user.email@testemail.com');
    $testUser->delete();
  }
}
