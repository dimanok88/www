<?php

/**
 * This is the model class for table "orders_type".
 *
 * The followings are the available columns in table 'orders_type':
 * @property integer $id
 * @property string $Name
 * @property string $sys_name
 */
class OrdersType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OrdersType the static model class
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
		return 'orders_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, sys_name', 'required'),
			array('title', 'length', 'max'=>150),
			array('sys_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, sys_name', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'title' => 'Название',
			'sys_name' => 'Системное имя',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('sys_name',$this->sys_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function AllTypeOrd($addEmptyItem = false)
    {
        $result = array();

        //$criteria = new CDbCriteria();

        $values = $this->findAll();

        if( $addEmptyItem )
        {
            $result[''] = '';
        }

        foreach($values as $value)
        {
            $result[$value->id] = $value->title;
        }

        return $result;
    }

    public function getTypeOrd($id)
    {
        $type = $this->findByPk($id);
        return $type['title'];
    }

    public function getSysName($id)
    {
        $type = $this->findByPk($id);
        return $type['sys_name'];
    }
}