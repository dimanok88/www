<?php

define('CSV_FILENAME', realpath(dirname(__FILE__).'/../tests/files') . '/1.csv');
define('CSV_DELIMITER', ';');

class ParserController extends Controller
{
	public $layout='//layouts/column2';

	private $_model;

	public function actionIndex()
	{
		$model = new PriceForm();
                if( isset($_POST['PriceForm']) )
                {
                    $model->file = CUploadedFile::getInstance($model, 'file');
                    if( $model->validate() )
                    {
                        $totalRows = 0;
                        $totalRowsDone = 0;
                        $parser_other = new CsvParserOther();
                        $parser_info = new CsvParserInfo();

                        if( ($handle = fopen($model->file->tempName, 'r')) !== FALSE )
                        {
                            while( ($row = fgetcsv($handle, 2000, CSV_DELIMITER)) !== FALSE )
                            {
                                if( empty($row[2]) )
                                {
                                        continue;
                                }

                                $totalRows++;
                                //echo $row[1]."\n";
                                $main_string= $row[0];
                                $type_item = $row[7];
                                $pic = $row[6];
                                if($row[3] == 'other')
                                {
                                     $result = $parser_other->run($row[0]);
                                     $price = trim($row[1]);
                                     $season = '';
                                     $shipi = '';
                                     $country = '';
                                }
                                else
                                {
                                    $result = $parser_info->run($row[0]);
                                    $country = $row[1];
                                    $price = trim($row[2]);
                                    $season = $row[4];
                                    $shipi = $row[5];
                                }
                                //if(!empty($result)) echo $result['type']."<br>";
                                if(!empty($result))
                                {
                                    $item = new Item();
                                    $id_new = $item->NewPrice($main_string, $price);
                                    
                                    if($item->NewString($main_string))
                                    {
                                        $item->attributes=$result;
                                        $item->main_string = $main_string;
                                        $item->price = $price;
                                        $item->pic = $pic;
                                        $item->season = $season;
                                        $item->shipi = $shipi;
                                        $item->type_item = $type_item;
                                        $item->country = $country;
                                        if($result['type'] == 'tire') $item->category = $item->ModelIdTire($result['model']);
                                        elseif($result['type'] == 'disc') $item->category = $item->ModelIdDisc($result['model']);
                                        elseif($result['type'] == 'other') $item->category = $item->ModelIdOther($result['model']);

                                        if( $item->save() )
                                        {
                                            continue;
                                        }
                                    }
                                    elseif($id_new != false)
                                    {
                                        $item->updateByPk($id_new, array('price'=>$price, 'date_modify'=> new CDbExpression('NOW()')));
                                    }
                                    set_time_limit(0);
                                }
                                //print_r($result);
                            }
                            fclose($handle);
                            Yii::app()->user->setFlash(
                                'price',
                                "Новый прайс загружен и обновлен! ".CHtml::link('Перейти в раздел.', array('item/'))
                            );
                        }

                        $this->redirect(array('index'));
                    }
                }

		$this->render('index', array('model'=>$model));
	}

        public function InsertDataBase($array)
        {

        }
}
