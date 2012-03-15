<p><b>Дата: </b> <?= Users::model()->getDate($order->date_add)?><br />
<b>ИП Григорьева  Елена Николаевна</b><br />
<b>ОГРН  308366806500060</b><br />
<b>ИНН 366101179094</b><br />
</p>
<hr>
<p><b><font size="5">Товарный чек № <?= $order->id; ?></font></b></p>
<p>&nbsp;</p>
<table border="0" width="92%" id="table1" cellspacing="0">
	<tr>
        <td width="5%" style="border-style: solid; border-width: 1px" align="center"><b>Количество</b></td>
		<td width="48%" style="border-style: solid; border-width: 1px" align="center"><b>Наименование товара</b></td>
		<td style="border-style: solid; border-width: 1px" width="20%" align="center"><b>Цена, шт.</b></td>
		<td width="20%" style="border-style: solid; border-width: 1px" align="center"><b>Сумма руб.</b></td>
	</tr>

        <? foreach($order_list_item as $ord):
            $item = Item::model()->getItem($ord['id_item']);
        ?>
            <tr>
                <td width="5%" style="border-style: solid; border-width: 1px"><?= $ord['count']?></td>
                <td width="48%" style="border-style: solid; border-width: 1px"><?= $item->main_string; ?></td>
                <td style="border-style: solid; border-width: 1px" width="20%"><?= Item::model()->getPriceOther($item->price); ?></td>
                <td width="20%" style="border-style: solid; border-width: 1px"><?= Item::model()->getPriceOther($item->price*$ord['count']);?></td>
            </tr>
        <? endforeach; ?>

    <? $summ = Orders::model()->Summ($order->id);?>
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
<p><b>Продавец: Кулагин А.Н.</b></p>
<p>&nbsp;</p>
<p>&nbsp;</p>