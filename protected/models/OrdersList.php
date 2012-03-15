<?php

/**
 * This is the model class for table "orders_list".
 *
 * The followings are the available columns in table 'orders_list':
 * @property integer $id
 * @property integer $date_add
 * @property integer $id_user
 * @property integer $id_moderator
 * @property string $type
 */
class OrdersList extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OrdersList the static model class
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
		return 'orders_list';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, id_moderator, type', 'required'),
			array('id_user, id_moderator', 'numerical', 'integerOnly'=>true),
            array('comment', 'default'),
			array('type', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date_add, id_user, comment, id_moderator, type', 'safe', 'on'=>'search'),
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
			'id' => 'Номер заказа',
			'date_add' => 'Дата добавления',
			'id_user' => 'Пользователь',
			'id_moderator' => 'Менеджер',
			'type' => 'Тип',
            'comment'=>'Комментарий',
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
		$criteria->compare('date_add',$this->date_add);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('id_moderator',$this->id_moderator);
		$criteria->compare('type',$this->type,true);
        $criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}