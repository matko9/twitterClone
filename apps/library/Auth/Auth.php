<?php
/**
 * Created by PhpStorm.
 * User: matkoabramovic
 * Date: 12/11/14
 * Time: 09:36
 */
namespace TwitterClone\Auth;

use TwitterClone\Models\Users;

class Auth extends \Phalcon\Mvc\User\Component {
    public function check($credentials)
    {
        // Check if the user exist
        $user = Users::findFirstByEmail($credentials['email']);
        if ($user == false) {
            throw new Exception('Wrong email/password combination');
        }

        // Check the password
        if (!$this->security->checkHash($credentials['password'], $user->password)) {
            throw new Exception('Wrong email/password combination');
        }

        $this->session->set('auth-identity', array(
            'id' => $user->id,
            'nickname' => $user->nickname,
            'email' => $user->email,
        ));
    }

    public function getIdentity()
    {
        return $this->session->get('auth-identity');
    }

    public function getName()
    {
        $identity = $this->session->get('auth-identity');
        return $identity['nickname'];
    }

    public function remove()
    {
        $this->session->remove('auth-identity');
    }
}