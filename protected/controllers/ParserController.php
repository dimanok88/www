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

                                if(empty($row[8])) $ost = '';
                                else $ost = $row[8];

                                if(empty($row[7])) $type_item = '';
                                else $type_item = $row[7];

                                if(empty($row[6])) $pic = '';
                                else $pic = $row[6];

                                if(empty($row[3])) $row[3] = '';
                                
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
                                    if(empty($row[4])) $season = '';
                                    else $season = $row[4];

                                    if(empty($row[5])) $shipi = '';
                                    else $shipi = $row[5];
                                }
                                //if(!empty($result)) echo $result['type']."<br>";
                                if(!empty($result))
                                {
                                    $item = new Item();
                                    $id_new = $item->NewPrice($main_string, $price, $country, $ost);

                                    if(!isset($_SESSION['new_price']) && $id_new != false)
                                    {
                                        $_SESSION['new_price'] = 'new';
                                        //echo $_SESSION['new_price'];
                                        $item->updateAll(array('new_price'=>'0'), 'type=:t', array(':t'=>$result['type']));
                                    }
                                    
                                    if($item->NewString($main_string, $country))
                                    {
                                        //echo 1;
                                        $item->attributes=$result;
                                        $item->main_string = $main_string;
                                        $item->price = $price;
                                        $item->pic = $pic;
                                        $item->season = $season;
                                        $item->shipi = $shipi;
                                        $item->ost = $ost;
                                        $item->type_item = $type_item;
                                        $item->country = $country;
                                        if($result['type'] == 'tire') $item->category = $item->ModelIdTire($result['model']);
                                        elseif($result['type'] == 'disc') $item->category = $item->ModelIdDisc($result['model']);
                                        elseif($result['type'] == 'other') $item->category = $item->ModelIdOther($result['model']);

                                        if( $item->save() )
                                        {
                                            //echo $item->id."<br/>";
                                            continue;
                                        }
                                        else echo "false<br/>";
                                    }
                                    elseif($id_new != false)
                                    {
                                        //echo $id_new."<br/>";
                                        $item->updateByPk($id_new,
                                                          array('price'=>$price, 'ost'=>$ost, 'new_price'=>'1', 'date_modify'=> new CDbExpression('NOW()')));
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
                        unset($_SESSION['new_price']);

                        //$this->redirect(array('index'));
                    }
                }

        $file = Item::model()->find('pic != ""');
        Yii::app()->cache->flush();
		$this->render('index', array('model'=>$model, 'file'=>$file));
	}

    public function UploadPic()
    {
            $file = Item::model()->find('pic != ""');
            $result = array();
            if(count($file) > 0)
            {
                $model = new Item();
                $files = $model->findAll('pic != ""');
                $imageHandler = new CImageHandler();

                foreach($files as $val)
                {
                    if(file_exists(Yii::app()->getBasePath() . '/..'.'/resources/upload/'.$val['pic']) && !file_exists(Yii::app()->getBasePath() . '/..'.'/resources/images/' . $val['pic']."_small.jpg"))
                    {
                        //$imageHandler->load (Yii::app()->getBasePath() . '/..'.'/resources/upload/'.$val['pic'])->save(Yii::app()->getBasePath() . '/..'.'/resources/images/' . $val['id']."_big.jpg");
                        $imageHandler->load (Yii::app()->getBasePath() . '/..'.'/resources/upload/'.$val['pic'])->thumb(Yii::app()->params['imgThumbWidth'],Yii::app()->params['imgThumbHeight'])->save(Yii::app()->getBasePath() . '/..'.'/resources/images/' . $val['pic']."_small.jpg");
                        $result[$val['id']] = $val['main_string'];
                        //sleep(1);
                        set_time_limit(0);
                    }
                }
            }
        return $result;
     }

    public function actionResizePhoto()
    {
        if( Yii::app()->request->isAjaxRequest )
		{
            $r = $this->UploadPic();
            $this->renderPartial('result_photo', array('result'=>$r));
        }
    }

    public function actionExcelSave()
    {
        //print_r($_POST);

        if (Yii::app()->request->isAjaxRequest) {
        if(isset($_POST['type'])){
           /* $objPHPExcel=Yii::app()->cache->get('excel');
            if($objPHPExcel===false)
            {
                $objPHPExcel = Yii::app()->excel;
                Yii::app()->cache->set('excel',$objPHPExcel, 3600);
            }*/
            $type = $_POST['type'];

            $type_item = array();
            if (isset($_POST['type_item'])) $type_item = $_POST['type_item'];
            $new_price = array();
            if (isset($_POST['new_price'])) $new_price = $_POST['new_price'];
            $season = array();
            if (isset($_POST['season'])) $season = $_POST['season'];
            $pr = '';
            if(isset($_POST['price'])) $pr = $_POST['price'];

            $data = Item::model()->AllItems($type, $type_item, $new_price, $season);

           /* $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Параметры');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Производитель');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Цена');*/

            $s = "\"Параметры\";\"Тип\";\"Производитель\";\"Цена\";\r\n";
            $i = 2;
            $type_obj = Item::model()->getTypeList();
            $ses = '';

            foreach($data as $item)
            {
                foreach($item as $key=>$value){
                    $string = $value['w']."/".$value['hw']." R".$value['d']." ".$value['model'];
                    $price = $value['price'];
                    $shipi = ' ';
                    if($value['shipi'] == 1) $shipi =  "Шипованая";
                    if($pr != '' && (array_key_exists($value['type'],$pr) && $pr[$value['type']] != 'ob')) $price = Percent::model()->getPercent($value['type'], $value['type_item'], $pr[$value['type']], $value['price']);
                    if($value['type'] == 'tire'){
                        if($ses != $value['season'])
                        {
                            $s_t = Item::model()->getSeason($value['season']);
                            $s .= "\"".$s_t."\";\r\n";
                            $ses = $value['season'];
                        }
                    }
                    /*$objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $string)
                    ->setCellValue('B'.$i, $value['country'])
                    ->setCellValue('C'.$i, $price)
                    ->setCellValue('D'.$i, $type_obj[$value['type']]);*/
                    $s .= "\"".$string."\";\"".$type_obj[$value['type']]."\";\"".$value['country']."\";\"".$price."\";\"".$shipi."\"\r\n";
                    $i++;
                }
            }

            // Rename sheet
            //$objPHPExcel->getActiveSheet()->setTitle('Price');

              // Set active sheet index to the first sheet,
              // so Excel opens this as the first sheet
             //$objPHPExcel->setActiveSheetIndex(0);

              // Redirect output to a client’s web browser (Excel2007)
              //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
              //header('Content-Disposition: attachment;filename="'.date('Y.m.d').'.xlsx"');
              //header('Cache-Control: max-age=0');

              //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
              //$objWriter->save('./resources/excel/'.date('Y.m.d').'.xlsx');
              $s = iconv('UTF-8','CP1251', $s);
              file_put_contents('./resources/excel/'.date('Y.m.d').'.csv', $s);
              echo CHtml::link('Скачать прайс', './resources/excel/'.date('Y.m.d').'.csv');
              echo "Отработало за ".sprintf('%0.5f',Yii::getLogger()->getExecutionTime())." с. Скушано памяти: ".round(memory_get_peak_usage()/(1024*1024),2)."MB";
              Yii::app()->end();
        }
        }
        $this->render('excel');
        //$objPHPExcel->saveExcel2007($objPHPExcel,"./resources/ss.xlsx");
    }

    public function actionNextFilter($type)
    {
        $type = explode(',', $type);
        $list = '';
        if(count($type) > 0 && $type[0] != '')
        {
            foreach($type as $val){
                $list[$val] = TypeItem::model()->type($val)->findAll();
            }
        }
        $this->renderPartial('_filterType', array('list'=>$list), false, true);
    }
}
