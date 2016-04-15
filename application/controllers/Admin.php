<?php

/**
 * Admin page, which will eventually have user management and stuff.
 * 
 * controllers/Admin.php
 *
 * ------------------------------------------------------------------------
 */
class Admin extends Application 
{

	function __construct() 
	{
		parent::__construct();
		$this->load->model('gamestate');
		$this->load->model('rounds');
		$this->load->model('players');
		$this->load->model('agent');
		$this->load->helper('url');
	}

	//-------------------------------------------------------------
	//  The normal pages
	//-------------------------------------------------------------


	function index() 
	{
		$this->data['title'] = 'Administration';

		if ($this->players->check_admin($this->session->userdata['username']) == 1) 
		{
			$this->data['admin_visibility'] = 'true';
			$this->data['pagebody'] = 'admin'; // this is the view we want shown
		}
		else
		{
			//redirect back to the admin page            
			redirect('/', 'refresh');
		}
		$this->data['message'] = ''; //by default, message is an empty string
		//call the display_register function
		$this->display_register();

		//calls the welcome_states function
		$this->welcome_states();

		//display stored tokens from previous rounds
		$this->admin_rounds();
		//display players in an administrative table
		$this->administrate_players();
		//renders the page
		$this->render();
	}

	function register() 
	{
		$this->data['title'] = 'Registering Agent';
		$this->data['pagebody'] = 'admin_register'; // this is the view we want shown
		//renders the page
		$this->render();

		//call the register_agent function to actually register the agent
		$this->register_agent();

		//redirect back to the admin page            
		redirect('admin', 'refresh');
	}

	function update() 
	{
		$this->data['title'] = 'Updating Agent';
		$this->data['pagebody'] = 'admin_register'; // this is the view we want shown
		//renders the page
		$this->render();

		//call the update function to actually update the agent
		$this->update_agent();

		//redirect back to the admin page            
		redirect('admin', 'refresh');
	}
        
        function purge()
        {
                $this->data['title'] = 'Purging Agent';
		$this->data['pagebody'] = 'admin_register'; // this is the view we want shown
		//renders the page
		$this->render();

		//purge rounds through the rounds model
		$this->rounds->truncate();

		//redirect back to the admin page            
		redirect('admin', 'refresh');
        }

	//check if we're registered and display a nice message if we are or aren't
	//also fills the registration boxes with pre-existing data
	private function display_register() 
	{
		$this->data['register-status'] = $this->agent->is_registered() ? 'Registered' : 'Not registered';

		$register_data = $this->agent->get_data();

		$this->data['register-team'] = $register_data['team'];
		$this->data['register-name'] = $register_data['name'];
		$this->data['register-password'] = $register_data['password'];
	}

	//register the agent
	private function register_agent() 
	{
		//get this from input boxes
		$team = $this->input->post('team');
		$name = $this->input->post('name');
		$password = $this->input->post('password');

		$success = $this->agent->register($team, $name, $password);

		if ($success) 
		{
			$this->data['message'] = 'REGISTERED!';
		}
	}

	private function update_agent() 
	{
		//get this from input boxes
		$team = $this->input->post('team');
		$name = $this->input->post('name');
		$password = $this->input->post('password');

		$this->agent->update_data($team, $name, $password);
	}

	//get the state from the server and display
	private function welcome_states() 
	{
		$this->gamestate->refresh();
		$this->data['round-number'] = $this->gamestate->get_round();
		$this->data['round-state'] = $this->gamestate->get_state();
		$this->data['round-countdown'] = $this->gamestate->get_countdown();
	}

	//get the list of previous rounds from the database and display
	private function admin_rounds() 
	{
		$this->data['rounds'] = $this->rounds->all();
	}

	private function administrate_players() 
	{
		//get all the players from our model
		$players = $this->players->all();

		$players_array = array();
		foreach ($players as $player) 
		{
			$players_array[] = (array) $player;
		}
		$this->data['adminplayertable'] = $players_array;
	}

	//this function should take whatever value the player has in adminrole 
	//in the db, and reverse its value
	function toggle() 
	{
		$this->data['title'] = 'Updating Player';
		$this->data['pagebody'] = 'admin_register'; // this is the view we want shown
		//renders the page
		$this->render();

		//call the update function to actually update the agent
		$this->toggle_player();

		//redirect back to the admin page            
		redirect('admin', 'refresh');
	}

	private function toggle_player() 
	{
		//get the selected player
		$player = $this->input->post('player');
		//get their current role
		$role = $this->input->post('role');

		$this->players->update_player($player, $role);
	}

	//this function should delete the player of the corresponding row in the
	//player management table
	function delete() 
	{
		$this->load->model('players');
		$this->data['title'] = 'Deleting Player';
		$this->data['pagebody'] = 'admin_deleteplayer'; // this is the view we want shown
		//call the deleteplayer() function
		$this->delete_player();

		redirect('admin', 'refresh');
	}

	private function delete_player() 
	{
		$player = $this->input->post('deleteplayer');

		$this->players->delete_player($player);
	}

}

/* End of file Homepage.php */
/* Location: application/controllers/Homepage.php */