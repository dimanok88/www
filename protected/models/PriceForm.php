<?php

class PriceForm extends CFormModel
{
    public $file;

    public function rules()
    {
        return array(
            array('file', 'required'),
            array('file', 'file', 'types' => 'csv', 'allowEmpty' => false, 'message'=>'Не правильный формат'),
        );
    }

    public function attributeLabels()
	{
		return array(
                    'file' => 'Файл',
		);
	}
}

?>
