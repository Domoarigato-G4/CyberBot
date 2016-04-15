<?php
/**
 * This is a model for certificates that grabs data from the server (similar to collections)
 *
 * @author Chris
 */
class Certificates extends CI_Model {
	// Constructor
	public function __construct()
	{
		parent::__construct();
	}
        
        // retrieve a collection that consists of unique items
	public function distinct_all()
	{
            // get data from the database
            return $this->get_pieces_distinct();
	}
        
        //get a list of pieces (like a select distinct)
        private function get_pieces_distinct()
        {
            //open remote URL
            $file_handle = fopen("http://botcards.jlparry.com/data/certificates", "r");
        
            $collections = array();
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
                               
                $collection = array('token'=>$line[0],'piece'=>$line[1],'broker'=>$line[2],'player'=>$line[3],'datetime'=>$line[4]);
                
                $exists = FALSE;
                
                //check if the piece is already in the collection
                foreach($collections as $existing)
                {
                    if($existing['piece'] === $collection['piece'])
                    {
                        //if it exists, set exists to true
                        $exists = TRUE;
                    }
                }
                
                //does it already exist? if not, add it!
                if(!$exists)
                {
                    $collections[] = array('piece'=>$collection['piece']);                
                }
                
            }
            //close the handle and return the results
            fclose($file_handle);
            return $collections;
        }
	
}