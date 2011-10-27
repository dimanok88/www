<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>$type.'s-grid',
	'dataProvider'=>$list->$type($id),
	'filter'=>$list,
	'columns'=>array(
		'w',
        'hw',
        'd',
        'model',
        'type_item',
        'season',
		'main_string',
		'price',
        //'date_add',
		array(
            'class' => 'CButtonColumn',
            'header' => 'Действия',
            'template' => '{update} {delete}',
        ),
	),
));

/*$this->widget('zii.widgets.jui.CJuiDatePicker',
              array(
                   'name' => 'date_add',
                   'language' =>Yii::app()->getLanguage(),
                    'options' => array(
        	            'dateFormat'=>'yy-mm-dd',
        	            // user will be able to change month and year
        	            'changeMonth' => 'true',
        	            'changeYear' => 'true',
        	            // shows the button panel under the calendar (buttons like "today" and "done")
        	            'showButtonPanel' => 'true',
        	            // this is useful to allow only valid chars in the input field, according to dateFormat
        	            'constrainInput' => 'false',
        	            // speed at which the datepicker appears, time in ms or "slow", "normal" or "fast"
        	            'duration'=>'fast',
        	            // animation effect, see http://docs.jquery.com/UI/Effects
        	            'showAnim' =>'slide',
        	        ),
              ), true);


// declares a script binds the datepicker to fields you specify
Yii::app()->clientScript->registerScript('live_date_picker', "
                $('input[name=\"".CHtml::activeName($list, 'date_add')."\"]').live('focus', function(){
                        $(this).datepicker({ dateFormat: 'yy-mm-dd' });
        });
        ");
*/

?>


 
