<?php

namespace Test;

use TwitterClone\Models\Posts;

/**
 * Class UnitTest
 */
class UnitTest extends \UnitTestCase {
  public function test_addPost () {
    $post = new Posts();
    //if (!Posts::exist('12345678')){
      $post->assign(array(
        'id' => '12345678',
        'users_id' => '12345678',
        'message' => 'test message'
      ));

      $post->save();
    //}

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
}
