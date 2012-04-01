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

        $user = Users::model()->findByPk($order['id_user']);
        
		$this->render('view',array(
			'dataProvider'=>$dataProvider, 'order'=>$order , 'type_price'=>$user['type_user']
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id = '')
	{
        $model=new OrdersList();

		if(!empty($id))
            $model=OrdersList::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrdersList']))
		{
			$model->attributes=$_POST['OrdersList'];
            $model->id_moderator = Yii::app()->user->id;
			if($model->save())
				$this->redirect(array('orders/'));
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

        $user = new Users();

        if(isset($_POST['Users']))
        {
            $this->AddUser($_POST['Users']);
        }



        $this->render('cart', array('userModel'=>$user));
    }


    public function actionCartItem()
    {
        $positions = Yii::app()->shoppingCart->getPositions();
        //CVarDumper::dump($positions, 10, true);
        $array = array();

        if(!Yii::app()->user->getState('user'))
        {
            $u = $_POST['users'];
            Yii::app()->user->setState('user', $u);
        }
        $user = Users::model()->findByPk(Yii::app()->user->getState('user'));
        $type_price = $user['type_user'];

        $total = 0;
        //$type_list = Item::model()->getTypeList();
        foreach($positions as $position) {
            $count = $position->getQuantity();
            $price = Percent::model()->getPercent($position['type'], $position['type_item'], $type_price, $position['price']);
            $type = $position['type'];
            $item_title = $position['main_string'];
            $id_item = $position['id'];
            //echo $position->getQuantity()." ".$price;
            $s = $position->getQuantity() * $price;
            $summ = $s;
            $total +=$summ;
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

        $this->render('cart_item', array('items'=>$data, 'user'=>Yii::app()->user->getState('user'), 'total'=>$total));
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
        if(isset($_POST['count']) && !isset($_POST['succ']))
        {
            $count_new = $_POST['count'];

            foreach($count_new as $val=>$key)
       	    {
                $update_item = Item::model()->findByPk($val);
                Yii::app()->shoppingCart->update($update_item, $key);
	        }

            $this->redirect(array('orders/cartItem'));
        }
        else{

        $order_list = new OrdersList();

        $order_list->id_user = Yii::app()->user->getState('user');
        $order_list->id_moderator = Yii::app()->user->id;
        $order_list->date_add = time();
        $order_list->type = '1';
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
    }


    public function actionSchet($order)
    {
        $this->layout = '//layouts/none';

        $orders = OrdersList::model()->findByPk($order);
        $order_list_item = Orders::model()->findAll('id_order_list=:ord', array(':ord'=>$order));
        $user = Users::model()->getUserInfo($orders->id_user);

        $this->render('schet', array('order'=>$orders, 'order_list_item'=>$order_list_item, 'user'=>$user));
    }

    public function actionClient($order)
    {
        $this->layout = '//layouts/none';

        $orders = OrdersList::model()->findByPk($order);
        $order_list_item = Orders::model()->findAll('id_order_list=:ord', array(':ord'=>$order));
        $user = Users::model()->getUserInfo($orders->id_user);

        $this->render('client', array('order'=>$orders, 'order_list_item'=>$order_list_item, 'user'=>$user));
    }

    public function actionChek($order)
    {
        $this->layout = '//layouts/none';

        $orders = OrdersList::model()->findByPk($order);
        $order_list_item = Orders::model()->findAll('id_order_list=:ord', array(':ord'=>$order));
        $user = Users::model()->getUserInfo($orders->id_user);

        $this->render('chek', array('order'=>$orders, 'order_list_item'=>$order_list_item, 'user'=>$user));
    }

    public function AddUser($post)
    {
        $model = new Users();

                if(isset($post))
                {

                    $model->attributes = $post;

                        $model->password = crypt($post['password'], substr($post['password'], 0, 2));
                        $model->password_req = crypt($post['password_req'], substr($post['password_req'], 0, 2));
                    if($model->save())
                    {
                        $this->refresh();
                    }
                }

    }
}
