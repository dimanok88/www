<?php

/**
 *
 *
CREATE TABLE IF NOT EXISTS `percent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percent` double NOT NULL,
  `type` varchar(10) NOT NULL,
  `type_item` varchar(10) NOT NULL,
  `type_percent` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;
 *
 * This is the model class for table "percent".
 *
 * The followings are the available columns in table 'percent':
 * @property integer $id
 * @property double $percent
 * @property string $type
 * @property string $type_item
 */
class Percent extends CActiveRecord
{
    const PERC_ROZ = 'roz';
    const PERC_OPT = 'opt';
    const PERC_VIP = 'vip';

    public function getTypePerc()
    {
        return array(
            self::PERC_ROZ => 'Розница',
            self::PERC_OPT => 'Опт',
            self::PERC_VIP => 'VIP',
        );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @return Percent the static model class
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
		return 'percent';
	}

    public function beforeSave() {

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
			array('percent, type_item, type_percent', 'required'),
			array('percent, def', 'numerical'),
			array('type, type_item', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, percent, type, def, type_percent, type_item', 'safe', 'on'=>'search'),
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
			'percent' => 'Процент',
			'type' => 'Тип',
            'type_percent'=>'Тип',
			'type_item' => 'Тип предмета',
            'def'=>'По умолчанию',
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
		$criteria->compare('percent',$this->percent);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('type_item',$this->type_item,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function selectType($t = 'tire')
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition'=>'type=:t',
            'params'=>array(':t'=>$t),
        ));
        return $this;
    }

    public function getPercent($type, $type_item, $type_percent, $price)
    {
        $item = $this->find('type=:t AND type_item=:t_i AND type_percent=:t_p',
                            array(':t'=>$type, ':t_i'=>$type_item, ':t_p'=>$type_percent));
        $c = $item['percent']/100;
        $result = $price + $price * $c;
        if($result == $price)
        {
           $default = Percent::model()->find('type=:t AND type_item=:t_i AND type_percent=:t_p AND def=:d',
                array(':t'=>$type, ':t_i'=>$type_item, ':t_p'=>$type_percent, ':d'=>'1')
           );
            if(count($default)> 0)
            {
                $c = $default['percent']/100;
                $result = $price + $price * $c;
            }
            else $result = 0;
        }
        return $result;
    }
}