<h1>Выберите нужный вам раздел</h1>
<div>
    <ul class="main_part">
        <li><?= CHtml::link(CHtml::image('/images/shini.png').'<br/>Шины', array('item/tire')); ?></li>
        <li><?= CHtml::link(CHtml::image('/images/disc.jpg').'<br/>Диски', array('item/disc')); ?></li>
        <li><?= CHtml::link(CHtml::image('/images/sotra.jpg').'<br/>Разное', array('item/other')); ?></li>
    </ul>
</div>