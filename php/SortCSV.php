<?php
/**
 *@class - Class for writing Json file
 */
class SortCSV
{
    public function sort_csv_data_descending($delimeter, $csv_array)
    {
        //Created temporary empty array to store State names
        $temp = array();
        //Loop to get State names from data_array 
        foreach ($csv_array as $key => $row)
        {
                    $temp[$key] = $row[$delimeter];
        }
        /**
         * Used array_multisort function to sort data
         * Passing State names and Sorting order so it will arrange data according to State names
         */
        array_multisort($temp, SORT_DESC, $csv_array);

        $json_output_array=json_encode($csv_array);      //Storing data into Json format

        return $json_output_array;

    }
    /**
     * Method to sort data in ascending order
     */
    public function sort_csv_data_ascending($delimeter, $csv_array)
    {
        //Created temporary empty array to store State names
        $temp = array();
        //Loop to get State names from data_array 
        foreach ($csv_array as $key => $row)
        {
                    $temp[$key] = $row[$delimeter];
        }
        /**
         * Used array_multisort function to sort data
         * Passing State names and Sorting order so it will arrange data according to State names
         */
        array_multisort($temp, SORT_ASC, $csv_array);

        // $json_output_array=json_encode($csv_array);      //Storing data into Json format

        return $csv_array;

    }
}
?>