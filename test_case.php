<?php
//Require file to include class
require_once 'indian_state_census_analyser.php';

//Creating class for testing
class TestCase
{
    //Declared variables with protected scope
    Protected $state_census_analyser_object;
    Protected $csv_state_census_object;

    //Method to set objects of testable classes
    function set_objects()
    {
        $this->state_census_analyser_object=new StateCensusAnalyser();      //Object of StateCensusAnalyser class
        $this->csv_state_census_object=new CSVStateCensus();        //Object of CSVStateCensus
    }

    //Method tp test State Census Data loading
    function test_to_load_state_cencus_csv_data()
    {
        //Calling methods and getting output in a variable
        $output=$this->state_census_analyser_object->load_state_census_csv_data();

        //Checking output is array or not
        if(!is_array($output))
        {
            error_log($output);
        }
    }

    //Method to sort States in alphabetical order and print in Json format
    function sort_state_census_data()
    {
        $sorted_output=$this->state_census_analyser_object->sort_state_census_analyser_data();
        echo json_encode($sorted_output);
    }
}
$test_object=new TestCase();
$test_object->set_objects();
$test_object->test_to_load_state_cencus_csv_data();
$test_object->sort_state_census_data();
?>