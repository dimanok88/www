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
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Item']))
			$model->attributes=$_GET['Item'];

		$this->render('other',array(
			'model'=>$model,
		));
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
        if(!empty($id)) $oboznach = OboznachenieModel::model()->findByPk($id);

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
			OboznachenieModel::model()->findbyPk($_GET['id'])->delete();

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
        $criteria->condition = "`type` = :type AND activate='1'";
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
}
?>
 
