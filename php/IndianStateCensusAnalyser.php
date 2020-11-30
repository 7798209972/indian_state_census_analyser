<?php

class StateCensusAnalyser
{
    //Declaring array with protected scope
    Public $state_census_data_array=array();
    Protected $whole_state_census_data_array=array();
    Public $state_census_header=array();

    //Method for welcome message
    function __construct()
    {
        echo "=========================================================\n";
        echo "Welcome to Indian Census Analyser Problem \n";
        echo "=========================================================\n";
    }

    //Method to load State Census CSV data
    function load_state_census_csv_data($file)
    {
        try
        {
            //Checking file exists or not
            if(!file_exists($file))
            {
                throw new Exception("$file not found");       //Throw exception
            }
            else
            {
                
                // Getting data of CSV file
                $no_of_records=$this->get_data($file);
                //Return Array of data
                return $no_of_records;

            }
        }
        catch(Exception $state_cencus_err)
        {
            //Getting state_cencus_g error message
            return $state_cencus_err->getMessage();
        }
    }
    /**
     * @description
     * @class
     * @functions
     */
    function get_data($file)
    {
        $state_census_file = fopen($file, "r");      //Opening CSV file
        $state_census_chunk_size = 1024*1024;        //Size(1MB) to chunk file 
        $row=0;
        if(!feof($state_census_file))
        {
            //Getting file data according to chunk size
            while(($state_census_data = fgetcsv($state_census_file, $state_census_chunk_size)) !== false)
            {
                //Getting column names of CSV file
                if (empty($this->state_census_header))
                {
                    //Storing header of CSV file into an array
                    $this->state_census_header = $state_census_data;
                    continue;
                }
                //Storing data according to header column of csv file
                foreach ($state_census_data as $k=>$value)
                {
                    $this->state_census_data_array[$row][$this->state_census_header[$k]] = $value;
                }
                $row++;
            }
            return $row;
                    
        }
        fclose($state_census_file);      //Closing File
    }

}
/**
 * @description
 * @class - CSVStateCensus
 * @functions
*/
class CSVStateCensus
{
    Protected $state_code_data_array=array();
    Protected $whole_state_code_data_array=array();
    Protected $state_code_header=array();
    //Method to load CSV data
    function load_state_code_csv_data($file)
    {
        try
        {
            //Checking file exists or not
            if(!file_exists($file))
            {
                throw new Exception("$file not found");       //Throw excedption
            }
            else
            {
                // Getting data of CSV file
                $no_of_records=$this->get_data($file);
                //Return Array of data
                return $no_of_records;
            }
        }
        catch(Exception $state_code_err)
        {
            //Getting error message into a variable
            return $state_code_err->getMessage();
        }
    }

    function get_data($file)
    {
        $state_code_file = fopen($file, "r");      //Opening CSV file
        $state_code_chunk_size = 1024*1024;                        //Size(1MB) to chunk file 
        $row=0;
        if(!feof($state_code_file))
        {
            //Getting file data according to chunk size
            while(($state_code_data = fgetcsv($state_code_file, $state_code_chunk_size)) !== false)
            {
                if (empty($this->state_code_header))
                {
                    $this->state_code_header = $state_code_data;
                    continue;
                }
                foreach ($state_code_data as $k=>$value)
                {
                            $this->state_code_data_array[$row][$this->state_code_header[$k]] = $value;
                }
                $row++;
            }
        }
                return $row;
                
                fclose($state_code_file);      //Closing File
    }


    function match_csv_data()
    {
        //Getting Data of StateCode Csv
        $this->load_state_code_csv_data("../resources/StateCode.csv");
        $state_code_array=$this->state_code_data_array;
        $state_census_analyser_object=new StateCensusAnalyser();        //Creating Object of StateCensusAnalyser
        $state_census_analyser_object->load_state_census_csv_data("../resources/StateCensusData.csv");        //Calling method
        $state_census_array=$state_census_analyser_object->state_census_data_array;      //Getting array of data

        //Getting header of StateCensus CSV file
        $header=$state_census_analyser_object->state_census_header;

        // Getting key values of StateCensus Data into an temporary array
        $keyvalues=[];
        foreach($state_census_array as $key => $value)
        {
            for($i=0;$i<count($header);$i++)
            {
                $keyvalues[$value[$header[$i]]] = $key;
            }
        }

        // Loop to match and store key values of both arrays
        foreach($state_code_array as $keys => $values)
        {
            for($j=0;$j<count($this->state_code_header);$j++)
            {
                if( array_key_exists( $values[$this->state_code_header[$j]] , $keyvalues ) )
                {
                    //Mergging Data of CSVStateCode with StateCensus Using array_merge
                    $state_census_array[ $keyvalues[$values[$this->state_code_header[$j]]] ] = array_merge( $state_census_array[$keyvalues[$values[$this->state_code_header[$j]]]] , $state_code_array[$keys] );
                }
            }
        }

    }
}
// $obj=new CSVStateCensus();
// $obj->match_csv_data();
?>