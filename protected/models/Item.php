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
        public $pictures;

        const ITEM_TYPE_TIRE = 'tire';
        const ITEM_TYPE_DISC = 'disc';
        const ITEM_TYPE_OTHER = 'other';

        const ITEM_SEASON_LETO = 'leto';
        const ITEM_SEASON_ZIMA = 'zima';
        const ITEM_SEASON_VSESEASON = 'vsesez';

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
			array('active, new_price', 'numerical'),
			array('price, d, w, hw, vilet, link, krepezh', 'default'),
			array('main_string', 'length', 'max'=>255),
			array('type', 'length', 'max'=>10),
			array('type_item', 'length', 'max'=>20),
			array('stupica', 'length', 'max'=>30),
			array('color', 'length', 'max'=>200),			
            array('pictures' , 'file', 'types'=>'jpg, gif, png, jpeg', 'allowEmpty' => true),
            array('season, ost, model, country,descript, pic, marka, shipi, category', 'default'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, main_string, ost, new_price, link, price,country, type, type_item, season, d, w, hw, vilet, category, stupica, shipi, krepezh, color, model, active, date_add, date_modify', 'safe', 'on'=>'search'),
		);
	}

    function getPrice(){
        return $this->price;
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
        $this->new_price = 1;
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
            'pictures'=> 'Картинка',
            'descript'=>'Описание',
            'marka'=>'Марка',
            'shipi'=>'Шипы',
            'category'=>'Категория',
            'country'=>'Производитель',
            'link'=>'Ссылка',
            'ost'=>'Остаток',
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
		$criteria->compare('d',$this->diametr);
		$criteria->compare('w',$this->width);
		$criteria->compare('hw',$this->profile);
		$criteria->compare('vilet',$this->vilet);
		$criteria->compare('stupica',$this->stupica,true);
        $criteria->compare('shipi',$this->shipi);
		$criteria->compare('krepezh',$this->krepezh);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('date_add',$this->date_add, 'LIKE');
        $criteria->compare('category',$this->category,true);
        $criteria->compare('country',$this->country,'LIKE');
        $criteria->compare('pic',$this->pic,'LIKE');
		$criteria->compare('date_modify',$this->date_modify,true);
        $criteria->compare('link',$this->link,'LIKE');
        $criteria->compare('ost',$this->ost);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function getId()
        {
            return 'item' . $this->id;
        }

        public function getPriceOut()
        {
            if( (int)$this->price == 0 )
            {
                return 'Звоните';
            }
            return number_format($this->price, 2, ",", " ");
            //return $this->price;
        }

        public function getPriceOther($price)
        {
            if( (int)$price == 0 )
            {
                return 'Звоните';
            }
            return number_format($price, 2, ",", " ");
            //return $this->price;
        }

        public function getMain_string()
        {
            return $this->main_string;
        }


        //проверка на существование строки в базе если ее нет то функция возвращет true
        public function NewString($string, $country)
        {
            $searchString = $this->count('main_string=:main AND country=:c', array(':main'=>$string, ":c"=>$country));
            if($searchString == 0)
            {
                return true;
            }
            return false;
        }

        // проверка цены у строк. Если цена обновилось у строки то возвращется ID этой строки
        public function NewPrice($string, $price, $country, $ost)
        {
            $searchString = $this->find('(main_string=:main AND country=:c AND price!=:p) OR (main_string=:main AND country=:c AND ost!=:ost)', array(':main'=>$string, ':p'=>$price, ":c"=>$country, ':ost'=>$ost));
            if(count($searchString) > 0)
            {
                if($searchString->price == $price && $searchString->ost == $ost) return false;
                return $searchString->id;
            }
            return false;
        }

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
    //выборка шин с ценой > 0 и находится в активном состоянии 1
    public function tire($id = '')
    {
        $criteria = new CDbCriteria();
        if(!empty($id))
        {
            $criteria->addCondition(
            array(
                'category = '.$id,
                '`price` > 0',
                "`type` = 'tire'",
            )
        );
        }
        else
        {
            $criteria->addCondition(
            array(
                '`price` > 0',
                "`type` = 'tire'",
            )
        );
        }
        $criteria->order = 'new_price DESC, active DESC';
        $criteria->compare('`d`', $this->d);
        $criteria->compare('`w`', $this->w);
        $criteria->compare('`hw`', $this->hw);
        $criteria->compare('`model`', $this->model, 'LIKE');
        $criteria->compare('`type_item`', $this->type_item);
        $criteria->compare('`season`', $this->season);
        $criteria->compare('`category`', $this->category);
        $criteria->compare('`main_string`', $this->main_string, 'LIKE');
        $criteria->compare('date_add',$this->date_add, 'LIKE');
        $criteria->compare('`price`', $this->price);
        $criteria->compare('country',$this->country,'LIKE');
        $criteria->compare('pic',$this->pic,'LIKE');
        $criteria->compare('`new_price`', $this->new_price);
        $criteria->compare('link',$this->link,'LIKE');
        $criteria->compare('ost',$this->ost);
        
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
    public function disc($id = '')
    {
        $criteria = new CDbCriteria();
        if(!empty($id))
        {
            $criteria->addCondition(
            array(
                'category = '.$id,
                '`price` > 0',
                "`type` = 'disc'",
            )
        );
        }
        else
        {
            $criteria->addCondition(
            array(
                '`price` > 0',
                "`type` = 'disc'",
            )
        );
        }
        $criteria->order = 'new_price DESC, active DESC';
        $criteria->compare('`d`', $this->d);
        $criteria->compare('`w`', $this->w);
        $criteria->compare('`stupica`', $this->stupica);
        $criteria->compare('`model`', $this->model, 'LIKE');
        $criteria->compare('`type_item`', $this->type_item);
        $criteria->compare('`krepezh`', $this->krepezh);
        $criteria->compare('`vilet`', $this->vilet);
        $criteria->compare('`category`', $this->category);
        $criteria->compare('`color`', $this->color, 'LIKE');
        $criteria->compare('`main_string`', $this->main_string, 'LIKE');
        $criteria->compare('date_add',$this->date_add, 'LIKE');
        $criteria->compare('`price`', $this->price);
        $criteria->compare('country',$this->country,'LIKE');
        $criteria->compare('pic',$this->pic,'LIKE');
        $criteria->compare('link',$this->link,'LIKE');
        $criteria->compare('ost',$this->ost);
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
    public function other($id = '')
    {
        $criteria = new CDbCriteria();
        if(!empty($id))
        {
            $criteria->addCondition(
            array(
                'category = '.$id,
                '`price` > 0',
                "`type` = 'other'",
            )
        );
        }
        else
        {
            $criteria->addCondition(
            array(
                '`price` > 0',
                "`type` = 'other'",
            )
        );
        }
        $criteria->order = 'new_price DESC, active DESC';
        $criteria->compare('`model`', $this->model, 'LIKE');
        $criteria->compare('`type_item`', $this->type_item);
        $criteria->compare('`category`', $this->category);
        $criteria->compare('`main_string`', $this->main_string, 'LIKE');
        $criteria->compare('date_add',$this->date_add, 'LIKE');
        $criteria->compare('`price`', $this->price);
        $criteria->compare('`marka`', $this->marka, 'LIKE');
        $criteria->compare('country',$this->country,'LIKE');
        $criteria->compare('pic',$this->pic,'LIKE');
        $criteria->compare('link',$this->link,'LIKE');
        $criteria->compare('ost',$this->ost);
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


    // получаем ID нужной нам модели
    // для определения ID модели передаем название модели и ищим ее в таблице model и после выдаем  ID
    public function ModelIdTire($ModelName)
    {
        $pattern = "!(.*?)[\s-]!ims";
	    preg_match_all($pattern, $ModelName, $model_id);
		$name = (isset($model_id[1][0])) ? $model_id[1][0] : '';
        $oboz['model_id'] = 0;
        if(!empty($name)) $oboz = OboznachenieModel::model()->cache(3600)->find("oboznach=:ob AND type='tire'", array(':ob'=>$name));

        return $oboz['model_id'];
    }
    public function ModelIdDisc($ModelName)
    {
        $pattern = "!(.*?)[\s-]!ims";
	    preg_match_all($pattern, $ModelName, $model_id);
		$name = (isset($model_id[1][0])) ? $model_id[1][0] : '';
        $oboz['model_id'] = 0;
        if(!empty($name)) $oboz = OboznachenieModel::model()->cache(3600)->find("oboznach=:ob AND type='disc'", array(':ob'=>$name));

        return $oboz['model_id'];
    }
    public function ModelIdOther($ModelName)
    {
        $pattern = "!(.*?)[\s-]!ims";
	    preg_match_all($pattern, $ModelName, $model_id);
		$name = (isset($model_id[1][0])) ? $model_id[1][0] : '';
        $oboz['model_id'] = 0;
        if(!empty($name)) $oboz = OboznachenieModel::model()->cache(3600)->find("oboznach=:ob AND type='other'", array(':ob'=>$name));

        return $oboz['model_id'];
    }

    //получаем имя нужной нам модели по ее id
    public function ModelName($id_model, $type)
    {
        $name = Models::model()->cache(3600)->find("id=:id AND type=:t", array(':id'=>$id_model, ':t'=>$type));
        return $name['model'];
    }

    ////////////////////////////////////////////////////////////////////////////
    /////////////////////////Получение массивов/////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////

    public function SeasonList()
    {
        return array(
                self::ITEM_SEASON_LETO => 'Лето',
                self::ITEM_SEASON_ZIMA => 'Зима',
                self::ITEM_SEASON_VSESEASON => 'Всесезонка',
            );
    }

    public function getSeason($s)
    {
        $season = $this->SeasonList();
        if(empty($season[$s])) return '';
        return $season[$s];
    }

    public function getTypeItem($type='tire')
    {
            $result = array();

            $type_item = Yii::app()->db->createCommand()->select('id, name, title, type')->from('type_item')->where("type='".$type."'")->queryAll();

            foreach($type_item as $val)
            {
                $result[$val['name']] = $val['title'];
            }

            return $result;
    }

    public function getTIA($type, $type_item)
    {
        $t_i = Yii::app()->db->createCommand()->select('id, name, title, type')->from('type_item')->where("type='".$type."' AND name='".$type_item."'")->queryRow();
        return $t_i['title'];
    }
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////

    public function getPic($pic)
    {
        $link_icon = "/images/picture_no.png";
        $image = "<div class='main_pic'></div>".CHtml::image($link_icon, '', array('prev'=>'', 'class'=>'prev'));
        if(file_exists(Yii::app()->getBasePath().'/..'.'/resources/images/'.$pic."_small.jpg"))
        {
            $link_img = '/resources/images/'.$pic."_small.jpg";
            $link_icon = "/images/picture.png";
            $image = "<div class='main_pic'></div>".CHtml::image($link_icon, '', array('prev'=>$link_img, 'class'=>'prev'));
        }


        return $image;
    }

    public function getItem($id)
    {
        $item = $this->findByPk($id);

        return $item;
    }


    public function AllItems($type = '', $type_item = '', $new_price = '', $season = '')
    {
            $data = array();
            foreach($type as $t){
               $criteria=new CDbCriteria;

               $criteria->order = 'season ASC, price DESC, model ASC';
               $criteria->compare('type', $t);
               $criteria->compare('active', 1);

               if(array_key_exists($t,$type_item) == 1){
                   if(count($type_item[$t]) > 0) $criteria->addInCondition('type_item', $type_item[$t]);
               }
               if(array_key_exists($t,$new_price) == 1){
                   if(count($new_price[$t]) > 0) $criteria->addInCondition('new_price', $new_price[$t]);
               }
               if(array_key_exists($t,$season) == 1){
                   if(count($season[$t]) > 0) $criteria->addInCondition('season', $season[$t]);
               }

               $builder = new CDbCommandBuilder(Yii::app()->db->getSchema());
               $command = $builder->createFindCommand('item', $criteria);
               $data[$t] = $command->queryAll();
            }
        return $data;
    }

    public function getLink($link)
    {
        $l = CHtml::link("Ссылка",$link, array("target"=>"_blank"));
        if(empty($link)) return '';
        return $l;
    }



}
