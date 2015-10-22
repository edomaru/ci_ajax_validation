<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	public function create()
	{

		$this->load->view("header");
		$this->load->view("users/create");
		$this->load->view("footer");
	}

	public function save()
	{
		$data = array('success' => false, 'messages' => array());

		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password','trim|required');
		$this->form_validation->set_rules('password_confirm', 'Password Confirm','trim|required|matches[password]');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		
		if ($this->form_validation->run()) {
			$data['success'] = true;
		}
		else 
		{
			$data['success'] = false;
			foreach ($_POST as $key => $value) {
				$data['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($data);
	}
}
