<?php

define('CSV_FILENAME', realpath(dirname(__FILE__).'/../tests/files') . '/1.csv');
define('CSV_DELIMITER', ';');

class ItemController extends Controller
{
	public $layout='//layouts/column2';

	private $_model;

	/*public function filters()
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
*/
	public function actionIndex()
	{
		

		$this->render('index');
	}
	public function actionCreate()
	{
		$model = new Item();

		if(isset($_POST[get_class($model)]))
		{
			$model->attributes=$_POST[get_class($model)];
			if( $model->save() )
            {
				$this->redirect(array('update', 'id' => $model->id));
            }
		}

		$this->render(
            'create',
            array(
                'model' => $model,
                'categoryList' => Category::model()->getCategoryListByTree(),
            )
        );
	}

	public function actionUpdate()
	{
		$model = $this->loadModel();
        $imageModel = new Images();

		if(isset($_POST[get_class($model)]))
		{
			$model->attributes=$_POST[get_class($model)];
			if( $model->save() )
            {
                $this->redirect(array('admin'));
            }
		}

        $tabs = array('tab1', 'tab2', 'tab3');
        $tab = $tabs[0];
        if( isset($_GET['tab']) )
        {
            if( in_array($_GET['tab'], $tabs) )
            {
                $tab = $_GET['tab'];
            }
        }

		$this->render(
            'update',
            array(
                'model' => $model,
                'imageModel' => $imageModel,
                'categoryList' => Category::model()->getCategoryListByTree(),
                'imageList' => Images::model()->findAll('item_id = :item_id', array(':item_id' => $_GET['id'])),
                'tab' => $tab,
            )
        );
	}

    public function actionImageupload()
    {
        $model = new Images;

        if( !isset($_GET['id']) )
        {
            $this->redirect( array('admin') );
        }
        
        if( isset($_POST['Images']) )
        {
            if( isset($_FILES['Images']['name']['photo']) && mb_strlen($_FILES['Images']['name']['photo']) > 0 )
            {
                $model->attributes = $_POST['Images'];
                $model->item_id = $_GET['id'];
                $model->photo = CUploadedFile::getInstance($model, 'photo');
                $this->addPhoto($model);
            }
        }

        $this->redirect( array('update', 'id' => $_GET['id'], 'tab' => 'tab2') );
    }

    public function actionRemoveimage()
    {
        if( !isset($_GET['id']) || !isset($_GET['itemid']) )
        {
            $this->redirect( array('admin') );
        }

        $image = Images::model()->findByPk($_GET['id']);
        if( !is_null($image) )
        {
            $image->delete();
        }

        $this->redirect( array('update', 'id' => $_GET['itemid'], 'tab' => 'tab2') );
    }

    private function addPhoto($photoModel)
    {
        $imageHandler = new CImageHandler();

        $uploadDir = realpath(Yii::app()->getBasePath() . '/..' . Yii::app()->params['uploadDir']);
        $imageDir = realpath(Yii::app()->getBasePath() . '/../resources/images/');

        $rootDir = realpath(Yii::app()->getBasePath() . '/..');

        $pathInfo = pathinfo($photoModel->photo->name);
        $photoModel->thumb_path = Yii::app()->params['uploadDir'] . md5($photoModel->photo->name . date('c')) . '.thumb.' . $pathInfo['extension'];
        $photoModel->full_path = Yii::app()->params['uploadDir'] . md5($photoModel->photo->name . date('c')) . '.' . $pathInfo['extension'];

        $imageHandler->load($photoModel->photo->tempName);

        $imageHandler->resizeInRect(
            Yii::app()->params['imgThumbWidth'],
            Yii::app()->params['imgThumbHeight']
        );
        $imageHandler->save($rootDir . $photoModel->thumb_path);

        $imageHandler->reload();
        
        $imageHandler->resize(
            Yii::app()->params['imgWidth'],
            Yii::app()->params['imgHeight']
        );
        $imageHandler->save($rootDir . $photoModel->full_path);

        return $photoModel->save();
    }

	public function actionDelete()
	{
        $this->loadModel()->delete();
        if( !isset($_GET['ajax']) )
        {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
	}

	public function actionAdmin()
	{
        $items = new Item('search');

        $items->unsetAttributes();
        if( isset($_GET[get_class($items)]) )
        {
			$items->attributes = $_GET[get_class($items)];
        }

		$this->render(
            'admin',
            array(
                'items' => $items,
            )
		);
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if( isset($_GET['id']) )
            {
				$this->_model = Item::model()->with('category')->findbyPk($_GET['id']);
            }
			if($this->_model === null)
            {
				throw new CHttpException(404, 'Позиция не найдена.');
            }
		}
		return $this->_model;
	}
}
