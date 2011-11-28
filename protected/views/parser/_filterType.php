<?
if(!empty($list)){
    $tabs = array();
    if(isset($list['tire']))
    {
        $item = CHtml::listData($list['tire'], 'name', 'title');
        $season = Item::model()->SeasonList();
        $tire = "<fieldset><legend>Типы шин</legend>".CHtml::checkBoxList('type_item[tire]', '', $item)."</fieldset>";
        $tire .= "<fieldset><legend>Сезон</legend>".CHtml::checkBoxList('season[tire]', '', $season)."</fieldset>";
        $tire .= "<br/>Новые ".CHtml::checkBox('new_price[tire][]');
        $tabs['Шины'] = $tire;
    }
    if(isset($list['disc']))
    {
        $item = CHtml::listData($list['disc'], 'name', 'title');
        $disc = "<fieldset><legend>Типы дисков</legend>".CHtml::checkBoxList('type_item[disc]', '', $item)."</fieldset>";
        $disc .= "<br/>Новые ".CHtml::checkBox('new_price[disc][]');
        $tabs['Диски'] = $disc;
    }
    if(isset($list['other']))
    {
        $item = CHtml::listData($list['other'], 'name', 'title');
        $other = "<fieldset><legend>Типы</legend>".CHtml::checkBoxList('type_item[other]', '', $item)."</fieldset>";
        $other .= "<br/>Новые ".CHtml::checkBox('new_price[other][]');
        $tabs['Разное'] = $other;
    }

    $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs'=>$tabs,
        // additional javascript options for the tabs plugin
        'options'=>array(
            'collapsible'=>true,
        ),
    ));

    echo CHtml::ajaxSubmitButton('Submit', array('parser/excelSave'), array(
        'type' => 'POST',
        'update' => '#needForm',
    ),
       array(
       'type' => 'submit',
       'id' => 'myButton',
       'name' => 'myButton'
    ));
}
?>
 
