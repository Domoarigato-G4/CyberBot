<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * MY_Controller conventions:
 *  Menubar
 *  Render content
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

	protected $data = array();	  // parameters for view components
	protected $id;				  // identifier for our content

	/**
	 * Constructor.
	 * Establish view parameters & load common helpers
	 */

	function __construct()
	{
            parent::__construct();

			  $this->load->model('players'); 
            // load parser library
            $this->load->library('parser');
			//load helpers
			$this->load->helper(array('form', 'url'));
            // create data and error arrays
            $this->data = array();
            $this->data['title'] = 'CyberBot Web App';	// our default title
            $this->errors = array();
            //$this->data['page_title'] = 'CyberBot';   // our default page

            // handle login/logout
            $this->handle_login();
 
	}

	/**
	 * Render this page
	 */
	function render()
	{
            // create menu bar by calling function, then parse the page body
            $this->create_menubar();
            $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

            // finally, build the browser page!
            $this->data['data'] = $this->data;
            $this->parser->parse('_template', $this->data);
	}
        
        /**
	 * Handle login/logout functionality
	 */
        function handle_login()
        {
            // display no message if there's nothing to say
            $this->data['login_message'] = NULL;
            
            // get the login and action from get/post
            $username = $this->input->get_post('username');
			$password = $this->input->get_post('password');
            $action = $this->input->get_post('action');
            
            // a bit of validation: check both username and action submitted
            if($this->session->userdata('username') && $action === 'logout')
            {
                // if someone is logged in and action is logout, remove login session data
                $this->session->unset_userdata('username');
                $this->data['login_message'] = 'Logged out successfully!';
                
            }
            else if(!empty($username) && $action === 'login')
            {
                // if username is not empty, and action is login, check against users
				
                if($username === $this->players->get(array('player'=>$username))['player'])
                {
					$check = $this->players->check_password($username);
					
					if(password_verify($password, $check))
					{
						// if user exists, log in by adding session data
						$this->session->set_userdata(array('username'=>$username));
						$this->data['login_message'] = 'Logged in successfully!';
					}
					else
					{
						$this->data['login_message'] = 'Invalid password!';
					}
                }
                else
                {
                    // if user does not exist, display a message
					$this->data['login_message'] = 'Invalid username!';
                }
            }
            else if(empty($username) && $action === 'login')
            {
                // if username is empty, prompt the user to type one in
                $this->data['login_message'] = 'Please type a username.';
            }
            
        }
        
        /**
	 * Create the menu bar, including the login box
	 */
        function create_menubar()
        {
            // get the menu bar data from config
            $this->data['menudata'] = $this->config->item('menu_choices')['menudata'];
            
            // check if someone is logged in
            if($this->session->userdata('username'))
            {
                // if so, display logout button
                $this->data['login_text'] = 'Hi, ' . $this->session->userdata('username');
				$this->data['imghide'] = 'initial';
				$this->data['img'] = $this->session->userdata('username');
                $this->data['login_submit_text'] = 'Logout';
                $this->data['login_visibility'] = 'none';
                $this->data['login_action'] = 'logout';
				$this->data['register_visibility'] = 'none';
				$this->data['admin_visibility'] = 'none';
				
				if ($this->players->check_admin($this->session->userdata['username']) == 1)
				{
				$this->data['admin_visibility'] = 'true';
				}
            }
            else
            {
                // if not, display the login box
                $this->data['login_text'] = '';
                $this->data['login_submit_text'] = 'Login';
                $this->data['login_visibility'] = 'initial';
                $this->data['login_action'] = 'login';
				$this->data['imghide'] = 'none';
				$this->data['admin_visibility'] = 'none';
            }
            
            // parse the menu bar
            $this->data['menubar'] = $this->parser->parse('_menubar', $this->data, true); //$this->config->item('menu_choices')
            
        }

}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */
