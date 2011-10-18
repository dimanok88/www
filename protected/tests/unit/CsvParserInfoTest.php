<?php

define('CSV_FILENAME', realpath(dirname(__FILE__).'/../files') . '/12.csv');
define('CSV_DELIMITER', ';');

class CsvParserInfoTest extends CTestCase
{
	public $parser = null;
	
	public function setUp()
	{
		Yii::import('ext.parser.CsvParserInfo');
		$this->parser = new CsvParserInfo;
	}
	
	public function testGetType()
	{
		// test tire
		$this->assertEquals($this->parser->getType('225/75 R16C Б/К NOKIAN HKPL C CARGO @"'), CsvParserInfo::TYPE_TIRE);
		$this->assertEquals($this->parser->getType('185/55 R15 Б/К NOKIAN HKPL 7 @"'), CsvParserInfo::TYPE_TIRE);
		$this->assertEquals($this->parser->getType('280-508R/10.00R20/ И-185A"'), CsvParserInfo::TYPE_TIRE);
		$this->assertEquals($this->parser->getType('8.25 R16 HN 267 (передн) Aeolus"'), CsvParserInfo::TYPE_TIRE);
		
		// test disc
		$this->assertEquals($this->parser->getType('Диски 5.0J14  ET35  D57.1 KFZ VW / SKODA  (5x100) арт.5210'), CsvParserInfo::TYPE_DISC);
		$this->assertEquals($this->parser->getType('Диски 5.5J13 ET38  D58.6 ВИКОМ 137  (4x98) HS"'), CsvParserInfo::TYPE_DISC);
		$this->assertEquals($this->parser->getType('Диски 6.5J17 ET35  D60.1 LEXUS 6  (5x114.3) S"'), CsvParserInfo::TYPE_DISC);
		$this->assertEquals($this->parser->getType('Диски 8.0J18 ET40  D76 MAK MISTRAL  (5x114.3) Gun Met-Mirror Face (F8080MSQ40FF)"'), CsvParserInfo::TYPE_DISC);
	}
	
	public function testCsvFileExists()
	{
		$this->assertTrue(file_exists(CSV_FILENAME));
	}
	
	public function testParse()
	{
		$totalRows = 0;
    	$totalRowsDone = 0;
        	
		if( ($handle = fopen(CSV_FILENAME, 'r')) !== FALSE )
        {
            while( ($row = fgetcsv($handle, 2000, CSV_DELIMITER)) !== FALSE )
            {
                if( empty($row[3]) )
                {
                	continue;
                }
                
                $totalRows++;
                
                $result = $this->parser->run($row[0]);
                
                $this->assertFalse(empty($result), 'Error in: ' . $row[0] . " (~{$totalRows} row)");
            }
            fclose($handle);
        }
        
        $this->assertEquals($totalRows, $totalRowsDone);
	}
}

?>
