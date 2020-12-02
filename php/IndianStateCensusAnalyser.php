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
    Public $data_array;
    Public $file_header;
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
        $this->data_array=array();
        $this->file_header=array();
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
    function sort_acending($delimiter, SortCSV $sort_object)
    {
        try
        {
            $temp=$this->data_array;        //Storing temporary array
            /** Checking File parameter exists or not in CSV data */
            if(!in_array($delimiter,$this->file_header))
            {
                throw new IndianCensusAnalyserException(IndianCensusAnalyserException::CENSUS_DATA_NOT_FOUND);       //Throw exception
            }
            else
            {
                // $sort_object=new SortCSV();     //Created Object of SortCsv class
                /** Calling method to Sort Data */
                $this->data_array=$sort_object->sort_csv_data_ascending($delimiter,$temp);
                
                $sorted_json_output=json_encode($this->data_array);
                $json_output_file=basename($this->csv_name,".csv").$delimiter.".json";     //Created file name along with CSV file name

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
    function sort_descending($delimiter, SortCSV $sort_object)
    {
        try
        {
            /** Checking File parameter exists or not in CSV data */
            if(!in_array($delimiter,$this->file_header))
            {
                throw new IndianCensusAnalyserException(IndianCensusAnalyserException::CENSUS_DATA_NOT_FOUND);       //Throw exception
            }
            else
            {
                /** Calling method to Sort Data */
                $sorted_json_output=$sort_object->sort_csv_data_descending($delimiter,$this->data_array);
                
                $json_output_file=basename($this->csv_name,".csv").$delimiter.".json";     //Created file name along with CSV file name

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
$sort_object=new SortCSV();
/** Passing SortCSV class object */
/** for StateCensusData */
$analyser_object->load_csv_file("../resources/StateCensusData.csv");
$analyser_object->sort_descending("Population", $sort_object);
$analyser_object->sort_descending("DensityPerSqKm", $sort_object);

/** for StateCensusData */
$analyser_object->load_csv_file("../resources/USCensusData.csv");
$analyser_object->sort_descending("Population", $sort_object);
$analyser_object->sort_descending("Population Density", $sort_object);
$analyser_object->sort_descending("Housing Density", $sort_object);

?>