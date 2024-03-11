<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Load model 
        $this->load->model('user_Model'); 
        $this->load->library('Authorization_Token');
    }

    public function genJWTCI3_get(){
        $token_data['id'] = "002";//$user_id;
        $token_data['username'] = "@mail";//$username; 
        $tokenData = $this->authorization_token->generateToken($token_data);
        $final = array();
        $final['access_token'] = $tokenData;
        $final['status'] = true;

        $this->response($final, RESTController::HTTP_OK); 
    }
    public function tokenCI3_get() : Returntype {
        $headers = $this->input->request_headers(); 
		if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status'])
            {
                $this->response($decodedToken);
            }
            else {
                $this->response($decodedToken);
            }
		}
		else {
			$this->response(['Authentication failed'], RESTController::HTTP_OK);
		}
    }

    public function users_get()
    {
        $headers = $this->input->request_headers(); 
		if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status'])
            {
                $where_data = $this->get( 'where_data' );//must be an array
                $users = array();

                if ( $where_data === null )
                {
                    $users = $this->user_Model->get_users();
                }
                else
                {
                    $users = $this->user_Model->get_user_where($where_data);
                }
                
                // Check if the users data store contains users
                if ( count($users) > 0 )
                {
                    // Set the response and exit
                    $this->response( [
                        'status' => true,
                        'message' => 'Users available',
                        'data' => $users
                    ], 200 );
                }
                else
                {
                    // Set the response and exit
                    $this->response( [
                        'status' => false,
                        'message' => 'No users were found'
                    ], 404 );
                }
            }
            else {
                $this->response($decodedToken);
            }
		}
		else {
			$this->response(['Authentication failed'], RESTController::HTTP_OK);
		}
    }
}