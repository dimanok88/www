<?php

/**
 * This is the model class for table "auto".
 *
 * The followings are the available columns in table 'auto':
 * @property integer $auto_id
 * @property integer $category_id
 * @property string $name
 * @property string $description
 * @property string $cost
 */
class Item extends CActiveRecord implements IECartPosition
{
    const ITEM_TYPE_TIRE = 'tire';
    const ITEM_TYPE_DISC = 'disc';

    public function getTypeList()
    {
        return array(
            self::ITEM_TYPE_DISC => 'Диск',
            self::ITEM_TYPE_TIRE => 'Шина',
        );
    }

    public function getTypeName($value = null)
    {
        if( is_null($value) )
        {
            $value = $this->type;
        }
        $values = $this->getTypeList();
        if( array_key_exists($value, $values) )
        {
            return $values[$value];
        }
        return '';
    }


    /**
	 * Returns the static model of the specified AR class.
	 * @return Auto the static model class
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
			array('name, cost', 'required'),
			array('name', 'length', 'max'=>255),
            array('cost', 'length', 'max'=>18),
            array('description', 'safe'),
            array('type', 'in', 'range' => array(self::ITEM_TYPE_DISC, self::ITEM_TYPE_TIRE)),
            array('vendor, model, brand, typename', 'length', 'max' => 128),
            array('category', 'length', 'max' => 64),
            array('et, dia, hw', 'length', 'max' => 7),
            array('pcd, season, indg', 'length', 'max' => 16),
            array('indv', 'length', 'max' => 2),

            array('id', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),

            // search
			array('id, type, name, cost', 'safe', 'on'=>'search'),

            // tires
            array('name, cost, category, model, brand, season, d, vendor', 'safe', 'on' => 'tires'),

            // disc
            array('model, name, cost, w, et, d', 'safe', 'on' => 'disc'),

            // searchTire
            array('name, cost, category, model, brand, season, d, hw, w, vendor', 'safe', 'on' => 'searchTire'),

            // searchDisc
            array('model, name, cost, w, et, d, pcd', 'safe', 'on' => 'searchDisc'),
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
            'category' => array(
                self::HAS_ONE,
                'Category',
                '',
                'on' => '`t`.`category_id` = `category`.`id`',
            ),
            'images' => array(
                self::HAS_MANY,
                'Images',
                '',
                'on' => '`t`.`id` = `images`.`item_id`',
                'alias' => 'images',
            ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Код',
			'category_id' => 'Категория',
			'name' => 'Название',
			'description' => 'Описание',
            'cost' => 'Цена',
            'type' => 'Тип товара',

            'vendor' => 'Производитель',
            'model' => 'Модель',
            'category' => 'Категория',
            'brand' => 'Марка',
            'typename' => 'Тип',
            'et' => 'Вылет',
            'dia' => 'Диаметр',
            'pcd' => 'Посадочный размер',
            'd' => 'Диаметр',
            'season' => 'Сезон',
            'w' => 'Ширина',
            'hw' => 'Профиль',
            'indg' => 'Индекс нагрузки',
            'indv' => 'Индекс скорости',
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

		$criteria = new CDbCriteria;

        $query = '';
        if( isset($_GET['query']) )
        {
            $query = $_GET['query'];
        }

        $criteria->select = '`id`, `name`, `cost`, `type`';
        $criteria->addSearchCondition('`id`', $query, true, 'OR');
        $criteria->addSearchCondition('`name`', $query, true, 'OR');
        $criteria->addSearchCondition('`cost`', $query, true, 'OR');
        $criteria->addCondition(
            '`t`.`cost` > 0'
        );

		return new CActiveDataProvider(
            get_class($this),
            array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 50,
                ),
            )
        );
	}

    public function tires()
    {
        $criteria = new CDbCriteria();        
        $criteria->addCondition(
            array(
                '`cost` > 0',
                "`type` = 'tire'",
            )
        );
        $criteria->compare('`d`', $this->d);
        $criteria->compare('`season`', $this->season);
        $criteria->compare('`vendor`', $this->vendor);
        $criteria->compare('`brand`', $this->brand);
        $criteria->compare('`category`', $this->category);
        $criteria->compare('`cost`', $this->cost, 'LIKE');
        $criteria->addSearchCondition('`name`', $this->name);

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

    public function searchTire()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition(
            array(
                '`cost` > 0',
                "`type` = 'tire'",
            )
        );
        $criteria->compare('`d`', $this->d);
        $criteria->compare('`season`', $this->season);
        $criteria->compare('`vendor`', $this->vendor);
        $criteria->compare('`brand`', $this->brand);
        $criteria->compare('`category`', $this->category);
        $criteria->compare('`cost`', $this->cost, 'LIKE');
        $criteria->compare('`w`', $this->w);
        $criteria->compare('`hw`', $this->hw);
        $criteria->addSearchCondition('`name`', $this->name);

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

    public function disc()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition(
            array(
                '`cost` > 0',
                "`type` = 'disc'",
            )
        );
        $criteria->compare('`d`', $this->d);
        $criteria->compare('`et`', $this->et);
        $criteria->compare('`w`', $this->w);
        $criteria->compare('`model`', $this->model);
        $criteria->compare('`cost`', $this->cost, 'LIKE');
        $criteria->addSearchCondition('`name`', $this->name);

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

    public function searchDisc()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition(
            array(
                '`cost` > 0',
                "`type` = 'disc'",
            )
        );
        $criteria->compare('`d`', $this->d);
        $criteria->compare('`et`', $this->et);
        $criteria->compare('`w`', $this->w);
        $criteria->compare('`pcd`', $this->pcd);
        $criteria->compare('`model`', $this->model);
        $criteria->compare('`cost`', $this->cost, 'LIKE');
        $criteria->addSearchCondition('`name`', $this->name);

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

    public function getCost()
    {
        if( $this->cost == 0 )
        {
            return 'Звоните';
        }
        return number_format($this->cost, 2, ",", " ");
    }

    public function getId()
    {
        return 'item' . $this->id;
    }

    public function getPrice()
    {
        return $this->cost;
    }

    public function getRandomItems($count = 8)
    {
        $criteria = new CDbCriteria();
        $criteria->limit = $count;
        $criteria->order = 'RAND()';
        $criteria->with = array(
            'images',
        );
        
        return $this->findAll($criteria);
    }

    public function getDList($type = self::ITEM_TYPE_TIRE, $addEmptyItem = false)
    {
        $result = array();

        $criteria = new CDbCriteria();
        $criteria->select = '`d`';
        $criteria->group = '`d`';
        $criteria->condition = "`type` = :type AND `cost` > 0";
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
            $result[$value->d] = $value->d;
        }

        ksort($result);

        return $result;
    }

    public function getWList($type = self::ITEM_TYPE_TIRE, $addEmptyItem = false)
    {
        $result = array();

        $criteria = new CDbCriteria();
        $criteria->select = '`w`';
        $criteria->group = '`w`';
        $criteria->condition = "`type` = :type AND `cost` > 0";
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
            $result[$value->w] = $value->w;
        }
        
        ksort($result);

        return $result;
    }

    public function getHwList($type = self::ITEM_TYPE_TIRE, $addEmptyItem = false)
    {
        $result = array();

        $criteria = new CDbCriteria();
        $criteria->select = '`hw`';
        $criteria->group = '`hw`';
        $criteria->order = '`hw`';
        $criteria->condition = "`type` = :type AND `cost` > 0";
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
            $result[$value->hw] = $value->hw;
        }

        ksort($result);

        return $result;
    }

    public function getEtList($type = self::ITEM_TYPE_TIRE, $addEmptyItem = false)
    {
        $result = array();

        $criteria = new CDbCriteria();
        $criteria->select = '`et`';
        $criteria->group = '`et`';
        $criteria->condition = "`type` = :type AND `cost` > 0";
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
            $result[$value->et] = $value->et;
        }

        ksort($result);

        return $result;
    }

    public function getPcdList($type = self::ITEM_TYPE_TIRE, $addEmptyItem = false)
    {
        $result = array();

        $criteria = new CDbCriteria();
        $criteria->select = '`pcd`';
        $criteria->group = '`pcd`';
        $criteria->condition = "`type` = :type AND `cost` > 0";
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
            $result[$value->pcd] = $value->pcd;
        }

        ksort($result);

        return $result;
    }

    public function getSeasonList($type = self::ITEM_TYPE_TIRE, $addEmptyItem = false)
    {
        $result = array();

        $criteria = new CDbCriteria();
        $criteria->select = '`season`';
        $criteria->group = '`season`';
        $criteria->condition = "`type` = :type AND `cost` > 0";
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
            $result[$value->season] = $value->season;
        }

        return $result;
    }

    public function getVendorList($type = self::ITEM_TYPE_TIRE, $addEmptyItem = false)
    {
        $result = array();

        $criteria = new CDbCriteria();
        $criteria->select = '`vendor`';
        $criteria->group = '`vendor`';
        $criteria->condition = "`type` = :type AND `cost` > 0";
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
            $result[$value->vendor] = $value->vendor;
        }

        return $result;
    }

    public function getBrandList($type = self::ITEM_TYPE_TIRE, $addEmptyItem = false)
    {
        $result = array();

        $criteria = new CDbCriteria();
        $criteria->select = '`brand`';
        $criteria->group = '`brand`';
        $criteria->condition = "`type` = :type AND `cost` > 0";
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
            $result[$value->brand] = $value->brand;
        }

        return $result;
    }

    public function getCategoryList($type = self::ITEM_TYPE_TIRE, $addEmptyItem = false)
    {
        $result = array();

        $criteria = new CDbCriteria();
        $criteria->select = '`category`';
        $criteria->group = '`category`';
        $criteria->condition = "`type` = :type AND `cost` > 0";
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
            $result[$value->category] = $value->category;
        }

        return $result;
    }

    public function getModelList($type = self::ITEM_TYPE_TIRE, $addEmptyItem = false)
    {
        $result = array();

        $criteria = new CDbCriteria();
        $criteria->select = '`model`';
        $criteria->group = '`model`';
        $criteria->condition = "`type` = :type AND `cost` > 0";
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
            $result[$value->model] = $value->model;
        }

        return $result;
    }
}