<?php
/**
 * Created by PhpStorm.
 * User: matkoabramovic
 * Date: 11/11/14
 * Time: 18:08
 */

namespace TwitterClone\Forms;

use Phalcon\Forms\Form,
  Phalcon\Forms\Element\Text,
  Phalcon\Forms\Element\TextArea,
  Phalcon\Forms\Element\Password,
  Phalcon\Forms\Element\Hidden,
  Phalcon\Forms\Element\Submit,
  Phalcon\Validation\Validator\PresenceOf,
  Phalcon\Validation\Validator\StringLength,
  Phalcon\Validation\Validator\Email,
  Phalcon\Validation\Validator\Confirmation,
  Phalcon\Validation\Validator\Identical;

class LoginForm extends Form {

  public function initialize () {
    $email = new Text('email', array(
      'placeholder' => 'Email',
      'class' => 'form-control'
    ));

    $email->addValidators(array(
      new PresenceOf(array(
        'message' => 'The e-mail is required'
      )),
      new Email(array(
        'message' => 'The e-mail is not valid'
      ))
    ));

    $this->add($email);

    $password = new Password('password', array(
      'placeholder' => 'Password',
      'class' => 'form-control'
    ));

    $password->addValidators(array(
      new PresenceOf(array(
        'message' => 'The password is required',
      ))
    ));

    $this->add($password);

    // CSRF
    $csrf = new Hidden('csrf');

    $csrf->addValidator(new Identical(array(
      'value' => $this->security->getSessionToken(),
      'message' => 'CSRF validation failed'
    )));

    $this->add($csrf);

    $this->add(new Submit('Login', array(
      'class' => 'btn btn-success pull-right'
    )));
  }

  /**
   * Prints messages for a specific element
   */
  public function messages ($name) {
    if ($this->hasMessagesFor($name)) {
      foreach ($this->getMessagesFor($name) as $message) {
        $this->flash->error($message);
      }
    }
  }
}
