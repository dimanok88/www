<?php

/**
 * This is the model class for table "oboznachenie_model".
 *
 * The followings are the available columns in table 'oboznachenie_model':
 * @property integer $id
 * @property string $oboznach
 * @property integer $model_id
 * @property string $type
 */
class OboznachenieModel extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OboznachenieModel the static model class
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
		return 'oboznachenie_model';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('oboznach, model_id', 'required'),
			array('model_id', 'numerical', 'integerOnly'=>true),
			array('oboznach', 'length', 'max'=>50),
			array('type', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, oboznach, model_id, type', 'safe', 'on'=>'search'),
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
			'oboznach' => 'Oboznach',
			'model_id' => 'Model',
			'type' => 'Type',
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
		$criteria->compare('oboznach',$this->oboznach,true);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}