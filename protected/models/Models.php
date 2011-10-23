<?php

/**
 * This is the model class for table "model".
 *
 * The followings are the available columns in table 'model':
 * @property integer $id
 * @property string $model
 * @property string $activate
 * @property string $type
 */
class Models extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Model the static model class
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
		return 'model';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model, type', 'required'),
			array('model', 'length', 'max'=>100),
			array('activate', 'length', 'max'=>1),
			array('type', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, model, activate, type', 'safe', 'on'=>'search'),
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
			'id' => 'Номер',
			'model' => 'Модель',
			'activate' => 'Активность',
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
		$criteria->compare('model',$this->model,true);
		$criteria->compare('activate',$this->activate,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getModelList($type, $addEmptyItem = false)
    {
        $result = array();

        $criteria = new CDbCriteria();
        $criteria->select = 'model, id';
        $criteria->group = '`model`';
        $criteria->condition = "`type` = :type AND activate='1'";
        $criteria->params = array(
            ':type' => $type,
        );

        $values = $this->findAll($criteria);

        if( $addEmptyItem )
        {
            $result[''] = '';
        }

        foreach($values as $value)
        {
            $result[$value->id] = $value->model;
        }

        return $result;
    }

    
}