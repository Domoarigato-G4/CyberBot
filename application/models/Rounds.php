<?php

/**
 * This is a model for rounds that grabs data from a MySQL database.
 *
 * @author Chris
 */
class Rounds extends CI_Model {


	// Constructor
	public function __construct()
	{
		parent::__construct();
	}

	// retrieve a single round by number
	public function get($which)
	{
            // get data from the database
            $data = $this->db->get_where('rounds',array('round' => $which))->result_array();

            // return null if there are no matches
            if(empty($data))
                return NULL;
            
            // return the first and hopefully only record
            return $data[0];
	}

	// retrieve all of the rounds
	public function all()
	{
            // get data from the database
            $data = $this->db->get('rounds');
            
            return $data->result_array();
	}
        
        // add or update a round in the database
        public function add($round, $token)
        {

            //check if the round already exists
            if(empty($this->get($round)))
            {
                //add a new row
                $data = array('round'=>$round, 'token'=>$token);
                $this->db->insert('rounds', $data); 
            }
            else
            {
                //otherwise, update the existing row
                $where = array('round'=>$round);
                $data = array('token'=>$token);
                $this->db->update('rounds', $data, $where); 
            }
            
        }
        
        // purge the rounds table of known rounds
        public function truncate()
        {
            $this->db->truncate('rounds');
        }

}
