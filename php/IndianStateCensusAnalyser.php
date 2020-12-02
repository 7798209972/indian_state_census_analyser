<?php
/**Includeing required files */
require_once("config.php");
require_once("IndianCensusAnalyserException.php");
require_once("SortCSV.php");
require_once("CSVToJsonBuilder.php");

/**
 * Class Declaration
 */
class CensusAnalyser extends CSVToJsonBuilder
{
    //Declaring array
    Public $data_array=array();
    Public $file_header=array();
    Public $csv_file;
    Public $csv_name;

    //Method for welcome message
    function __construct()
    {
        echo "=========================================================\n";
        echo "Welcome to Indian Census Analyser Problem \n";
        echo "=========================================================\n";
    }

    /**
     * Method to load State Census CSV data
     */
    function load_csv_file($file)
    {
        $this->csv_name=$file;
        try
        {
            //Checking file exists or not
            if(!file_exists($file))
            {
                throw new IndianCensusAnalyserException(IndianCensusAnalyserException::CENSUS_FILE_PROBLEM);       //Throw exception
            }
            else
            {
                
                // Getting data of CSV file
                $no_of_records=$this->get_data($file);
                //Return Array of data
                return $no_of_records;

            }
        }
        catch(IndianCensusAnalyserException $err)
        {
            //Getting state_cencus_g error message
            error_log("Error : ".$err->getMessage().": On line:".$err->getLine().":".$err->getFile());
            return $err->getMessage();
        }
    }
    /**
     * Method to get data from CSV file
     */
    function get_data($file)
    {
        $this->csv_file = fopen($file, "r");      //Opening CSV file
        $chunk_size = 1024*1024;        //Size(1MB) to chunk file 
        $row=0;
        if(!feof($this->csv_file))
        {
            //Getting file data according to chunk size
            while(($csv_data = fgetcsv($this->csv_file, $chunk_size)) !== false)
            {
                //Getting column names of CSV file
                if (empty($this->file_header))
                {
                    //Storing header of CSV file into an array
                    $this->file_header = $csv_data;
                    continue;
                }
                //Storing data according to header column of csv file
                foreach ($csv_data as $k=>$value)
                {
                    $this->data_array[$row][$this->file_header[$k]] = $value;
                }
                $row++;
            }
            return $row;
                    
        }
        fclose($this->csv_file);      //Closing File
    }
    /**
     * Method to sort data alphabetically from CSV file according to state name
     */
    function sort_by_name()
    {
        try
        {
            $temp=$this->data_array;
            /** Checking File parameter exists or not in CSV data */
            if(!array_key_exists("State",$temp[0]))
            {
                throw new IndianCensusAnalyserException(IndianCensusAnalyserException::CENSUS_DATA_NOT_FOUND);       //Throw exception
            }
            else
            {
                $sort_object=new SortCSV();     //Created Object of SortCsv class
                /** Calling method to Sort Data */
                $this->data_array=$sort_object->sort_csv_data_ascending("State",$temp);
                
                $sorted_json_output=json_encode($this->data_array);
                $json_output_file=basename($this->csv_name,".csv")."State.json";     //Created file name along with CSV file name

                $this->write_json($json_output_file,$sorted_json_output);        //Calling method to store Sorted data into Json file
            }
        }
        catch(IndianCensusAnalyserException $err)
        {
            //Getting state_cencus_g error message
            error_log("Error : ".$err->getMessage().": On line:".$err->getLine().":".$err->getFile());
            return $err->getMessage();
        }

    }

    /**
     * Method to sort data by most populate state from CSV file
     */
    function sort_by_population()
    {
        try
        {
            /** Checking File parameter exists or not in CSV data */
            if(!array_key_exists("Population",$this->data_array[1]))
            {
                throw new IndianCensusAnalyserException(IndianCensusAnalyserException::CENSUS_DATA_NOT_FOUND);       //Throw exception
            }
            else
            {
                $sort_object=new SortCSV();     //Created Object of SortCsv class
                /** Calling method to Sort Data */
                $sorted_json_output=$sort_object->sort_csv_data_descending("Population",$this->data_array);
                
                $json_output_file=basename($this->csv_name,".csv")."Population.json";     //Created file name along with CSV file name

                $this->write_json($json_output_file,$sorted_json_output);        //Calling method to store Sorted data into Json file
            }
        }
        catch(IndianCensusAnalyserException $err)
        {
            //Getting state_cencus_g error message
            error_log("Error : ".$err->getMessage().": On line:".$err->getLine().":".$err->getFile());
            return $err->getMessage();
        }
        finally
        {
            return count($this->data_array);
        }

        
    }

    /**
     * Method to sort data by DensityPerSqm from CSV file
     */
    function sort_by_density()
    {
        try
        {
            /** Checking File parameter exists or not in CSV data */
            if(!array_key_exists("DensityPerSqKm",$this->data_array[3]))
            {
                throw new IndianCensusAnalyserException(IndianCensusAnalyserException::CENSUS_DATA_NOT_FOUND);       //Throw exception
            }
            else
            {
                $sort_object=new SortCSV();     //Created Object of SortCsv class
                /** Calling method to Sort Data */
                $sorted_json_output=$sort_object->sort_csv_data_descending("DensityPerSqKm",$this->data_array);
                
                $json_output_file=basename($this->csv_name,".csv")."DensityPerSqKm.json";     //Created file name along with CSV file name

                $this->write_json($json_output_file,$sorted_json_output);        //Calling method to store Sorted data into Json file
            }
        }
        catch(IndianCensusAnalyserException $err)
        {
            //Getting state_cencus_g error message
            error_log("Error : ".$err->getMessage().": On line:".$err->getLine().":".$err->getFile());
            return $err->getMessage();
        }
    }

    /**
     * Method to sort data by AreaInSqKm from CSV file
     */
    function sort_by_area()
    {
        try
        {
            /** Checking File parameter exists or not in CSV data */
            if(!array_key_exists("AreaInSqKm",$this->data_array[2]))
            {
                throw new IndianCensusAnalyserException(IndianCensusAnalyserException::CENSUS_DATA_NOT_FOUND);       //Throw exception
            }
            else
            {
                $sort_object=new SortCSV();     //Created Object of SortCsv class
                /** Calling method to Sort Data */
                $sorted_json_output=$sort_object->sort_csv_data_descending("AreaInSqKm",$this->data_array);
                
                $json_output_file=basename($this->csv_name,".csv")."AreaInSqKm.json";     //Created file name along with CSV file name

                $this->write_json($json_output_file,$sorted_json_output);        //Calling method to store Sorted data into Json file
            }
        }
        catch(IndianCensusAnalyserException $err)
        {
            //Getting state_cencus_g error message
            error_log("Error : ".$err->getMessage().": On line:".$err->getLine().":".$err->getFile());
            return $err->getMessage();
        }
    }

}
/**
 * Object Declaration
 */
$analyser_object=new CensusAnalyser();
$analyser_object->load_csv_file("../resources/StateCensusData.csv");

$analyser_object->sort_by_name();
$analyser_object->sort_by_population();
$analyser_object->sort_by_density();
$analyser_object->sort_by_area();
?>