<?php

/**
 * This is a model for players that grabs data from a MySQL database.
 *
 * @author Chris
 */
class Players extends CI_Model 
{

	// Constructor
	public function __construct() 
	{
		parent::__construct();
	}

	// retrieve a single player
	public function get($which) 
	{
		// get data from the database
		$data = $this->db->get_where('players', $which)->result_array();

		// return null if there are no matches
		if (empty($data))
			return NULL;

		// return the first and hopefully only record
		return $data[0];
	}

	// retrieves the equity of a player
	public function equity($player) 
	{
		// get data from the database
		$data = $this->db->get_where('collections', array('player' => $player))->result_array();

		// each row is a piece, so count the rows
		$count = count($data);

		// each piece is worth 1 peanut, so just return the count
		return $count;
	}

	// retrieve all matching players
	public function get_all($which) 
	{
		// get data from the database
		$data = $this->db->get_where('players', $which);

		// return all records
		return $data->result_array();
	}

	// retrieve all of the players
	public function all() 
	{
		// get data from the database
		$data = $this->db->get('players');

		return $data->result_array();
	}

	public function check_password($which) 
	{
		$this->db->select('pwhash');
		$this->db->where('player', $which);

		$data = $this->db->get('players')->result_array();

		// return null if there are no matches
		if (empty($data))
			return NULL;

		// return first and hopefully only record
		return $data[0]['pwhash'];
	}

	public function check_admin($which) 
	{
		$this->db->select('adminrole');
		$this->db->where('player', $which);
		$admin = $this->db->get('players')->result_array();


		return $admin[0]['adminrole'];
	}
        
        
        function get_peanuts($player)
        {
            $this->db->select('peanuts');
            $this->db->from('players');
            $this->db->where('player', $player);
            $query = $this->db->get();
            if ( $query->num_rows() > 0 )
                {
                    $row = $query->row_array();
                    return $row['peanuts'];
                }
        }
        
        function update_peanuts($player, $peanuts)
        {
            $data = array(
               'peanuts' => $peanuts,
            );

             $this->db->where('player', $player);
             $this->db->update('players', $data);
            
        }

	// resets player peanuts and collections
	public function reset_all() 
	{
		//load collections model
		$this->load->model('collections');

		// truncate collections table
		$this->collections->truncate();

		//reset player peanuts
		$data = array('peanuts' => 100);
		$this->db->update('players', $data);
	}

	//deletes a specific player in the players table
	public function delete_player($which) 
	{
		$this->db->delete('players', array('player' => $which));
	}
	
	//change the persons admin status
	public function update_player($which, $role) 
	{
		if($role == 1)
		{
			$data = array('adminrole' => 0);
		}
		else
		{
			$data = array('adminrole' => 1);
		}

		$this->db->where('player', $which);
		//update with the players table with info from the $data array
		$this->db->update('players', $data);

	}

}
