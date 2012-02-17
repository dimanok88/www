<?php

define('CSV_DELIMITER', ';');
/**
 * Created by JetBrains PhpStorm.
 * User: nike
 * Date: 02.12.11
 * Time: 16:25
 * To change this template use File | Settings | File Templates.
 */
 
class UsersController extends Controller {

    public function actionIndex()
    {
        if (!Yii::app()->user->isGuest){
            $this->redirect(array('item/'));
        }
        $this->redirect(array('users/login'));
    }

    public function actionLogin()
	{
		$model=new LoginForm();

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
            {
				$this->redirect(Yii::app()->user->returnUrl);
            }
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    // Список пользователей 
    public function actionListUsers(){
        $model=new Users('search'); //загрузка модели с возможностью поиска по шинам

        $url = "http://".$_SERVER['HTTP_HOST'].Yii::app()->request->getRequestUri();
		Yii::app()->user->setState('url_get', $url);

		$model->unsetAttributes();  // clear any default values
		if( isset($_GET[get_class($model)]) )
        {
			$model->attributes = $_GET[get_class($model)];
        }
        $this->render('listUsers', array('model'=>$model));
    }
    ////////////////////////////////////////////

    //Добавление и редактирование пользователя. Если id = '' тогда новый пользователь иначе происходит редактирование
    public function actionNewed($id='')
    {
        $model = new Users();

        $url = Yii::app()->user->getState('url_get');

        if(!empty($id)) $model = Users::model()->findByPk($id);

        if(isset($_POST['Users']))
        {
            if($id != '') $pass = $model->password;
            
            $model->attributes = $_POST[get_class($model)];
            if(empty($_POST[get_class($model)]['password']) && $id != '')
            {
                $model->password = $pass;
                $model->password_req = $model->password;
            }
            else
            {
                $model->password = crypt($_POST[get_class($model)]['password'], substr($_POST[get_class($model)]['password'], 0, 2));
                $model->password_req = crypt($_POST[get_class($model)]['password_req'], substr($_POST[get_class($model)]['password_req'], 0, 2));
            }
            if($model->save())
            {
                $this->redirect($url);
            }
        }

        $this->render('newed', array('model'=>$model));
    }
    ////////////////////////////////////////////

    //Удаление пользователя
    public function actionDelete()
    {
        if( Yii::app()->request->isPostRequest )
		{
			Users::model()->findbyPk($_GET['id'])->delete();

			if( !isset($_GET['ajax']) )
            {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('users/listUsers'));
            }
		}
		else
        {
			throw new CHttpException(400, 'Ошибка в запросе.');
        }
    }

    //Просмотр данных пользователя найденых через autoComplete
    public function actionViewUser($ids)
    {
        $user = Users::model()->findByPk($ids);
        $this->render('viewUser', array('user'=>$user));
    }


    public function actionAuth()
    {
        Yii::import('application.vendors.*');
        require_once('Zend/Dom/Query.php');

        $link_param = array(
            '0'=>'102200020',
            '1'=>'200000020',
            '2'=>'400000020',
        );

        foreach($link_param as $link_p){
            $page= array('0'=>'1');

            $obj = CurlAuth::init() ->login('http://www.autoshinavrn.ru/index.php')->load('http://www.autoshinavrn.ru/setuser.php?user=romachu');
            $result =  $obj->load('http://www.autoshinavrn.ru/viewpage.php?page_id=1&parms='.$link_p.'1')->content;
            //echo $result;

            $dom = new Zend_Dom_Query($result);
            $result_page = $dom->query('//table.spacer//th//a.side');

            foreach($result_page as $p)
            {
               if(is_numeric($p->nodeValue))
                   $page[] = $p->nodeValue;
            }

            $ar = array();
            $mas2 = array();
            foreach($page as $p_n){
                //echo $p_n."<br/>";
                if($p_n > 1) break;
                $result =  $obj->load('http://www.autoshinavrn.ru/viewpage.php?page_id=1&parms='.$link_p.$p_n)->content;
                $dom = new Zend_Dom_Query($result);
                $results = $dom->query('//table.tbl-border/tr');

                $i = 0;
                foreach ($results as $res) {
                    if(($i != 0 && $i != 1) && $i != count($results)-1 && $i != count($results)-2){
                        $k = 0;
                       foreach($res->childNodes as $ch)
                       {
                           if($k == 0 || $k == 2 || $k == 4){
                               $string = rtrim(preg_replace('/\\s+$/i','', $ch->nodeValue));
                               if($k == 0){
                                   $s = trim(preg_replace('/\(Остаток.*$/i','',str_replace(" «фото»", "", $string)));
                                   $t = preg_replace('!\pZ+$!i', '', urlencode($s));
                                   $t = str_replace('%C2%A0', '',$t);
                                   $t = urldecode($t);
                                   //$t = iconv('UTF-8','WINDOWS-1251', $t);
                                   //$t =  trim(mb_convert_encoding($t, 'koi8-r', 'utf-8'));
                                   preg_match_all("!(.*)\s+(.*?)$!i", trim($t), $r);
                                   $ar[$p_n][$i][$k] = $r[1][0];
                                   $ar[$p_n][$i]['country'] = $r[2][0];
                               }
                               elseif($k==2)
                               {
                                   $ar[$p_n][$i][$k] = str_replace(' ', '',preg_replace('/\(.*$/i','', $string));
                               }
                               else $ar[$p_n][$i][$k] = trim($string);
                           }
                           $k++;
                       }
                    }
                    set_time_limit(0);
                    $i++;
                }
                $mas2 = array_merge($ar[$p_n], $mas2);
                sleep(4);
            }

            $new_str = "\"string\";\"country\";\"price\";\"type\";\"season\";\"shipi\";\"filepic\";\"type_item\";\"ostatok\";\r\n";
            foreach($mas2 as $str)
            {
                $new_str .= "\"".$str[0]."\";\"".$str['country']."\";\"".$str[2]."\";;;;;;\"".$str[4]."\";\r\n";
            }

            $name = '';
            if($link_p == '102200020') $name = 'tire';
            elseif($link_p == '200000020') $name = 'disc';
            elseif($link_p == '400000020') $name = 'gruz';

            file_put_contents('./resources/excel/'.date('Y.m.d').'_'.$name.'.csv', $new_str);
            $this->upload_price(date('Y.m.d').'_'.$name.'.csv');
        }

    }

    public function upload_price($file)
	{
		$model = new PriceForm();
                if(file_exists(Yii::app()->getBasePath() . '/../resources/excel/'.$file))
                {
                    $model->file = Yii::app()->getBasePath() . '/../resources/excel/'.$file;
                    //if( $model->validate(false) )
                    //{
                        $totalRows = 0;
                        $totalRowsDone = 0;
                        $parser_other = new CsvParserOther();
                        $parser_info = new CsvParserInfo();

                        if( ($handle = fopen($model->file, 'r')) !== FALSE )
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
                                    $item = new Item2();
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
                    //}
                }

        //$file = Item::model()->find('pic != ""');
        //Yii::app()->cache->flush();
		//$this->render('index', array('model'=>$model, 'file'=>$file));
	}

}