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
        $this->load->library('Authorization_Token');

		//check session
		if (!$this->session->userdata('access_token_oauth')||!$this->session->userdata('access_token')) {
			$alert = array(
				"code" => '002', //KODE PERINGATAN
				"message" => "Silahkan Login!"
			);
			$this->session->set_flashdata('alert', $alert);
			redirect(base_url());
		}else{
			$decodedToken = $this->authorization_token->validateToken($this->session->userdata('access_token'));
            if ($decodedToken['status'])
            {
                $this->userData = $decodedToken['data'];
            }
            else {
                $alert = array(
					"code" => '002', //KODE PERINGATAN
					"message" => "Your Session end!"
				);
				$this->session->set_flashdata('alert', $alert);
				redirect(base_url('login/logout'));
            }
		}
    }
	public function dashboard()
	{
		echo json_encode($this->userData);
		$data['userData'] = $this->userData->{0};
		$this->load->view('template/header');
		$this->load->view('dashboard', $data);
		$this->load->view('template/footer');
	}
	public function pokemon()
	{
		$this->load->view('template/header');
		$this->load->view('pokemon');
		$this->load->view('template/footer');
	}
	public function users(){
		if (!$this->userData->{0}->is_admin) {
			$alert = array(
				"code" => '002', //KODE PERINGATAN
				"message" => "Anda bukan Admin!"
			);
			$this->session->set_flashdata('alert', $alert);
			redirect(base_url("MyApplication/dashboard"));
		}
	}
}
