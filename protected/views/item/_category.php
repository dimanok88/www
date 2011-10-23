<li>
    <? $image = CHtml::image('/images/picmodel/'.$data->id."_big.jpg");?>
    <?= CHtml::link($image, array('category/listItem', 'id'=>$data->id, 'type'=>$type)); ?>
    <br/>
    <?= CHtml::link('Редактировать', array('category/addCategory', 'id'=>$data->id, 'type'=>$type))?>
    <?= CHtml::link('Удалить', array('category/deleteCategory', 'id'=>$data->id))?>
</li>