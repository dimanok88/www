<li>
    <div style="float: right;">
        <?= CHtml::link('Изменить', array('create', 'id'=>$data->id, 'type'=>$type))?><br/>
        <?= CHtml::ajaxLink('Удалить', array('delete', 'id'=>$data->id) ,
                            array(
                                 'update'=>'.percent',
                                 'complete'=>'function(){ $.fn.yiiListView.update("percent"); return false;}',
                            ),
                            array('confirm'=>'Вы хотите удалить элемент списка?'))?>
    </div>
    
	<b><?php echo CHtml::encode($data->getAttributeLabel('percent')); ?>:</b>
	<?php echo CHtml::encode($data->percent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_item')); ?>:</b>
	<?php echo CHtml::encode($data->type_item); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('type_percent')); ?>:</b>
	<?php echo $per[$data->type_percent]; ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('ot')); ?>:</b><?php echo $data->ot; ?>
    <b><?php echo CHtml::encode($data->getAttributeLabel('do')); ?>:</b><?php echo $data->do; ?>

</li>