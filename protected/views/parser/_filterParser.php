<div class="filterPrice">
    <?= CHtml::beginForm();?>
        <div class="row">
		    <?php echo CHtml::checkBoxList('type', '', array('tire'=>'Шины', 'disc'=>'Диски', 'other'=>'Разное'), array('separator'=>' ', 'class'=>'formFilter')); ?>
	    </div>
    <div class="next_filter"></div>
    <?= CHtml::endForm();?>
</div>
<div id="needForm"></div>


<?
Yii::app()->clientScript->registerScript('search',
"
$('.formFilter').change(function(){
        var type = '';
        var a = [];
        $('.formFilter:checked').each(function(){
           a.push($(this).val());
        });
        type = a.join(',');

        $.ajax({
          type: 'GET',
          url: '".CHtml::normalizeUrl(array("parser/nextFilter"))."',
          data: {'type': type},
          success: function(data) {
                $('.next_filter').html(data);
          }
        });

});
");
?>