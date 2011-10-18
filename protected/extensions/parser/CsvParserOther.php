<?php

class CsvParserOther
{
	const TYPE_OTHER = 'other';
	
	public function run($string)
	{
		$methods = get_class_methods($this);
		foreach($methods as $method)
		{
			$type = $this->getType($string);
			if( mb_strcut($method, 0, 5) == 'parse' && mb_strcut($method, 5, 5) == $type )
			{
				$result = call_user_method($method, $this, $string, $type);
				if( !empty($result) )
				{
					return $result;
				}
			}
		}
		return array();
	}
        public function init()
	{
		//$this->publishAssets();
                return ;
	}
	
	public function getType($string)
	{
		return self::TYPE_OTHER;		
	}
	

	////////////////////////////////////////////////////////////////////////////////////////////////	
	///////////////////////////////////////////РАЗНОЕ////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////

	//Alpine | APF-M211TL | AV-интерфейс для головных устройств без ТВ-тюнера автомобилей Lexus  |
	public function parseother1($string, $type)
	{               
		if(count(explode('|', $string)) >=2 )
                {
                        $result = explode('|', $string);
                        //if(empty ($result)) echo "empty \n";
                        //print_r($result);

			return array(
				'type' => $type,
				'model' => trim($result[0]),
				'descript' => (empty($result[2])) ? 'описание отсутсвует' : trim($result[2]),
				'marka' => trim($result[1]),
			);
                }
		return array();
	}
}

?>
