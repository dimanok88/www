<?php

class OrdersController extends Controller
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $criteria = new CDbCriteria();
            $criteria->condition = "id_order_list = ".$id;

            $dataProvider=new CActiveDataProvider('Orders',
                array(
                     'criteria' => $criteria,
                )
            );

        $order = OrdersList::model()->findByPk($id);
        
		$this->render('view',array(
			'dataProvider'=>$dataProvider, 'order'=>$order
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id = '')
	{
        $model=new Orders;

		if(!empty($id))
            $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Orders']))
		{
			$model->attributes=$_POST['Orders'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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

            Orders::model()->deleteAll('id_order_list=:ord', array(":ord"=>$id));

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
	public function actionIndex()
	{
		$model=new OrdersList('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Orders']))
			$model->attributes=$_GET['Orders'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OrdersList('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Orders']))
			$model->attributes=$_GET['Orders'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=OrdersList::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='orders-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionAddCart()
	{
		//if(isset($_POST))
		//{
			$model = new Item();
   			$item = $model->findByPk($_POST['add']);
   			Yii::app()->shoppingCart->put($item, $_POST['count']);
		//}
		$positions = Yii::app()->shoppingCart->getPositions();
		$this->renderPartial('_cart', array('positions'=>$positions));
	}
	public function actionRemoveCart()
	{
    	 Yii::app()->shoppingCart->clear();
    	 $this->renderPartial('_cart');
	}


    public function actionCart()
    {
        $positions = Yii::app()->shoppingCart->getPositions();
        //CVarDumper::dump($positions, 10, true);
        $array = array();

        if(isset($_POST['count']))
        {
            $count_new = $_POST['count'];

            foreach($count_new as $val=>$key)
       	    {
                $update_item = Item::model()->findByPk($val);
                Yii::app()->shoppingCart->update($update_item, $key);
	        }

            $this->refresh();
        }
        //$type_list = Item::model()->getTypeList();
        foreach($positions as $position) {
            $count = $position->getQuantity();
            $price = $position['price'];
            $type = $position['type'];
            $item_title = $position['main_string'];
            $id_item = $position['id'];
            $summ = $position->getSumPrice();

            $array[] = array('id'=>$id_item,
                             'string'=>$item_title,
                             'type'=>$type,
                             'count'=>$count,
                             'price'=>$price,
                             'summ'=>$summ,
            );
        }

        if(empty($array)) $data = new CArrayDataProvider($array);
        else $data = new CArrayDataProvider($array, array('keyField' => 'id'));

        $this->render('cart', array('items'=>$data));
    }

    public function actionDeleteOrd($id, $type)
    {
        if(!empty($id))
        {
            $model = Item::model()->findByPk($id);
            Yii::app()->shoppingCart->remove($model->getId());
        }
    }

    public function  actionAdd()
    {
        $order_list = new OrdersList();

        $order_list->id_user = $_POST['users'];
        $order_list->id_moderator = Yii::app()->user->id;
        $order_list->date_add = time();
        $order_list->type = 'prov';
        if($order_list->save())
        {
            $positions = Yii::app()->shoppingCart->getPositions();
            foreach($positions as $position) {
                $order = new Orders();
                $order->id_item = $position['id'];
                $order->id_order_list = $order_list->id;
                $order->count = $position->getQuantity();
                if($order->save()){
                    continue;
                    //$this->redirect(array('orders/'));
                }
            }
            Yii::app()->shoppingCart->clear();
        }
        $this->redirect(array('orders/'));
    }


    public function actionSchet($order)
    {
        $this->layout = '//layouts/none';

        $orders = OrdersList::model()->findByPk($order);
        $order_list_item = Orders::model()->findAll('id_order_list=:ord', array(':ord'=>$order));
        $user = Users::model()->getUserInfo($orders->id_user);

        $this->render('schet', array('order'=>$orders, 'order_list_item'=>$order_list_item, 'user'=>$user));
    }
}
