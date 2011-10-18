<?php

class UploadCategoryForm extends CFormModel
{
    public $file;

    public function rules()
    {
        return array(
            array('file', 'required'),
            array('file', 'file', 'types' => 'csv', 'allowEmpty' => false),
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
