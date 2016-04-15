<?php

/**
 * This is a model for transactions that grabs data from the server.
 *
 * @author Chris
 */
class Transactions extends CI_Model {


	// Constructor
	public function __construct()
	{
		parent::__construct();
	}

	// retrieve a single transaction
	public function get($which)
	{
            // get data from the database
            $data = $this->get_transactions_where($which);

            // return the first and hopefully only record
            return $data[0];
	}
        
        // retrieve all matching transactions
        public function get_all($which)
        {
            // get data from the server
            return $this->get_transactions_where($which);
        }

	// retrieve all of the transactions
	public function all()
	{
            // get data from the server (no arguments)
            return $this->get_transactions_where(NULL);
	}

	// retrieve the first transaction
	public function first()
	{
            // get data from the server (no arguments)
            $data = $this->get_transactions_where(NULL);
            
            return $data[0];
	}

	// retrieve the last transaction
	public function last()
	{
            // get data from the server (no arguments)
            $data = $this->get_transactions_where(NULL);
            
            $index = count($data) - 1;
            return $data[$index];
	}
               
        // this function implements db get where almost perfectly
        private function get_transactions_where($which)
        {
            //open remote URL
            $file_handle = @fopen('http://' . $this->config->item('bcc') . '/data/transactions', "r");

            //quick fix to deal with nonexistent data
            if($file_handle === FALSE)
            {
                return array();
            }
            
            $transactions = array();

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
                
                //grab the date and format (crude fix for a server-side change)
                $date = date(DATE_ATOM, $line[1]);
                
                $transaction = array('transaction_id'=>$line[0],'datetime'=>$date,'broker'=>$line[2],'player'=>$line[3],'series'=>$line[4],'trans'=>$line[5]);
                
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
                        if(!($which[$key] === $transaction[$key]))
                        {
                            $valid = FALSE;
                        }
                    }
                    
                    //if it's still valid, put the row in
                    if($valid)
                    {
                        $transactions[] = $transaction;
                    }
                }
                //if not, just put it in
                else
                {
                   
                    $transactions[] = $transaction;
                }
            }

            //close the handle and return the results
            fclose($file_handle);
            return $transactions;
        }

}
