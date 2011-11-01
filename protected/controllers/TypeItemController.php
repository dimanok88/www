<?php

class TypeItemController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id = '', $type='tire')
	{
		$model=new TypeItem;
        if(!empty($id)) $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TypeItem']))
		{
			$model->attributes=$_POST['TypeItem'];
            $model->type = $type;
			if($model->save())
				$this->redirect(array('typeItem/index','type'=>$type));
		}

		$this->render('create',array(
			'model'=>$model, 'type'=>$type
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($type='tire')
	{
		$model= TypeItem::model()->type($type);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TypeItem']))
			$model->attributes=$_GET['TypeItem'];

		$this->render('admin',array(
			'model'=>$model, 'type'=>$type
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($type='tire')
	{
		$model=TypeItem::model()->type($type);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TypeItem']))
			$model->attributes=$_GET['TypeItem'];

		$this->render('admin',array(
			'model'=>$model, 'type'=>$type
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=TypeItem::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='type-item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
