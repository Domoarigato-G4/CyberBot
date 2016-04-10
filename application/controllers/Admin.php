<?php

/**
 * Admin page, which will eventually have user management and stuff.
 * 
 * controllers/Admin.php
 *
 * ------------------------------------------------------------------------
 */
class Admin extends Application {

	function __construct()
	{
		parent::__construct();
                $this->load->model('gamestate');
                $this->load->model('rounds');
                $this->load->model('agent');
	}

	//-------------------------------------------------------------
	//  The normal pages
	//-------------------------------------------------------------
        
        
	function index()
	{
            $this->data['title'] = 'Administration';
            $this->data['pagebody'] = 'admin';	// this is the view we want shown
            
            //call the display_register function
            $this->display_register();
            
            //calls the welcome_states function
            $this->welcome_states();

            //display stored tokens from previous rounds
            $this->admin_rounds();
            
            //renders the page
            $this->render();
	}
        
        function register()
        {
            $this->data['title'] = 'Administration';
            $this->data['pagebody'] = 'admin';	// this is the view we want shown

            //call the register_agent function
            $this->register_agent();
            
            //calls the welcome_states function
            $this->welcome_states();

            //display stored tokens from previous rounds
            $this->admin_rounds();
            
            //renders the page
            $this->render();            
        }
        
        //we're not registering, so display the register agent fragment
        private function display_register()
        {
            $this->data['register-form'] = $this->parser->parse('_register_form', array(), TRUE);
            $this->data['message'] = '';
        }
        
        //TODO: register the agent
        private function register_agent()
        {
            $this->data['register-form'] = '';            
            
            //TODO: get this from input boxes
            $team = "A04";
            $name = "cyberbot";
            $password = "tuesday";
            
            $success = $this->agent->register($team,$name,$password);
            
            if($success)
            {
                $this->data['message'] = 'REGISTERED!';
            }
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

}

/* End of file Homepage.php */
/* Location: application/controllers/Homepage.php */