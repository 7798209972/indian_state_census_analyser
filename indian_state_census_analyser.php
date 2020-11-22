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
                $state_census_data_array=array();
                $whole_state_census_data_array=array();
                $state_census_file = fopen("StateCensusData.csv", "r");      //Opening CSV file
                $state_census_chunk_size = 1024*1024;                        //Size(1MB) to chunk file 
                $row=0;
                if(!feof($state_census_file))
                {
                    while(($state_census_data = fgetcsv($state_census_file, $state_census_chunk_size)) !== false)
                    {
                        $column_count=count($state_census_data);      //Getting count of array
                        //Getting file data according to chunk size
                        // array_push($state_census_data_array,$state_census_data);
                        for($i=0;$i<$column_count;$i++)
                        {
                            // $state_census_data_array[$row][]=$state_census_data[$i];
                            $state_census_data_array[]=$state_census_data[$i];
                            
                        }
                        $row++;

                    }
                    
                }
                return $state_census_data_array;
                fclose($state_census_file);      //Closing File

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
    function load_state_code_csv_data()
    {
        try
        {
            //Checking file exists or not
            if(!file_exists("StateCode.csv"))
            {
                throw new Exception("StateCode.csv not found");       //Throw excedption
            }
            else
            {
                $state_code_data_array=array();
                $state_code_file = fopen("StateCode.csv", "r");      //Opening CSV file
                $state_code_chunk_size = 1024*1024;                        //Size(1MB) to chunk file 
                if(!feof($state_code_file))
                {
                    while(($state_code_data = fgetcsv($state_code_file, $state_code_chunk_size)) !== false)
                    {
                        $column_count=count($state_code_data);      //Getting count of array
                        //Getting file data according to chunk size
                        // array_push($state_code_data_array,$state_code_data);

                        for($i=0;$i<$column_count;$i++)
                        {
                            // $state_code_data_array[$row][]=$state_code_data[$i];
                            $state_code_data_array[]=$state_code_data[$i];
                            
                        }
                    }
                }
                return $state_code_data_array;
                
                fclose($state_code_file);      //Closing File
            }
        }
        catch(Exception $state_code_err)
        {
            //Getting error message into a variable
            $error_message=$state_code_err->getMessage();
        }
    }


    function match_csv_data()
    {
        $arr=$this->load_state_code_csv_data();
        $state_census_analyser_object=new StateCensusAnalyser();

    }
}
//Object Declaration
$csv_state_census=new CSVStateCensus();     //Creating object of CSVStateCensus

$csv_state_census->match_csv_data();     //Calling method CSVStateCensus

?>