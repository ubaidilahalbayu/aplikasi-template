<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

Class Google
{
    private $gc;
    private $gs;

    public function __construct() {    
        $this->load->config('google');
        // Load required libraries and helpers 
        $this->load->library('session'); 
        $this->load->helper('url'); 

        if (!isset($this->gc)) {
		  $this->gc = new Google_Client();
		  $this->gc->setClientId($this->config->item('google_client_id'));
		  $this->gc->setClientSecret($this->config->item('google_client_secret'));
		  $this->gc->setRedirectUri($this->config->item('google_redirect_url'));
		  $this->gc->addScope('email');
		  $this->gc->addScope('profile');
        }
    }
    
    public function object(){ 
        return $this->gc; 
    } 

    public function get_login_url(){
        return $this->gc->createAuthUrl();
    }

    public function get_user_data($get_code){
        $token = $this->fetch_token($get_code);
        if (!isset($token["error"])) {
            $this->gc->setAccessToken($token['access_token']);
            $this->set_access_token($token['access_token']);
        }
        $this->gs = new Google_Service_Oauth2($this->gc);
        $data = $this->gs->userinfo->get();
        $data['access_token'] = $token['access_token'];
        return $data;
    }

    
    public function destroy_session(){ 
        $this->session->unset_userdata('google_access_token'); 
    } 

    private function fetch_token($get_code){
        return $this->gc->fetchAccessTokenWithAuthCode($get_code);
    }

    private function set_access_token($access_token){
        $this->session->set_userdata('google_access_token', $access_token);
    }

    private function get_access_token(){
        return $this->session->set_userdata('google_access_token');
    }

    /** 
     * Enables the use of CI super-global without having to define an extra variable. 
     * 
     * @param $var 
     * 
     * @return mixed 
     */ 
    public function __get($var){ 
        return get_instance()->$var; 
    } 
}