<?php

class CDataColumnWithOptions extends CDataColumn
{
    public $filterOptions = array();

    protected function renderFilterCellContent()
	{
		if($this->filter!==false && $this->grid->filter!==null && $this->name!==null && strpos($this->name,'.')===false)
		{
			if(is_array($this->filter))
				echo CHtml::activeDropDownList($this->grid->filter, $this->name, $this->filter, array_merge($this->filterOptions, array('id'=>false,'prompt'=>'')));
			else if($this->filter===null)
				echo CHtml::activeTextField($this->grid->filter, $this->name, array_merge($this->filterOptions, array('id'=>false)));
			else
				echo $this->filter;
		}
		else
			parent::renderFilterCellContent();
	}
}

?>
