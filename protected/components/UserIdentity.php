<?php

class UserIdentity extends CUserIdentity
{
	private $_id = 0;

	public function authenticate()
	{
        if( $this->username == 'roma' )
        {
            $optionAdmin = Users::model()->find('login = :login AND role=:role', array(':login' => 'roma', ':role'=>'admin'));
            if( is_null($optionAdmin) )
            {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
            if( crypt($this->password, substr($this->password, 0, 2)) == $optionAdmin->password )
            {
                $this->_id = $optionAdmin->id;
                $this->username = $optionAdmin->name;
                $this->errorCode = self::ERROR_NONE;
            }
            else
            {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            }

            return !$this->errorCode;
        }

        $user = Users::model()->find('`login` = :login AND active=1', array(':login' => $this->username,));
		if( is_null($user) )
        {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
        }
		else if( $user->password !== crypt($this->password, substr($this->password, 0, 2)) )
        {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
		else
        {
            $this->_id = $user->id;
            $this->username = $user->name;
			$this->errorCode = self::ERROR_NONE;
        }

		return !$this->errorCode;
	}

    public function  getId()
    {
        return $this->_id;
    }
}