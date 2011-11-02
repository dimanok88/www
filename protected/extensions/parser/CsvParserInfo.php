<?php

class CsvParserInfo
{
	const TYPE_DISC = 'disc';
	const TYPE_TIRE = 'tire';
	
	public function run($string)
	{
		$methods = get_class_methods($this);
		foreach($methods as $method)
		{
			$type = $this->getType($string);
			if( mb_strcut($method, 0, 5) == 'parse' && mb_strcut($method, 5, 4) == $type )
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
	
	public function getType($string)
	{
		if( preg_match('!^\s*\d{1,2}!iuU', $string) )
		{
			return self::TYPE_TIRE;
		}		

		return self::TYPE_DISC;
	}
	
	//6.40-13 М-100
	public function parsetire1($string, $type)
	{
		if( preg_match('!^(\d+\.\d+)-(\d{2})\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'w'=>$result[1],
				'd' => $result[2],
				'model' => $result[3],
			);
		}
		return array();
	}

        //31x10.5 R15LT Б/К Я-471
        public function parsetire2($string, $type)
	{
		if( preg_match('!^(\d{2})x(\d+\.\d+)\pZ+R(\d{2})LT\pZ+Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
				'hw' => $result[2],
			);
		}
		return array();
	}

        //7.50-16C К.Б/К SEHA KNK 126
        public function parsetire3($string, $type)
	{
		if( preg_match('!^(\d\.\d{2})-(\d{2})C\pZ+К\.Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}

        //185/75 R16 К.Б/К К-156-1
	public function parsetire4($string, $type)
	{
		if( preg_match('!^(\d{3})/(\d{2})\pZ+R(\d+)\pZ+К\.Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
				'hw' => $result[2],
			);
		}
		return array();
	}

        //10.00 R20 К.Б/К KORMORAN U (УНИВ)
        public function parsetire5($string, $type)
	{
		if( preg_match('!^(\d+\.\d+)\pZ+R(\d+)(?:C)?\pZ+К\.Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}

        //280-508R/10.00R20/ К.Б/К VM-201 TYREX
        public function parsetire6($string, $type)
	{
		if( preg_match('!^.*/(\d+\.\d+)R(\d+)/\pZ+К\.Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
	
	//6.15-13/155-13 И-151
	public function parsetire7($string, $type)
	{
		if( preg_match('!^(\d).(\d{2})-(\d{2})/(\d{3})-(\d{2})\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[3],
				'model' => $result[6],
				'w' => $result[4],
			);
		}
		return array();
	}
	
	//135/80 R12 Б/К КАМА-204
	public function parsetire8($string, $type)
	{
		if( preg_match('!^(\d{3})/(\d{2})\pZ+R(\d{2})\pZ+Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
				'hw' => $result[2],
			);
		}
		return array();
	}
	
	
	//175/70 R13 Я-380
	public function parsetire9($string, $type)
	{
		if( preg_match('!^(\d{3})/(\d{2})\pZ+R(\d{2})\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
				'hw' => $result[2],
			);
		}
		return array();
	}
	
	//215/90-15С/8.40-15 Я-245
	public function parsetire10($string, $type)
	{
		if( preg_match('!^(\d{3})/(\d{2})-(\d{2})./\d.\d{2}-\d{2}\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
				'hw' => $result[2],
			);
		}
		return array();
	}

	//185/75 R13C Б/К КАМА-231
    //195/75 R16C Б/К NOKIAN HAKKA C CARGO
	public function parsetire11($string, $type)
	{
		if( preg_match('!^(\d{3})/(\d{2})\pZ+R(\d{2})\pL\pZ+Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
				'hw' => $result[2],
			);
		}
		return array();
	}

	//185/R14C Б/К Я-538
    //185/R14C Б/К NOKIAN HAKKA C VAN
	public function parsetire12($string, $type)
	{
		if( preg_match('!^(\d{3})/R(\d{2})\pL\pZ+Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}

	//215/90 R15C Я-192
	public function parsetire13($string, $type)
	{
		if( preg_match('!^(\d{3})/(\d{2})\pZ+R(\d{2})C\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
				'hw' => $result[2],
			);
		}
		return array();
	}
	
	//195/R15C Я-390
	public function parsetire14($string, $type)
	{
		if( preg_match('!^(\d{3})/R(\d{2})C\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
	
	//31x10.5 R15LT Forward Safari 500
	public function parsetire15($string, $type)
	{
		if( preg_match('!^(\d{2})x(\d+\.\d+)\pZ+R(\d{2})LT\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
				'hw' => $result[2],
			);
		}
		return array();
	}

	//7.50-16C БРИ-317 12 сл.
	public function parsetire16($string, $type)
	{
		if( preg_match('!^(\d\.\d{2})-(\d{2})C\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
	//225/R16 К-151
	public function parsetire17($string, $type)
	{
		if( preg_match('!^(\d{3})/R(\d{2})\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
	//215/75 R17.5 Б/К К-166
	public function parsetire18($string, $type)
	{
		if( preg_match('!^(\d{3})/(\d{2})\pZ+R(\d+\.\d+)\pZ+Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
				'hw' => $result[2],
			);
		}
		return array();
	}
	//300-508R/11.00R20/ И-111АМ @
	public function parsetire19($string, $type)
	{
		if( preg_match('!^.*/(\d+\.\d+)R(\d{2})/\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
	//30x9.5 R15 Б/К BS D693
	public function parsetire20($string, $type)
	{
		if( preg_match('!^(\d{2})x(\d+\.\d+)\pZ+R(\d{2})\pZ+Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
				'hw' => $result[2],
			);
		}
		return array();
	}
	//7.50 R16 Б/К BS D694
	public function parsetire21($string, $type)
	{
		if( preg_match('!^(\d+\.\d+)\pZ+R(\d+)\pZ+Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
	//9.5 R17.5 Б/К BS M729(задн)
	public function parsetire22($string, $type)
	{
		if( preg_match('!^(\d+\.\d+)\pZ+R(\d+\.\d+)\pZ+Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
	//155 R12 Б/К HANKOOK W401 @
	public function parsetire23($string, $type)
	{
		if( preg_match('!^(\d+)\pZ+R(\d+)\pZ+Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
	//185/R14С Б/К NOKIAN HKPL C VAN @
	public function parsetire24($string, $type)
	{
		if( preg_match('!^(\d+)/\pL(\d+)\pL\pZ+Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{			
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
	//320-457/12.00-18 К-70
	public function parsetire25($string, $type)
	{
		if( preg_match('!^.*/(\d+\.\d+)-(\d+)\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
	//14.00-20 Я-307 18 сл.
	public function parsetire26($string, $type)
	{
		if( preg_match('!^(\d+\.\d+)-(\d{2})\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
	//7.50X20 ИЯ-112
	public function parsetire27($string, $type)
	{
		if( preg_match('!^(\d+\.\d+)X(\d{2})\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}

        //7.50 R16 Б/К BS D694
	public function parsetire28($string, $type)
	{
		if( preg_match('!^(\d+\.\d+)\pZ+R(\d+)(?:C)?\pZ+Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}

	//11 R22.5 Б/К Я-467 ЦМК
	public function parsetire29($string, $type)
	{
		if( preg_match('!^(\d+)\pZ+R(\d+\.\d+)(?:C)?\pZ+Б/К\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
	//1220X400-533 ИП-184-1
	public function parsetire30($string, $type)
	{
		if( preg_match('!^(\d+)X(\d+)-(\d+)\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[3],
				'hw' => $result[2],
				'model' => $result[4],
				'w' => $result[1],
			);
		}
		return array();
	}
	
	//10.00 R20 HN 08 (универс.) Aeolus
	public function parsetire31($string, $type)
	{
		if( preg_match('!^(\d+\.\d+)\pZ+R(\d+)(?:C)?(?:\pZ+Б/К)?\pZ+(.*)(?:\pZ+@)?$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////ДИСКИ////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////

        //Диски 5.5J14 ET40  D66.1 Евродиск NISSAN  (4x114.3) (53E40M) Almera Classic
        public function parsedisc1($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)J(\d+)\pZ+ET(\d+)\pZ+D(\d+\.\d+)\pZ+(Евродиск\pZ+.*)\pZ+\((.*?)\)\pZ+(\(.*?\)\pZ+.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'vilet' => $result[3],
				'stupica' => $result[4],
				'krepezh' => $result[6],
				'model' => $result[5],
				'w' => $result[1],
                                'color'=> $result[7],
			);
		}
		return array();
	}

        //Диски 6.0J15 ET52.5  D63.3 Евродиск FORD  (5x108) Black Focus 2
        public function parsedisc2($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)J(\d+)\pZ+ET(\d+\.\d+)\pZ+D(\d+\.\d+)\pZ+(Евродиск\pZ+.*)\pZ+\((.*?)\)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'vilet' => $result[3],
				'stupica' => $result[4],
				'krepezh' => $result[6],
				'model' => $result[5],
				'w' => $result[1],
                                'color'=> $result[7],
			);
		}
		return array();
	}

        //Диски 5.5J13 ET45  D67 Евродиск HYUNDAI  (4x114.3) (52E45H)
        public function parsedisc3($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)J(\d+)\pZ+ET(\d+)\pZ+D(\d+)\pZ+(Евродиск\pZ+.*)\pZ+\((.*?)\)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'vilet' => $result[3],
				'stupica' => $result[4],
				'krepezh' => $result[6],
				'model' => $result[5],
				'w' => $result[1],
                                'color'=> $result[7],
			);
		}
		return array();
	}

        //Диски 5.5J14 ET60  D65 KFZ FORD  (5x160) Tranzit арт.6250
        public function parsedisc4($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)J(\d+)\pZ+ET(\d+)\pZ+D(\d+)\pZ+(.*)\pZ+\((.*?)\)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'vilet' => $result[3],
				'stupica' => $result[4],
				'krepezh' => $result[6],
				'model' => $result[5],
				'w' => $result[1],
				'color' => $result[7],
			);
		}
		return array();
	}

        //Диски 8.0J18 ET40  D66.1 INFINITI 7  (5x114.3) HPB
	//Диски 8.0J18 ET46  D72.6 BMW 70      (5x120)   S
	public function parsedisc5($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)J(\d+)\pZ+ET(\d+)\pZ+D(\d+\.\d+)\pZ+(.*)\pZ+\((.*?)\)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'vilet' => $result[3],
				'stupica' => $result[4],
				'krepezh' => $result[6],
				'model' => $result[5],
				'w' => $result[1],
				'color' => $result[7],
			);
		}
		return array();
	}

        //Диски 6.0J15 ET52.5  D64 KWM FORD  (5x108) Black
        public function parsedisc6($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)J(\d+)\pZ+ET(\d+\.\d+)\pZ+D(\d+)\pZ+(.*)\pZ+\((.*?)\)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'vilet' => $result[3],
				'stupica' => $result[4],
				'krepezh' => $result[6],
				'model' => $result[5],
				'w' => $result[1],
				'color' => $result[7],
			);
		}
		return array();
	}

        public function parsedisc7($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)J(\d+)\pZ+ET(\d+)\pZ+D(\d+\.\d+)\pZ+(.*)\pZ+\((.*?)\)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'vilet' => $result[3],
				'stupica' => $result[4],
				'krepezh' => $result[6],
				'model' => $result[5],
				'w' => $result[1],				
			);
		}
		return array();
	}

        //Диски 5.5J14 ET49  Lanos Opel (4x100) Black
        public function parsedisc8($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)J(\d+)\pZ+ET(\d+)\pZ+(.*)\pZ+\((.*?)\)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'vilet' => $result[3],
				'krepezh' => $result[5],
				'model' => $result[4],
				'w' => $result[1],
                                'color' => $result[6],
			);
		}
		return array();
	}

        //Диски 6.0J15 ET39  D54 Geely, Hyundai (4x100)
        public function parsedisc9($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)J(\d+)\pZ+ET(\d+)\pZ+D(\d+)\pZ+(.*)\pZ+\((.*?)\)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'vilet' => $result[3],
				'stupica' => $result[4],
				'krepezh' => $result[6],
				'model' => $result[5],
				'w' => $result[1],
			);
		}
		return array();
	}

        //Диски 6.0J15 ET52.5  D63.3 Ford Focus  C-MAX (5x108)
        public function parsedisc10($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)J(\d+)\pZ+ET(\d+\.\d+)\pZ+D(\d+\.\d+)\pZ+(.*)\pZ+\((.*?)\)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'vilet' => $result[3],
				'stupica' => $result[4],
				'krepezh' => $result[6],
				'model' => $result[5],
				'w' => $result[1],
			);
		}
		return array();
	}

        //Диски 8.0J18 ET45  D72 MAK MISTRAL  (5x108) Gun Met-Mirror Face (F8080MSQ45GG3)
        public function parsedisc11($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)J(\d+)\pZ+ET(\d+)\pZ+D(\d+)\pZ+(.*)\pZ+\((.*?)\)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'vilet' => $result[3],
				'stupica' => $result[4],
				'krepezh' => $result[6],
				'model' => $result[5],
				'w' => $result[1],
                                'color'=> $result[7],
			);
		}
		return array();
	}

        //Диски 4.0J12  ET45  Евродиск TICO  (4x114.3)
        public function parsedisc12($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)J(\d+)\pZ+ET(\d+)\pZ+(Евродиск\pZ+.*)\pZ+\((.*?)\)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'vilet' => $result[3],
				'krepezh' => $result[5],
				'model' => $result[4],
				'w' => $result[1],
			);
		}
		return array();
	}

        ////Диски 4.0J12  ET37  ОКА
        public function parsedisc13($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)J(\d+)\pZ+ET(\d+)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
                                'vilet' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
			);
		}
		return array();
	}

        //Диски 5.0J16  НИВА 2121
	public function parsedisc14($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)J(\d+)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
        //Диски 6.00X17.5 ET115  Валдай
        public function parsedisc15($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)X(\d+\.\d+)\pZ+ET(\d+)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
                                'vilet' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
			);
		}
		return array();
	}
        //Диски 4.50ЕX16  ТР-Р Т-25А ПЕРЕДН.
        public function parsedisc16($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)EX(\d+)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
				'model' => $result[3],
				'w' => $result[1],
			);
		}
		return array();
	}
        //Диски 5.5FX20 ET0 СЕЯЛКА
        public function parsedisc17($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)FX(\d+)\pZ+ET(\d+)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
                                'vilet' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
			);
		}
		return array();
	}

        //Диски 6.00F-16 ET0 ТРАКТОР
        public function parsedisc18($string, $type)
	{
		if(preg_match('!^Диски\pZ+(\d+\.\d+)F-(\d+)\pZ+ET(\d+)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
                                'vilet' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
			);
		}
		return array();
	}

        //Диски W7X20 ET75  ТРАКТОР
        public function parsedisc19($string, $type)
	{
		if(preg_match('!^Диски\pZ+W(\d+)X(\d+)\pZ+ET(\d+)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
                                'vilet' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
			);
		}
		return array();
	}
        
        //Диски DW11X38 ET0 ТРАКТОР
        public function parsedisc20($string, $type)
	{
		if(preg_match('!^Диски\pZ+DW(\d+)X(\d+)\pZ+ET(\d+)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
                                'vilet' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
			);
		}
		return array();
        }

        //Диски DW9X20 ET121.5  D145 ТРАКТОР ХТЗ-5020
        public function parsedisc21($string, $type)
	{
		if(preg_match('!^Диски\pZ+DW(\d+)X(\d+)\pZ+ET(\d+\.\d+)\pZ+D(\d+)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
                                'vilet' => $result[3],
                                'stupica' => $result[4],
				'model' => $result[5],
				'w' => $result[1],
			);
		}
		return array();
	}

        //Диски W8X32 ET116.4  ТР-Р Т-25А (ЗАДН)
        public function parsedisc22($string, $type)
	{
		if(preg_match('!^Диски\pZ+W(\d+)X(\d+)\pZ+ET(\d+\.\d+)\pZ+(.*)$!isUu', $string, $result) )
		{
			return array(
				'type' => $type,
				'd' => $result[2],
                                'vilet' => $result[3],
				'model' => $result[4],
				'w' => $result[1],
			);
		}
		return array();
	}
        
}

?>
