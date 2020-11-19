<?php
class StateCensusAnalyser
{
    //Using constructor for welcome message
    function __construct()
    {
        echo "=========================================================\n";
        echo "Welcome to Indian Census Analyser Problem \n";
        echo "=========================================================\n";
    }

    //Method to load State Census CSV data
    function load_state_census_csv_data()
    {
        try
        {
            //Checking file exists or not
            if(!file_exists("StateCensusData.csv"))
            {
                throw new Exception("StateCensusData.csv not found");       //Throw excedption
            }
            else
            {
                $file = fopen("StateCensusData.csv", "r");      //Opening CSV file
                $chunk_size = 1024*1024;                        //Size(1MB) to chunk file 
                while (!feof($file))
                {
                    //Getting file data according to chunk size
                    $data = fgetcsv($file, $chunk_size);
                    foreach($data as $arr)
                    {
                        echo $arr."\n";
                    }
                }
                fclose($file);      //Closing File
            }
        }
        catch(Exception $err)
        {
            //Getting error message into a variable
            $error_message=$err->getMessage();
        }
    }
}
class CSVStateCensus
{
    //Method to load CSV data
    function load_csv_data()
    {
        $state_cencus_analyser_class_object= new StateCensusAnalyser();     //Creating object of StateCensusAnalyser
        $state_cencus_analyser_class_object->load_state_census_csv_data();      //Calling method of StateCensusAnalyser
    }
}
//Object Declaration
$csv_state_census=new CSVStateCensus();     //Creating object of CSVStateCensus
$csv_state_census->load_csv_data();     //Calling method CSVStateCensus

?>