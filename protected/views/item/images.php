<h2>Фотографии элемента каталога</h2>
<?php if( count($imageList) == 0 ): ?>
    <p>Фотографий нет</p>
<?php else: ?>
    <div class="imagelist">        
        <?php foreach($imageList as $image): ?>
            <div class="oneimage">
                <?php
                    echo CHtml::link(
                        '<img src="' . $image->thumb_path . '" />',
                        $image->full_path,
                        array(
                            "target" => "_blank",
                        )
                    );
                ?>
                <br />
                <a href="<?php echo CHtml::normalizeUrl(
                    array(
                        'removeimage',
                        'itemid' => $image->item_id,
                        'id' => $image->id,
                    )); ?>">Удалить</a>
            </div>
        <?php endforeach; ?>
        <div class="clear"></div>
    </div>
<?php endif; ?>
