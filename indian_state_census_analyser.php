<?php
ini_set("log_errors",TRUE);
$log_file="error.log";
ini_set("error_log",$log_file);

class StateCensusAnalyser
{

    Protected $state_census_data_array=array();
    Protected $whole_state_census_data_array=array();
    Protected $state_census_header=array();
    //Method for welcome message
    function welcome_message()
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
                $state_census_file = fopen("StateCensusData.csv", "r");      //Opening CSV file
                $state_census_chunk_size = 1024*1024;                        //Size(1MB) to chunk file 
                $row=0;
                if(!feof($state_census_file))
                {
                    //Getting file data according to chunk size
                    while(($state_census_data = fgetcsv($state_census_file, $state_census_chunk_size)) !== false)
                    {
                        $column_count=count($state_census_data);      //Getting count of array
                        $j=0;
                        for($i=$row+1;$i<$column_count;$i++)
                        {
                            //Putting Valius into an array
                            $this->state_census_data_array[$state_census_data[$row]][]=$state_census_data[$i];
                            //Putting all data of file as array
                            $this->whole_state_census_data_array[]=$state_census_data[$j];
                            $j++;
                        }
                    }
                    
                }
                // return $this->state_census_data_array;
                return $this->whole_state_census_data_array;
                fclose($state_census_file);      //Closing File

            }
        }
        catch(Exception $state_cencus_err)
        {
            //Gettinstate_cencus_g error message into a variable
            return $state_cencus_err->getMessage();
        }
    }
    function sort_state_census_analyser_data()
    {
        for($j=0;$j<4;$j++)
        {
            $k=1;
            $this->state_census_header[$j]=$this->whole_state_census_data_array[$j];
            $k++;
        }
        array_shift($this->state_census_data_array);
        ksort($this->state_census_data_array);
        return $this->state_census_data_array;
    }
}
class CSVStateCensus
{
    Protected $state_code_data_array=array();
    Protected $whole_state_code_data_array=array();
    Protected $state_code_header=array();
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
                $state_code_file = fopen("StateCode.csv", "r");      //Opening CSV file
                $state_code_chunk_size = 1024*1024;                        //Size(1MB) to chunk file 
                $row=1;
                if(!feof($state_code_file))
                {
                    //Getting file data according to chunk size
                    while(($state_code_data = fgetcsv($state_code_file, $state_code_chunk_size)) !== false)
                    {
                        $column_count=count($state_code_data);      //Getting count of array
                        $j=0;
                        for($i=$row+1;$i<$column_count;$i++)
                        {

                            //Putting Valius into an array
                            $this->state_code_data_array[$state_code_data[$row]][]=$state_code_data[$i];
                            //Putting all data of file as array
                            $this->whole_state_code_data_array[]=$state_code_data[$j];
                            $j++;
                            
                        }
                    }
                }
                return $this->state_code_data_array;
                
                fclose($state_code_file);      //Closing File
            }
        }
        catch(Exception $state_code_err)
        {
            //Getting error message into a variable
            return $state_code_err->getMessage();
        }
    }


    function match_csv_data()
    {
        $state_code_array=$this->load_state_code_csv_data();
        $state_census_analyser_object=new StateCensusAnalyser();
        $state_census_array=$state_census_analyser_object->load_state_census_csv_data();
        return [$state_census_array, $state_code_array];

    }
}

?>