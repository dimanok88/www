<?php
class ItemController extends Controller
{
    public function actionIndex()
	{
        $this->render('index');
	}

    public function actionTires()
    {
        $model=new Item('tires');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Item']))
			$model->attributes=$_GET['Item'];

		$this->render('tires',array(
			'model'=>$model,
		));
    }

    public function actionDiscs()
    {
        $model=new Item('discs');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Item']))
			$model->attributes=$_GET['Item'];

		$this->render('discs',array(
			'model'=>$model,
		));
    }

    public function actionOther()
    {
        $model=new Item('other');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Item']))
			$model->attributes=$_GET['Item'];

		$this->render('other',array(
			'model'=>$model,
		));
    }
}
?>
 
