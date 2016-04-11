<?php

/**
 * Registration controller.
 * 
 * controllers/Registration.php
 *
 * ------------------------------------------------------------------------
 */
class Registration extends Application {

	    function __construct() 
    {
        parent::__construct();
        $this->load->model('register');
    }
	
	    function index() 
    {
        $this->data['title'] = 'User Registration';
        $this->data['pagebody'] = 'register';
		
		echo $this->input->post('player');
		if (!empty($this->input->post('player')))
		{
			
			if($this->register->check_registration($this->input->post('player')))
			{
			$this->register->register_user($this->input->post('player'), $this->input->post('password'));
			//success msg here
			
			$this->load->helper('url');
			redirect('/');
			}
			//failure msg here
		}
		
		$this->render();
		
		
		
	}
	
		function checkuser()
		{
			//if user session exists, redirect to homepage
		}
		
		
}