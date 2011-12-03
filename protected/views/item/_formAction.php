<?php
$select = '';
if (isset($_POST['action'])) $select = $_POST['action'];
echo CHtml::dropDownList('action', $select,
              array('del' => 'Удалить', 'on' => 'Включить', 'off' => 'Выключить'),
              array('empty' => ' - '));
echo CHtml::submitButton("Ok");