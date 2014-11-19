<?php
namespace TwitterClone\Models;

use Phalcon\Mvc\Model\Validator\Email as EmailValidator,
  Phalcon\Mvc\Model\Validator\StringLength as StringLengthValidator;

class Posts extends \Phalcon\Mvc\Model {

  /**
   * @var integer
   */
  public $id;

  /**
   * @var integer
   */
  public $users_id;

  /**
   * @var string
   */
  public $message;

  public function initialize () {
    $this->belongsTo("users_id", 'TwitterClone\Models\Users', "id");
  }

  public function validation () {
    $this->validate(new StringLengthValidator(array(
      'field' => 'message',
      'max' => 255,
      'min' => 5,
      'messageMaximum' => 'A message is too long.',
      'messageMinimum' => 'A message is too short.'
    )));
    return $this->validationHasFailed() != true;
  }
}
