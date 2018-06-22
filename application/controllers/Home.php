<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->model("users_model");


		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}else{
			$user_login = $this->users_model->get_user_login($this->session->userdata("user_login"));

			if($user_login[0]['verified_date'] == ""){
				//redirect("auth/verify");
			}

		}

	}

	public function index()
	{
		$data['user_login'] = $this->users_model->get_user_login(3);
		$this->load->view('dashboard', $data);
	}
}
