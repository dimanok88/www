<?php

class PercentController extends Controller
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id = '', $type = 'tire')
	{
		$model= new Percent;
        if(!empty($id)) $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Percent']))
		{
            /*$v = $model->find('type=:t AND type_item=:t_i AND type_percent=:t_p',
                                          array(':t'=>$type, ':t_i'=>$_POST['Percent']['type_item'], ':t_p'=>$_POST['Percent']['type_percent']));
            if(count($v)) $model->updateByPk($v['id'], array('def'=>0));*/

			$model->attributes=$_POST['Percent'];
            $model->type = $type;
			if($model->save())
            {
				$this->redirect(array('percent/index', 'type'=>$type));
            }
		}

		$this->render('create',array(
			'model'=>$model, 'type'=>$type,
		));
	}
    
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			/*if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));*/
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($type = 'tire')
	{
        $t_p = Percent::model()->getTypePerc();

        foreach($t_p as $k=>$v){
            $criteria[$k] = new CDbCriteria();
            $criteria[$k]->condition = "`type` = :type AND type_percent='".$k."'";
            $criteria[$k]->params = array(
                ':type' => $type,
            );

            $dataProvider[$k]=new CActiveDataProvider('Percent',
                array(
                     'criteria' => $criteria[$k],
                     'pagination' => array(
                        'pageSize' => Yii::app()->params['countItemsByPage'],
                     )
                )
            );
        }
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'type'=>$type, 't_p'=>$t_p,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Percent::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='percent-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
