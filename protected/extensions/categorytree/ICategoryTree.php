<?php

interface ICategoryTree
{
    /* индификатор отдельной категории */
    public function getIdField();

    /* индификатор родительской категории */
    public function getParentIdField();
}

?>
