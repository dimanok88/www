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
    public $send_mail;

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
            $this->id_user_reg = Yii::app()->user->id;
            if($this->id_user_reg == 0)
                $this->code_active = $this->GenerateCode();
            if($this->send_mail == 1)
                $this->SendMail();
	    }

	    return parent::beforeSave();
	}

    public function beforeValidate() {
        $this->phone = str_replace(array('(',')','-'), '', $this->phone);

        return parent::beforeValidate();
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
			array('active, id_user_reg, send_mail', 'numerical', 'integerOnly'=>true),
            array('login, email, code_active', 'unique'),
			array('login, name', 'length', 'max'=>30),
			array('password', 'length', 'max'=>60),
            array('password_req', 'length', 'max'=>60),
			array('password_req', 'compare', 'compareAttribute' => 'password'),
			array('email', 'length', 'max'=>40),
            array('organization, address, info, phone, org_type_user, type_user, inn, kpp, bik, bank, r_s, k_s', 'default'),
			array('role', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, login, send_mail, password, email, info, inn, kpp, bik, bank, r_s, k_s, org_type_user, type_user, address, date_reg, phone, id_user_reg, code_active, name, role, active', 'safe', 'on'=>'search'),
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
            'org_type_user'=>'Тип пользователя',
            'type_user'=>'Цена пользователя',
            'send_mail' => 'Отправить уведомление',
            'password_req'=>'Повторите пароль',
            'info'=>'Дополнительная Информация',
            'inn'=>'ИНН',
            'kpp'=>'КПП',
            'bik'=>'БИК',
            'bank'=>'Банк',
            'r_s'=>'Р\С',
            'k_s'=>'К\С',
            'address'=>'Адрес доставки',
            'date_reg'=>'Дата регистрации',
            'phone'=>'Телефон',
            'id_user_reg'=>'Регистратор',
            'code_active'=>'Код активации',
            'organization'=>'Организация',
            'date_modify'=>'Дата модификации',
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
		$criteria->compare('role',$this->role);
		$criteria->compare('active',$this->active);
		$criteria->compare('id_user_reg',$this->id_user_reg,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address);
        $criteria->compare('organization',$this->organization,true);
        $criteria->compare('code_active',$this->code_active,true);
		$criteria->compare('bank',$this->bank,true);
		$criteria->compare('bik',$this->bik,true);
		$criteria->compare('kpp',$this->kpp);
        $criteria->compare('inn',$this->inn,true);
		$criteria->compare('r_s',$this->r_s,true);
		$criteria->compare('k_s',$this->k_s);
        $criteria->compare('org_type_user',$this->org_type_user);
        $criteria->compare('type_user',$this->type_user);
        $criteria->compare('info',$this->info);



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
            //self::ITEM_TYPE_ADMIN => 'Админ',
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
    public function getOrgTypeUser($t)
    {
        $type = $this->OrgTypeUser();
        return $type[$t];
    }

    public function GenerateCode()
    {
        $code = md5($this->email);
        return $code;
    }

    public function SendMail()
    {
        $email = Yii::app()->email;
        $email->to = $this->email;
        $email->subject = 'Регистрация на сайте мобиль36.рф';
        $email->view = 'regUser';
        $email->viewVars = array('login'=>$this->login,'phone'=>$this->phone);
        $email->send();
    }
}