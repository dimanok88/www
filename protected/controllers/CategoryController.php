<?php
class CategoryController extends Controller
{
    public function actionListItem($id='', $type= '')
    {
        $list = new Item($type);
        $list->unsetAttributes();  // clear any default values
		if(isset($_GET['Item']))
			$list->attributes=$_GET['Item'];

        $nameModel = Item::model()->ModelName($id,$type);

        $this->render('listItem', array('list'=>$list, 'id'=>$id,'nameModel'=>$nameModel, 'type'=>$type));
    }

    public function actionAddCategory($id = '', $type = '')
    {
        $category = new Models();
        $imageHandler = new CImageHandler();

        //echo $_GET['id'];
        if(!empty($id)) $category = Models::model()->findByPk($id);

        if(isset($_POST['Models']))
        {
            $category->attributes = $_POST[get_class($category)];
            $category->type = $type;
            //$category->pic = CUploadedFile::getInstance($category, 'pic');

            if($category->save())
            {
                $imageHandler->load ( $_FILES ['Models'] ['tmp_name'] ['pic'] )->save(Yii::app()->getBasePath() . '/..'.'/images/picmodel/' . $category->id."_big.jpg");
                $imageHandler->load ( $_FILES ['Models'] ['tmp_name'] ['pic'] )->thumb('159','43')->save(Yii::app()->getBasePath() . '/..'.'/images/picmodel/' . $category->id."_small.jpg");

                Yii::app()->user->setFlash(
                    'addcategory',
                    "Новая категория добавлена <b>".$category->model."</b>! "
                );
                if(!empty($id)){
                    Yii::app()->user->setFlash(
                    'addcategory',
                    "Категория <b>".$category->model."</b> отредактирована! "
                );
                }
                $this->redirect(array('item/category', 'type'=>$type));
            }
        }

        $this->render('addCategory', array('model'=>$category, 'type'=>$type));
    }

    public function actionDeleteCategory($id)
    {
		$cat = Models::model()->findbyPk($_GET['id']);
        $cat->delete();
        if(file_exists(Yii::app()->getBasePath() . '/..'.'/images/picmodel/' . $_GET['id']."_small.jpg"))
        {
            unlink(Yii::app()->getBasePath() . '/..'.'/images/picmodel/' . $_GET['id']."_small.jpg");
            unlink(Yii::app()->getBasePath() . '/..'.'/images/picmodel/' . $_GET['id']."_big.jpg");
        }

        Yii::app()->user->setFlash(
        'deletecategory',
        "Категория <b>".$cat->model."</b> удалена! ");

		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('item/category', 'type'=>$_GET['type']));
    }
}
?>
 
