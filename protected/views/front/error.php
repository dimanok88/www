<?php
    $this->pageTitle = "Ошибка {$code} - " . Yii::app()->name;
?>

<h1>Ошибка <?php echo $code; ?></h1>

<div class="error">
    <?php echo CHtml::encode($message); ?>
</div>
