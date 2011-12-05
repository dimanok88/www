<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $email
 * @property string $name
 * @property string $role
 * @property integer $active
 */
class Users extends CActiveRecord
{
    public $password_req;
    public $rememberMe;

    private $_identity;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

    public function beforeSave() {
	    if ($this->isNewRecord) {
	        $this->password = crypt($this->password, substr($$this->password, 0, 2));;
	    }

	    return parent::beforeSave();
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, password, email, name, role', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
            array('login, email', 'unique'),
			array('login, name', 'length', 'max'=>30),
			array('password', 'length', 'max'=>60),
            array('password_req', 'length', 'max'=>60),
			array('password_req', 'compare', 'compareAttribute' => 'password'),
			array('email', 'length', 'max'=>40),
			array('role', 'length', 'max'=>15),
            array('rememberMe', 'boolean'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, login, password, email, name, role, active', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '№',
			'login' => 'Логин',
			'password' => 'Пароль',
			'email' => 'E-mail',
			'name' => 'Имя',
			'role' => 'Роль',
			'active' => 'Вкл.',
            'password_req'=>'Повторите пароль',
            'rememberMe'=>'Запомнить меня',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
            echo crypt($this->password, substr($this->password, 0, 2));
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Не верный логин или пароль или ваш аккаунт не активирован');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
        echo '1';
		if($this->_identity===null)
		{
            echo '2';
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}