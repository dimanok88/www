<?php

/**
 * This is the model class for table "item".
 *
 * The followings are the available columns in table 'item':
 * @property integer $id
 * @property string $main_string
 * @property double $price
 * @property string $type
 * @property string $type_item
 * @property integer $season
 * @property double $diametr
 * @property double $width
 * @property double $profile
 * @property double $vilet
 * @property string $stupica
 * @property double $krepezh
 * @property string $color
 * @property string $model
 * @property integer $active
 * @property string $date_add
 * @property string $date_modify
 */
class Item extends CActiveRecord implements IECartPosition
{

        const ITEM_TYPE_TIRE = 'tire';
        const ITEM_TYPE_DISC = 'disc';
        const ITEM_TYPE_OTHER = 'other';

        public function getTypeList()
        {
            return array(
                self::ITEM_TYPE_DISC => 'Диск',
                self::ITEM_TYPE_TIRE => 'Шина',
                self::ITEM_TYPE_OTHER => 'Разное',
            );
        }
	/**
	 * Returns the static model of the specified AR class.
	 * @return Item the static model class
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
		return 'item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('main_string, price', 'required'),
			array('active', 'numerical'),
			array('price, d, w, hw, vilet, krepezh', 'numerical'),
			array('main_string', 'length', 'max'=>255),
			array('type', 'length', 'max'=>10),
			array('type_item', 'length', 'max'=>6),
			array('stupica', 'length', 'max'=>30),
			array('color', 'length', 'max'=>200),
			array('model', 'length', 'max'=>100),
            array('season, pic, descript, marka, shipi', 'default'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, main_string, price, type, type_item, season, d, w, hw, vilet, stupica, shipi, krepezh, color, model, active, date_add, date_modify', 'safe', 'on'=>'search'),
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


    public function beforeSave() {
	    if ($this->isNewRecord) {
	        $this->date_add = new CDbExpression('NOW()');
	    }
        
	    return parent::beforeSave();
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'main_string' => 'Строка',
			'price' => 'Цена',
			'type' => 'Тип',
			'type_item' => 'Тип элемента',
			'season' => 'Сезон',
			'd' => 'Радиус',
			'w' => 'Ширина',
			'hw' => 'Профиль',
			'vilet' => 'Вылет',
			'stupica' => 'Ступица',
			'krepezh' => 'Крепеж',
			'color' => 'Цвет',
			'model' => 'Модель',
			'active' => 'Активность',
			'date_add' => 'Добавлен',
			'date_modify' => 'Изменен',
            'pic'=> 'Картинка',
            'descript'=>'Описание',
            'marka'=>'Марка',
            'shipi'=>'Шипи',
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
		$criteria->compare('main_string',$this->main_string,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('type_item',$this->type_item,true);
		$criteria->compare('season',$this->season);
		$criteria->compare('diametr',$this->diametr);
		$criteria->compare('width',$this->width);
		$criteria->compare('profile',$this->profile);
		$criteria->compare('vilet',$this->vilet);
		$criteria->compare('stupica',$this->stupica,true);
        $criteria->compare('shipi',$this->shipi);
		$criteria->compare('krepezh',$this->krepezh);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_modify',$this->date_modify,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function getId()
        {
            return 'item' . $this->id;
        }

        public function getPrice()
        {
            if( $this->price == 0 )
            {
                return 'Звоните';
            }
            return number_format($this->price, 2, ",", " ");
            //return $this->price;
        }

        public function getMain_string()
        {
            return $this->main_string;
        }


        //проверка на существование строки в базе если ее нет то функция возвращет true
        public function NewString($string)
        {
            $searchString = $this->count('main_string=:main', array(':main'=>$string));
            if($searchString == 0)
            {
                return true;
            }
            return false;
        }

        // проверка цены у строк. Если цена обновилось у строки то возвращется ID этой строки
        public function NewPrice($string, $price)
        {
            $searchString = $this->find('main_string=:main AND price!=:p', array(':main'=>$string, ':p'=>$price));
            if(count($searchString) > 0)
            {
                if($searchString->price == $price) return false;
                else return $searchString->id;
            }
            return false;
        }

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
    //выборка шин с ценой > 0 и находится в активном состоянии 1
    public function tires()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition(
            array(
                '`price` > 0',
                "`type` = 'tire'",
                "`active` = 1",
            )
        );
        $criteria->compare('`d`', $this->d);
        $criteria->compare('`season`', $this->season);
        $criteria->compare('`price`', $this->price, 'LIKE');
        //$criteria->addSearchCondition('`name`', $this->name);

        return new CActiveDataProvider(
            get_class($this),
            array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => Yii::app()->params['countItemsByPage'],
                )
            )
        );
    }

    //выборка дисков с ценой > 0 и находится в активном состоянии 1
    public function discs()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition(
            array(
                '`price` > 0',
                "`type` = 'disc'",
                "`active` = 1",
            )
        );
        $criteria->compare('`d`', $this->d);
        $criteria->compare('`price`', $this->price, 'LIKE');
        //$criteria->addSearchCondition('`name`', $this->name);

        return new CActiveDataProvider(
            get_class($this),
            array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => Yii::app()->params['countItemsByPage'],
                )
            )
        );
    }

    //выборка разного с ценой > 0 и находится в активном состоянии 1
    public function other()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition(
            array(
                '`price` > 0',
                "`type` = 'other'",
                "`active` = 1",
            )
        );
        $criteria->compare('`marka`', $this->d);
        $criteria->compare('`price`', $this->price, 'LIKE');
        //$criteria->addSearchCondition('`name`', $this->name);

        return new CActiveDataProvider(
            get_class($this),
            array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => Yii::app()->params['countItemsByPage'],
                )
            )
        );
    }
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////

}