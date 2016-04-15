<?php
/**
 * Registration controller.
 * 
 * controllers/Registration.php
 *
 * ------------------------------------------------------------------------
 */
class Registration extends Application 
{

    function __construct()
    {
            parent::__construct();
            $this->load->model('register');
			$this->load->helper(array('form', 'url'));
			$this->load->library('upload');
    }
	
	function index() 
    {
        $this->data['title'] = 'User Registration';
        $this->data['pagebody'] = 'register';

		//if currently in register view then hide the register link
		if($this->data['pagebody'] == 'register')
		{
			$this->data['register_visibility'] = 'none';
		}
		
		//set the visibility to none until something happens
		$this->data['username_visibility'] = 'none';
		$this->data['password_visibility'] = 'none';
		$this->data['reg_visibility'] = 'none';
		$this->data['avatar_visibility'] = 'none';
		
		//call the checkuser method
		$this->checkuser();
		$this->render();
	}
	
	function checkuser()
	{
		//if player text field isnt empty then go on
		if (!empty($this->input->post('player')) && !empty($this->input->post('password')))
		{
			//use check_registration method, if player doesnt exist then create them
			if($this->register->check_registration($this->input->post('player')))
			{
				
				//upload image
				$this->do_upload();
				if ($this->do_upload() == true){
				
				//send 'player' and 'password' data to database
				$this->register->register_user($this->input->post('player'), $this->input->post('password'));
				
				
				$this->data['reg_visibility'] = "true";
				//success msg here
				$this->data['register_success'] = 'Player successfully registered!';
				}
			else if ($this->register->check_registration($this->input->post('player')) == FALSE)
			{
				//if already exists then display message
				$this->data['username_visibility'] = 'true';
				//failure msg here
				$this->data['username_message'] = '*User already exists, please try again';
			}
			}

		}
		else if (empty($this->input->post('player')) && !empty($this->input->post('password')))
		{
			$this->data['username_visibility'] = 'true';
			$this->data['username_message'] = '*Username field must be filled in.';
		}
		else if (empty($this->input->post('password')) && !empty($this->input->post('player')))
		{
			$this->data['password_visibility'] = 'true';
			$this->data['password_message'] = '*Password field must be filled in.';
		}
		else
		{
			return;
		}
	}
	
	public function do_upload()
	{
		$config['upload_path'] = './data/uploads/';
		$config['allowed_types'] = 'jpg';
		$config['overwrite'] = TRUE;
		$config['max_size'] = '2048'; // Can be set to particular file size , here it is 2 MB(2048 Kb)
		$config['max_height'] = '160';
		$config['max_width'] = '160';
		$config['file_name'] = $this->input->post('player');
		
		$this->upload->initialize($config); 
		$this->load->library('upload', $config);
		
		if(!$this->upload->do_upload())
		{
			$error = array(
				'error' => $this->upload->display_errors()
				);
			
			while (list($key, $val) = each($error)) 
			{
			$this->data['avatar_message'] =$val;
			}
			
			$this->data['avatar_visibility'] = 'true';
			return false;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			
			return true;
		}
	}
}

