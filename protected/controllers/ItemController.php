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
        $model=new Item('tires'); //загрузка модели с возможностью поиска по шинам
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
        $model=new Item('discs');//загрузка модели с возможностью поиска по диска
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
}
?>
 
