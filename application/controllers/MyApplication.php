<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyApplication extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	private $userData;

	function __construct() { 
        parent::__construct(); 
         
        // Load model 
        $this->load->model('user_Model');

		//check session
		// if (!$this->session->userdata('access_token')||!$this->session->userdata('user_data')) {
		// 	$alert = array(
		// 		"code" => '002', //KODE PERINGATAN
		// 		"message" => "Silahkan Login!"
		// 	);
		// 	$this->session->set_flashdata('alert', $alert);
		// 	redirect(base_url());
		// }else{
		// 	$this->userData = $this->session->userdata('user_data')[0];
		// }
    }
	public function dashboard()
	{
		$this->load->view('template/header');
		$this->load->view('dashboard');
		$this->load->view('template/footer');
	}
	public function pokemon()
	{
		$this->load->view('template/header');
		$this->load->view('pokemon');
		$this->load->view('template/footer');
	}
	public function users(){
		// echo json_encode($this->userData);
		if (!$this->userData['is_admin']) {
			$alert = array(
				"code" => '002', //KODE PERINGATAN
				"message" => "Anda bukan Admin!"
			);
			$this->session->set_flashdata('alert', $alert);
			redirect(base_url("MyApplication/dashboard"));
		}
	}
}
