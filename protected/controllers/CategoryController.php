<?php
class CategoryController extends Controller
{
    public function actionListItem($id='', $type= '')
    {
        $list = new Item('tire');
        $nameModel = Item::model()->ModelName($id,$type);

        $this->render('listItem', array('list'=>$list, 'id'=>$id,'nameModel'=>$nameModel, 'type'=>$type));
    }

    public function actionAddCategory($id = '', $type = '')
    {
        $category = new Models();
        //echo $_GET['id'];
        if(!empty($id)) $category = Models::model()->findByPk($id);

        if(isset($_POST['Models']))
        {
            $category->attributes = $_POST[get_class($category)];
            $category->type = $type;

            if($category->save())
            {
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
}
?>
 
