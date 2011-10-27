<li>
    <? $image = CHtml::image('/images/picmodel/'.$data->id."_small.jpg");?>
    <?= CHtml::link($image, array('category/listItem', 'id'=>$data->id, 'type'=>$type)); ?>
    <br/>
    <?= CHtml::link('Редактировать', array('category/addCategory', 'id'=>$data->id, 'type'=>$type))?>
    <?= CHtml::link('Удалить', array('category/deleteCategory', 'id'=>$data->id, 'type'=>$type), array('confirm'=>'Вы хотите удалить категорию?'))?>
</li>