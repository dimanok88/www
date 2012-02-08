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

    const ITEM_TYPE_ADMIN = 'admin';
    const ITEM_TYPE_MODERATOR = 'moderator';
    const ITEM_TYPE_GUEST = 'guest';

    const USER_TYPE_FIZ = 'fiz';
    const USER_TYPE_UR = 'ur';
    
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
	        $this->date_reg = new CDbExpression('NOW()');
            //$this->code_active =
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
			array('login, password, email, name, role, phone', 'required'),
			array('active, id_user_reg, org_type_user, type_user', 'numerical', 'integerOnly'=>true),
            array('login, email, code_active', 'unique'),
			array('login, name', 'length', 'max'=>30),
			array('password', 'length', 'max'=>60),
            array('password_req', 'length', 'max'=>60),
			array('password_req', 'compare', 'compareAttribute' => 'password'),
			array('email', 'length', 'max'=>40),
            array('organization, address, info, inn, kpp, bik, bank, r-s, k-s', 'default'),
			array('role', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, login, password, email, info, inn, kpp, bik, bank, r-s, k-s, org_type_user, type_user, address, date_reg, phone, id_user_reg, code_active, name, role, active', 'safe', 'on'=>'search'),
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
		$criteria->compare('login',$this->login,'LIKE');
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getActive($act)
    {
        if($act == 1) return 'Да';
        return 'Нет';

    }

    public function AllRoles()
    {
        return array(
            self::ITEM_TYPE_ADMIN => 'Админ',
            self::ITEM_TYPE_MODERATOR => 'Модератор',
            self::ITEM_TYPE_GUEST => 'Пользователь',
        );
    }

    public function OrgTypeUser()
    {
        return array(
            self::USER_TYPE_FIZ => 'Физическое лицо',
            self::USER_TYPE_UR => 'Юридическое лицо',
        );
    }

    public function GenerateCode()
    {
        //$code = date();
    }
}