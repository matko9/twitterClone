<?php
/**
 * Created by PhpStorm.
 * User: matkoabramovic
 * Date: 11/11/14
 * Time: 15:45
 */
namespace TwitterClone\Models;

use Phalcon\Mvc\Model\Validator\Uniqueness;

class Users extends \Phalcon\Mvc\Model {
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $surname;

    /**
     * @var string
     */
    public $nickname;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    public function initialize(){
        $this->hasMany("id",'TwitterClone\Models\Posts',"users_id");
    }

    public function validation(){
        $this->validate(new Uniqueness(array(
            "field" => "email",
            "message" => "The email is already registered"
        )));
        return $this->validationHasFailed() != true;
    }
}