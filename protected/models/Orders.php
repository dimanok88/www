<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $id
 * @property integer $id_item
 * @property integer $id_order_list
 * @property integer $date_add
 * @property integer $count
 */
class Orders extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Orders the static model class
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
		return 'orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_item, id_order_list, count', 'required'),
			array('id_item, id_order_list, count', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_item, id_order_list, count', 'safe', 'on'=>'search'),
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
			'id_item' => 'Предмет покупки',
			'id_order_list' => 'Заказ',
			'count' => 'Количество',
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
		$criteria->compare('id_item',$this->id_item);
		$criteria->compare('id_order_list',$this->id_order_list);
		$criteria->compare('count',$this->count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function AddCartBut($id, $type)
    {
        $but = CHtml::ajaxLink(
        	CHtml::image('/images/cart.jpg'), array("orders/addCart"),
                array
                (
                        "url"=>array("orders/addCart"),
                        "data"=>array("type"=>$type, "add"=>$id, "count"=>"js:$('#".$type.$id."').val()"),
                        "update"=>"#cart",
                        "type"=>"POST",
		                "beforeSend" => "js:function(){
		                    $('#message".$id."').addClass('loading');

		                }",
		                "success"=>"js:function(html){
		                 	setTimeout('$(\'#message".$id."\').removeClass(\'loading\')', 1000);
		                 	$('#message".$id."').addClass('success');
		                 	$('#cart').html(html); return false;
		                 }
		                ",
		                "complete" => "js:function(){
                        	setTimeout('$(\'#message".$id."\').removeClass(\'success\')', 1000); return false;
		           		}",
                )
        );

        return $but;
    }

    public function countRefresh($count, $id)
    {
        $it = CHtml::textField("count[".$id."]", $count, array('size'=>'5'));

        return $it;
    }

    public function Summ($id_orders_list, $format= false, $type = '')
    {
        $orders = $this->findAll('id_order_list=:ord_list', array(':ord_list'=>$id_orders_list));
        $summ = 0;
        foreach($orders as $ord)
        {
            $price_item = Item::model()->getItem($ord['id_item']);
            if(!empty($type))
                $summ += Percent::model()->getPercent($price_item['type'], $price_item['type_item'], $type, $price_item['price']) * $ord['count'];
            else
                $summ += $price_item['price'] * $ord['count'];
        }

        if($format == true ) return Item::model()->getPriceOther($summ);
        
        return $summ;
    }
}