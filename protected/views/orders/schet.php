<p><b>Дата: </b> <?= Users::model()->getDate($order->date_add)?><br />
<b>Имя: </b>&nbsp;<?= $user->name;?><br />
<b>Телефон: </b>&nbsp;<?= $user->phone;?><br />
<b>E-mail: </b>&nbsp;<?= $user->email;?><br />
<p><b>Адрес Доставки:</b> <?= $user->address?></p>
<p><b>Комментарий: </b><br/>
   <?= $order->comment;?>
</p>
<hr>
<p><b><font size="5">Заказ № <?= $order->id; ?></font></b></p>
<p>&nbsp;</p>
<table border="0" width="92%" id="table1" cellspacing="0">
	<tr>
        <td width="5%" style="border-style: solid; border-width: 1px" align="center"><b>Количество</b></td>
		<td width="48%" style="border-style: solid; border-width: 1px" align="center"><b>Наименование товара</b></td>
		<td style="border-style: solid; border-width: 1px" width="20%" align="center"><b>Цена, шт.</b></td>
		<td width="20%" style="border-style: solid; border-width: 1px" align="center"><b>Сумма руб.</b></td>
	</tr>

        <?
         $type_price = $_GET['type_price'];
    foreach($order_list_item as $ord):
            $item = Item::model()->getItem($ord['id_item']);
        ?>
            <tr>
                <td width="5%" style="border-style: solid; border-width: 1px"><?= $ord['count']?></td>
                <td width="48%" style="border-style: solid; border-width: 1px"><?= $item->main_string; ?></td>
                <td style="border-style: solid; border-width: 1px" width="20%"><?= Item::model()->getPriceOther(Percent::model()->getPercent($item['type'], $item['type_item'], $type_price, $item->price)); ?></td>
                <td width="20%" style="border-style: solid; border-width: 1px"><?= Item::model()->getPriceOther(Percent::model()->getPercent($item['type'], $item['type_item'], $type_price, $item->price)*$ord['count']);?></td>
            </tr>
        <? endforeach; ?>

    <? $summ = Orders::model()->Summ($order->id, false, $_GET['type_price']);?>
	<tr>
		<td colspan="3" style="border-style: solid; border-width: 1px">
		<p align="right"><b>Итого: </b></td>
		<td width="20%" style="border-style: solid; border-width: 1px"><?= Item::model()->getPriceOther($summ); ?></td>
	</tr>

</table>
<?
$mt = new ManyToText();
$s = $mt->Convert($summ);
?>
<p><b>Сумма прописью: <?= $s;?>. Без НДС.</b></p>
<p>&nbsp;</p>
<p><b>Принял __________________________________________ </b></p>
<p>&nbsp;</p>
<p>&nbsp;</p>