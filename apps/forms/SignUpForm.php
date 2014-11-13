<?php
/**
 * Created by PhpStorm.
 * User: matkoabramovic
 * Date: 11/11/14
 * Time: 14:31
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

class SignUpForm extends Form
{
    public function initialize()
    {
        $name = new Text('name', array(
            'placeholder' => 'Name',
            'class' => 'form-control'
        ));

        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'The name is required'
            ))
        ));

        $this->add($name);

        $surname = new Text('surname', array(
            'placeholder' => 'Surname',
            'class' => 'form-control'
        ));

        $surname->addValidators(array(
            new PresenceOf(array(
                'message' => 'The surname is required'
            ))
        ));

        $this->add($surname);

        $nickname = new Text('nickname', array(
            'placeholder' => 'Nickname',
            'class' => 'form-control'
        ));

        $nickname->addValidators(array(
            new PresenceOf(array(
                'message' => 'The nickname is required'
            ))
        ));

        $this->add($nickname);

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

        $password = new Password('password',  array(
            'placeholder' => 'Password',
            'class' => 'form-control'
        ));

        $password->addValidators(array(
            new PresenceOf(array(
                'message' => 'The password is required'
            )),
            new StringLength(array(
                'min' => 8,
                'messageMinimum' => 'Password is too short. Minimum 8 characters'
            )),
            new Confirmation(array(
                'message' => 'Password doesn\'t match confirmation',
                'with' => 'confirmPassword'
            ))
        ));

        $this->add($password);

        // Confirm Password
        $confirmPassword = new Password('confirmPassword',  array(
            'placeholder' => 'Confirm password',
            'class' => 'form-control'
        ));

        $confirmPassword->addValidators(array(
            new PresenceOf(array(
                'message' => 'The confirmation password is required'
            ))
        ));
        $this->add($confirmPassword);

        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));

        $this->add($csrf);

        $this->add(new Submit('Sign Up', array(
            'class' => 'btn btn-success pull-right'
        )));
    }

    /**
     * Prints messages for a specific element
     */
    public function messages($name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                $this->flash->error($message);
            }
        }
    }
}