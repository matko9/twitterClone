<?php

namespace Test;

/**
 * Class UnitTest
 */
class test_addPost extends \UnitTestCase {

  public function testCase () {

    $this->assertEquals('works',
      'works',
      'This is OK'
    );

    $this->assertEquals('works',
      'works1',
      'This wil fail'
    );
  }
}
