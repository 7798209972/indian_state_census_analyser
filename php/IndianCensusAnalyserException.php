<?php
/**
 * Class Declaration
 */
class IndianCensusAnalyserException extends Exception
{
  /**
   * Variable declaration
   */
  Public $file_name_not_found;
  Public $file_type_not_found;
  Public $file_delimeter_not_found;
  Public $message;

  /**
   * Default constructor to assign values to variables
   */
  public function __construct()
  {
    $this->file_name_not_found=1;
    $this->file_type_not_found=2;
    $this->file_delimeter_not_found=3;
  }

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