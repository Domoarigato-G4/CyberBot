<?php

/**
 * This is a model for robot series that grabs data from the server.
 *
 * @author Chris
 */
class Series extends CI_Model {


	// Constructor
	public function __construct()
	{
		parent::__construct();
	}

	// retrieve a single series entry
	public function get($which)
	{
            // return the first and hopefully only record
            return $this->get_series_where($which)[0];
	}
        
        // retrieve all matching series
        public function get_all($which)
        {           
            // return all records
            return $this->get_series_where($which);
        }

	// retrieve all of the series
	public function all()
	{            
            return $this->get_series_where(NULL);
	}

	// retrieve the first series
	public function first()
	{
            // get data from the database
            $data = $this->get_series_where(NULL);
            
            return $data[0];
	}

	// retrieve the last series
	public function last()
	{
            // get data from the database
            $data = $this->get_series_where(NULL);
            
            $index = count($data) - 1;
            return $data[$index];
	}
        
        // this function implements db get where almost perfectly
        private function get_series_where($which)
        {
            //open remote URL
            $file_handle = @fopen('http://' . $this->config->item('bcc') . '/data/series', "r");
        
            //quick fix to deal with nonexistent data
            if($file_handle === FALSE)
            {
                return array();
            }
            
            $all_series = array();

            //get the first line and toss it because it's labels
            fgetcsv($file_handle, 1024);
            
            //go through all remaining rows and fill an array with them
            while (!feof($file_handle))
            {
                
                $line = fgetcsv($file_handle, 1024);
                
                //fix for empty lines creating blank array entries
                if(empty($line))
                {
                    continue;
                }
                
                $series = array('series'=>$line[0],'description'=>$line[1],'frequency'=>$line[2],'value'=>$line[3]);
                
                //check conditions if $which is not empty
                if(!empty($which))
                {
                    $valid = TRUE;
                    
                    //get all array keys
                    $keys = array_keys($which);
                    
                    //for each array key, check if the values match
                    foreach($keys as $key)
                    {
                        //if it doesn't match, disqualify it
                        if(!($which[$key] === $series[$key]))
                        {
                            $valid = FALSE;
                        }
                    }
                    
                    //if it's still valid, put the row in
                    if($valid)
                    {
                        $all_series[] = $series;
                    }
                }
                //if not, just put it in
                else
                {
                   
                    $all_series[] = $series;
                }

            }

            //close the handle and return the results
            fclose($file_handle);
            return $all_series;
        }

}
