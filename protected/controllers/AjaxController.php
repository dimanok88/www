<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nike
 * Date: 26.01.12
 * Time: 23:37
 * To change this template use File | Settings | File Templates.
 */
 
class AjaxController extends Controller{

    public function actionAutocomplete() {
        $term = Yii::app()->getRequest()->getParam('term');

        if(Yii::app()->request->isAjaxRequest && $term) {
            $criteria = new CDbCriteria;
            // формируем критерий поиска
            $criteria->addSearchCondition('name', $term, true, 'OR');
            $criteria->addSearchCondition('login', $term, true, 'OR');
            $criteria->addSearchCondition('email', $term, true, 'OR');
            $criteria->addSearchCondition('inn', $term, true, 'OR');
            $criteria->addSearchCondition('organization', $term, true, 'OR');
            $criteria->addSearchCondition('phone', $term, true, 'OR');
            $criteria->addSearchCondition('address', $term, true, 'OR');
            $criteria->addSearchCondition('bank', $term, true, 'OR');
            $criteria->addSearchCondition('bik', $term, true, 'OR');
            $criteria->addSearchCondition('info', $term, true, 'OR');
            $customers = Users::model()->cache(1000)->findAll($criteria);
            // обрабатываем результат
            $result = array();
            foreach($customers as $customer) {
                $lable = $customer['login'].' '.$customer['name']." - ".$customer['phone'];
                $result[] = array('id'=>$customer['id'], 'label'=>$lable, 'value'=>$lable);
            }
            echo CJSON::encode($result);
            Yii::app()->end();
        }
    }

}
