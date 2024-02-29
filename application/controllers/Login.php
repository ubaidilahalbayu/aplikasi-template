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
         
        // Load facebook oauth library 
        $this->load->library(array('facebook', 'google')); 
         
        // Load user model 
        // $this->load->model('user'); 
    } 

	public function index()
	{
		$userData = array();
		$current_datetime = date('Y-m-d H:i:s');
        
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
				$userData['gender']        = !empty($fbUser['gender'])?$fbUser['gender']:''; 
				$userData['picture']    = !empty($fbUser['picture']['data']['url'])?$fbUser['picture']['data']['url']:''; 
				$userData['link']        = !empty($fbUser['link'])?$fbUser['link']:'https://www.facebook.com/'; 
				
				// Insert or update user data to the database 
				// $userID = $this->user->checkUser($userData); 
				
				// Check user data insert or update status 
				// if(!empty($userID)){ 
					$data['user_data'] = $userData; 
					
					// Store the user profile info into session
					
					$this->session->set_userdata('access_token',$this->facebook->is_authenticated());
					$this->session->set_userdata('user_data', $userData); 
				// }else{ 
				//    $data['userData'] = array(); 
				// } 
				
				// Facebook logout URL 
				$data['logoutURL'] = $this->facebook->logout_url(); 
			}else{ 
				// Facebook authentication url
				$userData = $this->google->get_user_data($_GET['code']);
				$user_data = array(
					'first_name' => !empty($userData['given_name'])?$userData['given_name']:'',
					'last_name'  => !empty($userData['family_name'])?$userData['family_name']:'',
					'email_address' => !empty($userData['email'])?$userData['email']:'',
					'profile_picture'=> !empty($userData['picture'])?$userData['picture']:'',
					'updated_at' => $current_datetime
					);
				$this->session->set_userdata('access_token', $userData['access_token']);
				$this->session->set_userdata('user_data', $user_data);
			}
		}

		if(!$this->session->userdata('access_token')){
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
		
        // Remove local Facebook session 
        $this->facebook->destroy_session();
        $this->google->destroy_session();
		$this->session->unset_userdata('access_token');

		$this->session->unset_userdata('user_data');

		redirect(base_url("login"));
	}
}
