<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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

	function __construct() { 
        parent::__construct(); 
         
        // Load facebook, google oauth library 
        $this->load->library(array('facebook', 'google')); 
         
        // Load user model 
        $this->load->model('user_Model'); 
    } 

	public function index()
	{
		$userData = array();
        
		if(isset($_GET["code"])){
			// Authenticate user with facebook 
			if($this->facebook->is_authenticated()){ 
				// Get user info from facebook 
				$fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture'); 
	
				// Preparing data for database insertion 
				$userData['oauth_provider'] = 'facebook'; 
				$userData['oauth_uid']    = !empty($fbUser['id'])?$fbUser['id']:'';
				$userData['first_name']    = !empty($fbUser['first_name'])?$fbUser['first_name']:''; 
				$userData['last_name']    = !empty($fbUser['last_name'])?$fbUser['last_name']:''; 
				$userData['email']        = !empty($fbUser['email'])?$fbUser['email']:''; 
		
				// Store the user profile info into session
					
				$this->session->set_userdata('access_token',$this->facebook->is_authenticated());
				
				// Facebook logout URL 
				$data['logoutURL'] = $this->facebook->logout_url();
			}else{

				$user_data = $this->google->get_user_data($_GET['code']);
				$userData = array(
					'oauth_provider' => 'google',
					'oauth_uid' => !empty($user_data['id'])?$user_data['id']:'',
					'first_name' => !empty($user_data['given_name'])?$user_data['given_name']:'',
					'last_name'  => !empty($user_data['family_name'])?$user_data['family_name']:'',
					'email' => !empty($user_data['email'])?$user_data['email']:''
					);
				$this->session->set_userdata('access_token', $user_data['access_token']);
			}
			// Insert or update user data to the database 
			$userID = $this->user_Model->checkUserWithProvider($userData);
			// Check user data insert or update status 
			if($userID>0){
				$userData = $this->user_Model->get_user_where(array("id_user" => $userID));
				$this->session->set_userdata('user_data', $userData);
			}elseif ($userID<0) {
				$alert = array(
					'code' => '002', //KODE PERINGATAN
					'message' => "Akun Di Blokir untuk Saar ini Silahkan hubungi CS"
				);
			}else{
				$alert = array(
					'code' => '999', //KODE FATAL SISTEM
					'message' => "Error Database"
				);
			}
		}

		if ($_POST) {
			$username = !empty($_POST["username"])?$_POST["username"]:'';
			$password = !empty($_POST["password"])?md5($_POST["password"]):'';

			$checkUserPass = $this->user_Model->checkUser($username, $password);
			$alert = array(
				'code' => '001', //KODE SALAH ATAU GAGAL
				'message' => "Username atau Password tidak benar!!"
			);
			if ($checkUserPass) {
				unset($alert);
				$userData = $this->user_Model->get_user_where(array("email" => $username));
				$this->session->set_userdata('access_token', '01');
				$this->session->set_userdata('user_data', $userData);
			}
		}
		if (isset($alert)) {
			$this->session->set_flashdata('alert', $alert);
		}

		if(!$this->session->userdata('access_token')||!$this->session->userdata('user_data')){
            $data['facebook_login'] =  $this->facebook->login_url();
			$data['google_login'] = $this->google->get_login_url();//'"><img src="https://1.bp.blogspot.com/-gvncBD5VwqU/YEnYxS5Ht7I/AAAAAAAAAXU/fsSRah1rL9s3MXM1xv8V471cVOsQRJQlQCLcBGAsYHQ/s320/google_logo.png" /></a>';
			$this->load->view('page_login', $data);
		}
		else{
			// uncomentar kode dibawah untuk melihat data session email
			// echo json_encode($this->session->userdata('access_token'));
			// echo json_encode($this->session->userdata('user_data'));
			// echo "Login success";
			redirect(base_url('MyApplication/dashboard')); 	
		}
	}

	public function logout()
	{
		if ($this->session->userdata('access_token')&&$this->session->userdata('user_data')) {
			$alert = array(
				"code" => '003',// KODE BERHASIL ATAU BENAR
				"message" => "Berhasil Logout"
			);
		}
		$this->session->set_flashdata('alert', $alert);
        // Remove local Facebook session 
        $this->facebook->destroy_session();
		// Remove local google session 
        $this->google->destroy_session();
		$this->session->unset_userdata('access_token');

		$this->session->unset_userdata('user_data');

		redirect(base_url("login"));
	}
}
