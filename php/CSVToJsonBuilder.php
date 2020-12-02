<?php
/**
 * Class Declaration
 */
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
?>