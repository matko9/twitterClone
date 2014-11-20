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
        'id' => '12345678',
        'users_id' => '12345678',
        'message' => 'test message'
      ));

      $post->save();

    $testPost = Posts::findFirstById('12345678');

    $this->assertEquals($testPost->message,
      'test message',
      'Adding post does not work'
    );
  }

  public function test_deletePost () {
    $post = Posts::findFirstById('12345678');

    $post->delete();

    $this->assertEquals(Posts::findFirstById('12345678'),
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
      'password' => '$2a$12$57d63765af316acc7045d6ceec705e0b801a6ef905e0b801a6hrd',
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
      'password' => '$2a$12$57d63765af8319hda8486ceec705e0b801a6ef905e0b801a6hrd',
    ));

    $this->assertEquals($user->save(),
      false,
      'We can add users with the same email address.'
    );

    $testUser = Users::findFirstByEmail('test.user.email@testemail.com');
    $testUser->delete();
  }
}
