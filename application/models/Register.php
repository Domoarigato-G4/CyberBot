<?php

/**
 * This is a model for regitration 
 *
 * @author Dave
 */
class Register extends CI_Model {
	
		// Constructor
	public function __construct()
	{
		parent::__construct();
	}
	
	public function check_registration($player)
	{
		// get data from the database to see if player already exists
		$data = $this->db->get_where('players', array('player' => $player))->result_array();
		
		if(empty($data))
		{
        return TRUE;
		}
	}
	
	public function register_user($player, $password)
	{
		$data=array(
		'player'=> $player,
		'peanuts'=> '200',
		'adminrole'=> FALSE,
		'pwhash'=> $this->password_hasher($password) //this is temporary, we need to push the user's pw into the password_hasher() function after that's done
		);
		
		$this->db->insert('players', $data);
		
		// This inserts the newly registered user into the DB players table
	}
	
	public function password_hasher($password)
	{
		
		$hash = password_hash ( $password , PASSWORD_BCRYPT);
		
		return $hash;
	}
}