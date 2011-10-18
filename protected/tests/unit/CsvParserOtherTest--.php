<?php

define('CSV_FILENAME1', realpath(dirname(__FILE__).'/../files') . '/1.csv');
define('CSV_DELIMITER1', ';');

class CsvParserOtherTest extends CTestCase
{
	public $parser = null;
	
	public function setUp()
	{
		Yii::import('ext.parser.CsvParserOther');
		$this->parser = new CsvParserOther;
	}
	
	public function testCsvFileExists()
	{
		$this->assertTrue(file_exists(CSV_FILENAME1));
	}
	
	public function testParse()
	{
		$totalRows = 0;
    	$totalRowsDone = 0;
        	
		if( ($handle = fopen(CSV_FILENAME1, 'r')) !== FALSE )
        {
            while( ($row = fgetcsv($handle, 2000, CSV_DELIMITER1)) !== FALSE )
            {
                if( empty($row[2]) )
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
