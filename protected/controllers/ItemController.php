<?php
class ItemController extends Controller
{
    public function actionIndex()
	{
        $this->render('index');
	}

    //Визуальное представление для шин
    public function actionTires()
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
    public function actionDiscs()
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
}
?>
 
