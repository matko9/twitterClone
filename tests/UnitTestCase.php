<?php
use Phalcon\DI,
  Phalcon\DI\FactoryDefault,
  \Phalcon\Test\UnitTestCase as PhalconTestCase;

abstract class UnitTestCase extends PhalconTestCase {

  /**
   * @var \Voice\Cache
   */
  protected $_cache;

  /**
   * @var \Phalcon\Config
   */
  protected $_config;

  /**
   * @var bool
   */
  private $_loaded = false;

  public function setUp (Phalcon\DiInterface $di = null, Phalcon\Config $config = null) {

    // Load any additional services that might be required during testing
    $di = DI::getDefault();

    $di = new FactoryDefault();

    $di->setShared('db', function () {
      return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => "127.0.0.1",
        "username" => "root",
        "password" => "root",
        "dbname" => "twitter_clone"
      ));
    });

    // get any DI components here. If you have a config, be sure to pass it to the parent
    parent::setUp($di);

    $this->_loaded = true;
  }

  /**
   * Check if the test case is setup properly
   * @throws \PHPUnit_Framework_IncompleteTestError;
   */
  public function __destruct () {
    if (!$this->_loaded) {
      throw new \PHPUnit_Framework_IncompleteTestError('Please run parent::setUp().');
    }
  }
}
