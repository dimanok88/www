<h2><?= $nameModel; ?></h2>

<?= $this->renderPartial('_category_'.$type, array('id'=>$id, 'list'=>$list, 'type'=>$type)); ?>