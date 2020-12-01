<?php
/**
 * Class Declaration
 */
class IndianCensusAnalyserException extends Exception
{
  /**
   * Variable declaration
   */
  public const CENSUS_FILE_PROBLEM="Please enter valid file path";

  /**
   * Default constructor to assign values to variables
   */
  // public function __construct()
  // {
  //   $this->file_name_not_found=1;
  //   $this->file_type_not_found=2;
  //   $this->file_delimeter_not_found=3;
  // }

  /**
   * Method to get error message according to error type
   */
  public function errorMessage($text,$type)
  {
    // switch case to check type of exception
    switch($type)
    {
      case $this->file_name_not_found:
        $this->message="$text not found, Invalid file name";
      break;
      case $this->file_type_not_found:
        $this->message="$text not found, Invalid file type";
      break;
      case $this->file_delimeter_not_found:
        $this->message="$text has not been found, Invalid delimeters";
      break;
      default:
    }
    return $this->message;      //Return error message according to error type
  }
}
  ?>