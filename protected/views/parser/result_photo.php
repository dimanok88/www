<? if(count($result) > 0 ) { ?>
   <div class="flash-success">Изображения успешно обработаны</div>
<?} else {?>
   <div class="flash-notice">Все изображения были обработаны ранее</div>
<?}?>

<? echo "Отработало за ".sprintf('%0.5f',Yii::getLogger()->getExecutionTime())." с. Скушано памяти: ".round(memory_get_peak_usage()/(1024*1024),2)."MB";?>

