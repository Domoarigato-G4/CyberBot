<?php
/**
 * This is a model for collections that grabs data from a MySQL database.
 *
 * @author Chris
 */
class Collections extends CI_Model 
{
	// Constructor
	public function __construct()
	{
		parent::__construct();
	}
	// retrieve a single collection item
	public function get($which)
	{
            // get data from the database
            $data = $this->db->get_where('collections',$which);
            // return the first and hopefully only record
            return $data->result_array()[0];
	}
        
        // retrieve all matching collection items
        public function get_all($which)
        {
            // get data from the database
            $data = $this->db->get_where('collections',$which);
            
            // return all records
            return $data->result_array();
        }
        
        // retrieve selected columns matching player name in collection items
        public function get_like($which, $like)
        {
            // get data from the database
            $this->db->select('piece');
            $this->db->where('player',$which);
            $this->db->like('piece', $like, 'before');
            
            $data =  $this->db->get('collections');
            
            // return all records
            return $data->result_array();
        }
        
        // retrieve the first in selected column matching player name in collection items
        public function get_like_first($which, $like)
        {
            // get data from the database
            $this->db->select('piece');
            $this->db->where('player',$which);
            $this->db->like('piece', $like, 'before');
            
            $data =  $this->db->get('collections')->result_array();
            
            // return all records
            return $data[0];
        }
        
        // retrieve a structured array of pieces and their quantity
        public function get_pieces($which)
        {
            // get data from the database
            $data = $this->db->get_where('collections',$which)->result_array();
            
            // we need to get an array of the form position:[piece:quantity]
            $pieces = array
            (
                '0'=>array('11'=>0,'13'=>0,'26'=>0,'piece'=>'Heads'),
                '1'=>array('11'=>0,'13'=>0,'26'=>0,'piece'=>'Bodies'),
                '2'=>array('11'=>0,'13'=>0,'26'=>0,'piece'=>'Legs')
            );
            
            // iterate through all data and count each piece type
            foreach($data as $record)
            {
                $position = substr($record['piece'],-1);
                $series = substr($record['piece'],0,2);
                
                //increment the correct piece
                $pieces[$position][$series] += 1;
            }
            
            return $pieces;
            
        }
	// retrieve all of the collection items
	public function all()
	{
            // get data from the database
            $data = $this->db->get('collections');
            
            return $data->result_array();
	}
	// retrieve the first collection item
	public function first()
	{
            $this->db->select('piece');
            // get data from the database
            $data = $this->db->get('collections')->result_array();
            
            return $data[0];
	}
	// retrieve the last collection item
	public function last()
	{
            // get data from the database
            $data = $this->db->get('collections')->result_array();
            
            $index = count($data) - 1;
            return $data[$index];
	}
        
        public function all_name()
        {
            $this->db->select('player');
            
            $data = $this->db->get('collections');
            return $data->result_array();
        }
        
	
	public function distinct_all()
	{
            // get data from the database
		$this->db->select('piece');
		$this->db->distinct();
		
		
        $data = $this->db->get('collections');
            
            return $data->result_array();
	}
        
        // delete all collection data
        public function truncate()
        {
            $this->db->truncate('collections'); 
        }
	
}