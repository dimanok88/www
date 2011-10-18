<?php

class Images extends CActiveRecord
{
    public $photo;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'images';
	}

	public function rules()
	{
		return array(
			array('item_id', 'length', 'max'=>32),
			array('thumb_path, full_path, description', 'length', 'max'=>255),
            array('photo', 'file', 'maxSize' => 1024*1024*1024, 'types' => 'jpg, png, gif'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

    public function beforeDelete()
    {
        @unlink(realpath(Yii::app()->getBasePath() . '/..' . $this->full_path));
        @unlink(realpath(Yii::app()->getBasePath() . '/..' . $this->thumb_path));
        return true;
    }

	public function attributeLabels()
	{
		return array(			
			'description' => 'Описание',
            'photo' => 'Фотография',
		);
	}
}