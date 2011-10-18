<?php

class UserIdentity extends CUserIdentity
{
	private $_id = 0;

	public function authenticate()
	{
        if( $this->username === 'admin' )
        {
            $optionAdmin = Options::model()->find('name = :name', array(':name' => 'admin'));
            if( is_null($optionAdmin) )
            {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
            if( md5($this->password) == $optionAdmin->value )
            {
                $this->errorCode = self::ERROR_NONE;
            }
            else
            {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            }

            return !$this->errorCode;
        }

        $user = Users::model()->find(
            '`email` = :email',
            array(
                ':email' => $this->username,
            )
        );
		if( is_null($user) )
        {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
        }
		else if( $user->password !== md5($this->password) )
        {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
		else
        {
            $this->_id = $user->user_id;
			$this->errorCode = self::ERROR_NONE;
        }

		return !$this->errorCode;
	}

    public function  getId()
    {
        return $this->_id;
    }
}