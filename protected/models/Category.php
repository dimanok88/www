<?php

class Category extends CActiveRecord implements ICategoryTree
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors()
    {
        return array(
            'categorytree' => array(
                'class' => 'application.extensions.categorytree.CategoryTreeBehaviour',
                'categoryLink' => 'front/category',
            ),
        );
    }

    public function getIdField()
    {
        return 'id';
    }

    public function getParentIdField()
    {
        return 'parent';
    }

    public function getNameField()
    {
        return 'name';
    }

	public function tableName()
	{
		return 'category';
	}

	public function rules()
	{
		return array(
			array('parent, name', 'required'),
			array('parent', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('code', 'length', 'max'=>64),
            array('text', 'safe'),
			
			array('id, parent, name', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
            'price_min' => array(
                self::STAT,
                'Item',
                'category_id',
                'select' => 'MIN(`t`.`cost`)',
            ),
            'price_max' => array(
                self::STAT,
                'Item',
                'category_id',
                'select' => 'MAX(`t`.`cost`)',
            ),
            'parentCategory' => array(
                self::HAS_ONE,
                'Category',
                '',
                'on' => '`t`.`parent` = `parentCategory`.`id`',
                'alias' => 'parentCategory',
            )
		);
	}

	public function attributeLabels()
	{
		return array(
			'auto_category_id' => 'Код',
			'parent' => 'Родительская категория',
			'name' => 'Название',
			'code' => 'Код',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('parent',$this->parent);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    public function beforeDelete()
    {
        $items = Item::model()->findAll(
            'category_id = :category_id',
            array(
                ':category_id' => $this->id,
            )
        );
        foreach($items as $item)
        {
            $item->delete();
        }
        return true;
    }
}
