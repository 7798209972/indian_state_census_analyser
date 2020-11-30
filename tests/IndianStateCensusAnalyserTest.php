<?php
/**
 * Setting error log file to store errors
 */
ini_set("log_errors",TRUE);
$log_file="error.log";
ini_set("error_log",$log_file);

date_default_timezone_set("Asia/Kolkata");      //Setting default timezone

/**
 * Including required files to test
 */
require_once("../php/IndianStateCensusAnalyser.php");
require_once("../php/IndianCensusAnalyserException.php");

/**
 * @class -  IndianStateCensusAnalyserTest
 * @functions  - Test methods to test assertions
 */
class IndianStateCensusAnalyserTest extends PHPUnit\Framework\TestCase
{
  /**Variable declaration */
  static $state_census_csv_path="../resources/StateCensusData.csv";
  static $state_code_csv_path="../resources/StateCode.csv";
  Protected $census_analyser;
  Protected $code_analyser;
  Protected $analyser_exception;

  /**
   * Setup for declaring objects
   */
  protected function setUp(): void
  {
      $this->census_analyser=new StateCensusAnalyser();
      $this->code_analyser= new CSVStateCensus();
      $this->analyser_exception= new IndianCensusAnalyserException();
  }

  /**
   * Test method to check number of records matches in StateCensusData.csv file
   */
  public function testRecordsOfStateCensusCSVFile()
  {
      try
      {
        $this->assertEquals(29, $this->census_analyser->load_state_census_csv_data(self::$state_census_csv_path));
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
    
  }
  /**
   * Test method to check StateCensusData.csv file exists or not by passing wrong filename
  */

  public function testStateCensusCSVFile()
  {
      try
      {
        $file="../resources/StateCensusData1.csv";
        $this->census_analyser->load_state_census_csv_data($file);
        $this->assertFalse(file_exists($file));
        throw new Exception($this->analyser_exception->errorMessage($file, $this->analyser_exception->file_name_not_found));
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
  }

  /**
   * Test method to check StateCensusData.csv file exists or not by passing wrong file extension
  */

  public function testStateCensusCSVFileType()
  {
      try
      {
        $file="../resources/StateCensusData.txt";
        $this->assertFalse(file_exists($file));
        throw new Exception($this->analyser_exception->errorMessage($file, $this->analyser_exception->file_type_not_found));
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
        $csv_statcode_object= new CSVStateCensus();
        $this->assertEquals(37, $this->code_analyser->load_state_code_csv_data(self::$state_code_csv_path));
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }

  }

  /**
   * Test method to check StateCensusData.csv file exists or not by passing wrong filename
  */

  public function testStateCodeCSVFile()
  {
      try
      {
        $file="../resources/StateCode5.csv";
        $this->code_analyser->load_state_code_csv_data($file);
        $this->assertFalse(file_exists($file));
        throw new Exception($this->analyser_exception->errorMessage($file, $this->analyser_exception->file_name_not_found));
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
  }

  /**
   * Test method to check StateCensusData.csv file exists or not by passing wrong file extension
  */

  public function testStateCodeCSVFileType()
  {
      try
      {
        $file="../resources/StateCode.txt";
        $this->code_analyser->load_state_code_csv_data($file);
        $this->assertFalse(file_exists($file));
        throw new Exception($this->analyser_exception->errorMessage($file, $this->analyser_exception->file_type_not_found));
      }
      catch(Exception $err)
      {
        error_log($err->getMessage());
      }
  }
}

?>