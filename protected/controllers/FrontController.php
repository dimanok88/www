<?php

class FrontController extends Controller
{
    public $layout = '//layouts/front';

    public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array(
                'allow',
				'users' => array('*'),
			),			
		);
	}

    public function actionIndex()
    {       
        $this->redirect(array('category/admin'));
    }

    public function actionError()
    {
        $error = Yii::app()->errorHandler->error;
        if( $error )
	    {
	    	if(Yii::app()->request->isAjaxRequest)
            {
	    		echo $error['message'];
            }
	    	else
            {
	        	$this->render('error', $error);
            }
	    }
    }
}

?>
