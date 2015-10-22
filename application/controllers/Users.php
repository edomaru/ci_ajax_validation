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
		die("Save the data");
	}
}
