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
                                if($row[3] == 'other')
                                {
                                     $result = $parser_other->run($row[0]);
                                     $price = $row[1];
                                }
                                else
                                {
                                    $result = $parser_info->run($row[0]);
                                    $price = $row[2];
                                }
                                //if(!empty($result)) echo $result['type']."<br>";
                                if(!empty($result))
                                {
                                    $item = new Item();
                                    $item->attributes=$result;
                                    $item->main_string = $main_string;
                                    $item->price = $price;
                                   
                                    if( $item->save() )
                                    {
                                        continue;
                                    }
                                }
                                //print_r($result);
                            }
                            fclose($handle);
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
