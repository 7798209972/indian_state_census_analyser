<?php
/**Includeing required files */
require_once("config.php");
require_once("IndianCensusAnalyserException.php");

class CSVToJsonBuilder
{
    /**
     * Method to write output into an Json file
     */
    public function write_json($filename,$content)
    {
        /**
         * Checking file exists or not.. if not file will be create runtime
         */
        $file_path="../json/".$filename;
        if(!file_exists($file_path))
        {
            fopen($file_path,"w");
        }
        file_put_contents($file_path, $content);        //Putting content into json file
    }
}
/**
 * Class Declaration
 */
class CensusAnalyser extends CSVToJsonBuilder
{
    //Declaring array with protected scope
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
    function sort_alphabetically()
    {
        //Created temporary empty array to store State names
        $state_names = array();
        //Loop to get State names from data_array 
        foreach ($this->data_array as $key => $row)
        {
            $state_names[$key] = $row['State'];
        }
        /**
         * Used array_multisort function to sort data
         * Passing State names and Sorting order so it will arrange data according to State names
         */
        array_multisort($state_names, SORT_ASC, $this->data_array);
        /**
         * Storing data into Json format
         */
        $json_output_array=json_encode($this->data_array);

    }

    /**
     * Method to sort data by most populate state from CSV file
     */
    function sort_by_population()
    {
        //Created temporary empty array to store State names
        $population = array();
        //Loop to get State names from data_array 
        foreach ($this->data_array as $key => $row)
        {
            $population[$key] = $row['Population'];
        }
        /**
         * Used array_multisort function to sort data
         * Passing State names and Sorting order so it will arrange data according to State names
         */
        array_multisort($population, SORT_DESC, $this->data_array);

        $json_output_array=json_encode($this->data_array);      //Storing data into Json format

        $json_output_file=basename($this->csv_name,".csv").".json";     //Created file name along with CSV file name

        $this->write_json($json_output_file,$json_output_array);        //Calling method to store Sorted data into Json file

        return count($this->data_array);

        


    }

}
/**
 * Object Declaration
 */
$analyser_object=new CensusAnalyser();
$analyser_object->load_csv_file("../resources/StateCensusData.csv");
$analyser_object->sort_alphabetically();
$analyser_object->sort_by_population();
?>