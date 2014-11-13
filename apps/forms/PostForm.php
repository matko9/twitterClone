<?php
namespace TwitterClone\Forms;

use Phalcon\Forms\Form,
Phalcon\Forms\Element\Text,
Phalcon\Forms\Element\TextArea,
Phalcon\Forms\Element\Submit,
Phalcon\Validation\Validator\PresenceOf,
Phalcon\Validation\Validator\StringLength,
Phalcon\Validation\Validator\Email;

class PostForm extends Form
{
	public function initialize()
	{
		$message = new TextArea("message", array(
				'placeholder' => 'Message',
				'class' => 'form-control',
				'rows' => '3'
		));
		
		$message->addValidator(new PresenceOf(array(
				'message' => 'A message is required'
		)));
		
		$message->addValidator(new StringLength(array(
				'min' => 5,
				'messageMinimum' => 'A message is too short.',
				'max' => 255,
				'messageMaximum' => 'A message is too long.'
		)));
		$this->add($message);

		$this->add(new Submit('post', array(
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