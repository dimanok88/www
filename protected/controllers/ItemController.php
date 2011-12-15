<?php
class ItemController extends Controller
{
    public $layout='//layouts/column2';
    
    public function actionIndex()
	{
        $this->render('index');
	}

    //Визуальное представление для шин
    public function actionTire()
    {
        $model=new Item('tire'); //загрузка модели с возможностью поиска по шинам
$url = "http://".$_SERVER['HTTP_HOST'].Yii::app()->request->getRequestUri();
		Yii::app()->user->setState('url_get', $url);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Item']))
			$model->attributes=$_GET['Item'];

		$this->render('tires',array(
			'model'=>$model,
		));
    }

    //Визуальное представление для дисков
    public function actionDisc()
    {
        $model=new Item('disc');//загрузка модели с возможностью поиска по диска
$url = "http://".$_SERVER['HTTP_HOST'].Yii::app()->request->getRequestUri();
		Yii::app()->user->setState('url_get', $url);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Item']))
			$model->attributes=$_GET['Item'];

		$this->render('discs',array(
			'model'=>$model,
		));
    }

    //Визуальное представление для разного
    public function actionOther()
    {
        $model=new Item('other');//загрузка модели с возможностью поиска по разному
$url = "http://".$_SERVER['HTTP_HOST'].Yii::app()->request->getRequestUri();
		Yii::app()->user->setState('url_get', $url);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Item']))
			$model->attributes=$_GET['Item'];

		$this->render('other',array(
			'model'=>$model,
		));
    }

    public function actionDelete()
    {
        if( Yii::app()->request->isPostRequest )
		{
			Item::model()->findbyPk($_GET['id'])->delete();
            if(file_exists(Yii::app()->getBasePath() . '/..'.'/resources/images/' . $_GET['id']."_small.jpg"))
            {
                unlink(Yii::app()->getBasePath() . '/..'.'/resources/images/' . $_GET['id']."_small.jpg");
                unlink(Yii::app()->getBasePath() . '/..'.'/resources/images/' . $_GET['id']."_big.jpg");
            }

			if( !isset($_GET['ajax']) )
            {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('item/'));
            }
		}
		else
        {
			throw new CHttpException(400, 'Ошибка в запросе.');
        }
    }

    public function actionUpnew($id = '', $type= '', $model_id= '')
    {
        $item = new Item();
        $url = Yii::app()->user->getState('url_get');
        $imageHandler = new CImageHandler();

        if(!empty($id)) $item = Item::model()->findByPk($id);

        if(isset($_POST['Item']))
        {
            $item->attributes = $_POST[get_class($item)];
            $item->type = $type;
            //$category->pic = CUploadedFile::getInstance($category, 'pic');

            if($item->save())
            {
                if(!empty($_FILES ['Item'] ['tmp_name'] ['pictures'])){
                    $imageHandler->load ( $_FILES ['Item'] ['tmp_name'] ['pictures'] )->save(Yii::app()->getBasePath() . '/..'.'/resources/images/' . $item->id."_big.jpg");
                    $imageHandler->load ( $_FILES ['Item'] ['tmp_name'] ['pictures'] )->thumb(Yii::app()->params['imgThumbWidth'],Yii::app()->params['imgThumbHeight'])->save(Yii::app()->getBasePath() . '/..'.'/resources/images/' . $item->id."_small.jpg");
                }

                Yii::app()->user->setFlash(
                    'addcategory',
                    "Новый элемент <b>".$item->model."</b> добавлен!"
                );
                if(!empty($id)){
                    Yii::app()->user->setFlash(
                    'addcategory',
                    "Элемент <b>".$item->model."</b> отредактирован! "
                );
                }
                if(Yii::app()->request->isAjaxRequest)
                {
                    echo '<script>
                        $( "#edit_dialog" ).dialog( "close" );
                        $.fn.yiiGridView.update("itemGrid",{data:data});
                        //return false;
                    </script>';
                    Yii::app()->end;
                }
                $this->redirect($url);
            }
        }

        if(Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('upnew',array('model'=>$item, 'type'=>$type), false, true);
        }
        else {
            $this->render('upnew', array('model'=>$item, 'type'=>$type));
        }

    }

    ///////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////Обозначения///////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////
    //Вывод списка обозначений
    public function actionOboznach($type)
    {
        $oboznach = OboznachenieModel::model()->oboz($type);

        $oboznach->unsetAttributes();  // clear any default values
		if(isset($_GET['OboznachenieModel']))
			$oboznach->attributes=$_GET['OboznachenieModel'];
        
        $this->render('oboznach',array(
			'model'=>$oboznach, 'type'=>$type
		));
    }

    // Добавить обозначение
    public function actionAddOboznach($type, $id= '')
    {
        $oboznach = new OboznachenieModel();
        //echo $_GET['id'];
        if(!empty($id)) $oboznach = OboznachenieModel::model()->cache(3600)->findByPk($id);

        if(isset($_POST['OboznachenieModel']))
        {
            $oboznach->attributes = $_POST[get_class($oboznach)];
            $oboznach->type = $type;

            if($oboznach->save())
            {
                Yii::app()->user->setFlash(
                    'addoboz',
                    "Новое обозначение добавлено <b>".$oboznach->oboznach."</b>! "
                );
                if(!empty($id)){
                    Yii::app()->user->setFlash(
                    'addoboz',
                    "Обозначение <b>".$oboznach->oboznach."</b> отредактировано! "
                );
                }
                $this->redirect(array('item/oboznach', 'type'=>$type));
            }
        }

        $this->render('addOboznach', array('model'=>$oboznach, 'type'=>$type));
    }

    public function actionDeleteOboznach()
    {
        if( Yii::app()->request->isPostRequest )
		{
			OboznachenieModel::model()->cache(3600)->findbyPk($_GET['id'])->delete();

			if( !isset($_GET['ajax']) )
            {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('item/'));
            }
		}
		else
        {
			throw new CHttpException(400, 'Ошибка в запросе.');
        }
    }
    //////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////Категории///////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////
    //Вывод категорий по типу
    public function actionCategory($type)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = "`type` = :type";
        $criteria->params = array(
            ':type' => $type,
        );
        $category = new CActiveDataProvider('Models',
            array(
                 'criteria' => $criteria,
                 'pagination' => array(
                    'pageSize' => Yii::app()->params['countItemsByPage'],
                 )
            )
        );

        $this->render('category', array('category'=>$category, 'type'=>$type));
    }
    //////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////

    public function actionAct()
    {
        $url = Yii::app()->user->getState('url_get');
        if(isset($_POST['action']))
        {
            $act = $_POST['action'];
            $id = '';
            if(isset($_POST['item_check'])) $id = $_POST['item_check'];
            switch($act){
                case 'del':
                    Item::model()->deleteByPk($id);
                break;
                case 'on':
                    Item::model()->updateByPk($id, array('active'=>'1'));
                break;
                case 'off':
                    Item::model()->updateByPk($id, array('active'=>'0'));
                break;
            }
        }
        $this->redirect($url);
    }
}
?>
 
