<?php

/**
 * This is the model class for table "type_item".
 *
 * The followings are the available columns in table 'type_item':
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $type
 */
class TypeItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TypeItem the static model class
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
		return 'type_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, title, type', 'required'),
			array('name', 'length', 'max'=>50),
            array('name+type', 'application.extensions.uniqueMultiColumnValidator'),
			array('title', 'length', 'max'=>150),
			array('type', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, title, type', 'safe', 'on'=>'search'),
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
			'name' => 'Системное имя',
			'title' => 'Название',
			'type' => 'Тип',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function type($t = 'tire')
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition'=>'type=:t',
            'params'=>array(':t'=>$t),
        ));
        return $this;
    }
}