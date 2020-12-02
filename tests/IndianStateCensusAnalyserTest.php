<?php
use PHPUnit\Framework\TestCase;

/**
 * Including required files to test
 */
require_once("../php/IndianStateCensusAnalyser.php");
require_once("../php/IndianCensusAnalyserException.php");

/**
 * @class -  IndianStateCensusAnalyserTest
 * @functions  - Test methods to test assertions
 */
class IndianStateCensusAnalyserTest extends TestCase
{
  /**Variable declaration */
  static $state_census_csv_path="../resources/StateCensusData.csv";
  static $state_code_csv_path="../resources/StateCode.csv";
  /**
   * Declaring variable for wrong file path and type
   */
  static $wrong_census_csv_path="../resources/src/StateCensusData.csv";
  static $wrong_census_csv_type="../resources/StateCensusData.txt";
  static $wrong_census_csv_delimiter="../resources/StateCensusDataWrongDelimiter.csv";
  static $wrong_code_csv_path="../resources/src/StateCode.csv";
  static $wrong_code_csv_type="../resources/StateCode.txt";
  static $wrong_code_csv_delimiter="../resources/StateCodeWrongDelimiter.csv";

  Protected $census_analyser;
  Protected $analyser_exception;

  /**
   * Setup for declaring objects
   */
  protected function setUp(): void
  {
      $this->census_analyser=new CensusAnalyser();
      $this->analyser_exception= new IndianCensusAnalyserException();
  }

  /**
   * Test method to check number of records matches in StateCensusData.csv file
   */
  public function testRecordsOfStateCensusCSVFile()
  {
      try
      {
        $this->assertEquals(29, $this->census_analyser->load_csv_file(self::$state_census_csv_path));
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
    
  }
  /**
   * Test method to check StateCensusData.csv file exists or not by passing wrong file path
  */

  public function testWrongStateCensusCSVFilePath()
  {
      try
      {
        $this->census_analyser->load_csv_file(self::$wrong_census_csv_path);
        $this->assertEquals(IndianCensusAnalyserException::CENSUS_FILE_PROBLEM, $this->census_analyser->load_csv_file(self::$wrong_census_csv_path));
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
  }

  /**
   * Test method to check StateCensusData.csv file exists or not by passing wrong file type
  */

  public function testWrongStateCensusCSVFileType()
  {
      try
      {
        $this->assertEquals(IndianCensusAnalyserException::CENSUS_FILE_PROBLEM, $this->census_analyser->load_csv_file(self::$wrong_census_csv_type));
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
  }

    /**
   * Test method to check StateCensusData.csv file exists or not by passing wrong file delimiter
  */

  public function testWrongStateCensusCSVFileDelimiter()
  {
      try
      {
        $this->census_analyser->load_csv_file(self::$wrong_census_csv_delimiter);
        $this->assertEquals(IndianCensusAnalyserException::CENSUS_FILE_PROBLEM, $this->census_analyser->load_csv_file(self::$wrong_census_csv_delimiter));
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
  }

  /**
   * Test method to check number of records matches in StateCode.csv file
   */

  public function testRecordsOfStateCodeCSVFile()
  {
      try
      {
        $this->assertEquals(37, $this->census_analyser->load_csv_file(self::$state_code_csv_path));
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }

  }

  /**
   * Test method to check StateCode.csv file exists or not by passing wrong file path
  */

  public function testWrongStateCodeCSVFilePath()
  {
      try
      {
        $this->census_analyser->load_csv_file(self::$wrong_code_csv_path);
        $this->assertEquals(IndianCensusAnalyserException::CENSUS_FILE_PROBLEM, $this->census_analyser->load_csv_file(self::$wrong_code_csv_path));
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
  }

  /**
   * Test method to check StateCode.csv file exists or not by passing wrong file type
  */

  public function testWrongStateCodeCSVFileType()
  {
      try
      {
        $this->census_analyser->load_csv_file(self::$wrong_code_csv_type);
        $this->assertEquals(IndianCensusAnalyserException::CENSUS_FILE_PROBLEM, $this->census_analyser->load_csv_file(self::$wrong_code_csv_type));
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
  }
  /**
   * Test method to check StateCode.csv file exists or not by passing wrong file delimiter
  */

  public function testWrongStateCodeCSVFileDelimiter()
  {
      try
      {
        $this->census_analyser->load_csv_file(self::$wrong_code_csv_delimiter);
        $this->assertEquals(IndianCensusAnalyserException::CENSUS_FILE_PROBLEM, $this->census_analyser->load_csv_file(self::$wrong_code_csv_delimiter));
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
  }

  /**
   * Test method to check Starting State name of StateCensusData.csv file data 
  */

  public function testToCheckStartStateOfStateCensusCSVFile()
  {
      try
      {
        $this->census_analyser->load_csv_file(self::$state_census_csv_path);
        $sort_object=new SortCSV();
        $this->census_analyser->sort_acending("State", $sort_object);
        $array=$this->census_analyser->data_array[0];
        $state_name=$array['State'];
        $this->assertEquals("Andhra Pradesh", $state_name);
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
  }
  /**
   * Test method to check Starting State name of StateCensusData.csv file data 
  */

  public function testToCheckEndStateOfStateCensusCSVFile()
  {
      try
      {
        $this->census_analyser->load_csv_file(self::$state_census_csv_path);
        $sort_object=new SortCSV();
        $this->census_analyser->sort_acending("State", $sort_object);
        $length=count($this->census_analyser->data_array)-1;
        $array=$this->census_analyser->data_array[$length];
        $state_name=$array['State'];
        $this->assertEquals("West Bengal", $state_name);
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
  }

  /**
   * Test method to check Starting State name of StateCode.csv file data 
  */

  public function testToCheckStartStateOfStateCodeCSVFile()
  {
      try
      {
        $this->census_analyser->load_csv_file(self::$state_code_csv_path);
        $sort_object=new SortCSV();
        $this->census_analyser->sort_acending("State", $sort_object);
        $array=$this->census_analyser->data_array[0];
        $state_name=$array['State'];
        $this->assertEquals("Andaman and Nicobar Islands", $state_name);
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
  }
  /**
   * Test method to check Starting State name of StateCode.csv file data 
  */

  public function testToCheckEndStateOfStateCodeCSVFile()
  {
      try
      {
        $this->census_analyser->load_csv_file(self::$state_code_csv_path);
        $sort_object=new SortCSV();
        $this->census_analyser->sort_acending("State", $sort_object);
        $length=count($this->census_analyser->data_array)-1;
        $array=$this->census_analyser->data_array[$length];
        $state_name=$array['State'];
        $this->assertEquals("West Bengal", $state_name);
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
  }

  /**
   * Test method to check number of sorting States StateCensusData.csv file data 
  */

  public function testToCheckNoOfSortedStateOfStateCensusCSVFile()
  {
      try
      {
        $this->census_analyser->load_csv_file(self::$state_census_csv_path);
        $sort_object=new SortCSV();
        $this->assertEquals(29, $this->census_analyser->sort_descending("sort_descending", $sort_object));
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
  }
}
?>