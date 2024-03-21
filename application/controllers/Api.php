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
    public function tokenCI3_get(){
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

    // GET USER
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
                    ], RESTController::HTTP_OK );
                }
                else
                {
                    // Set the response and exit
                    $this->response( [
                        'status' => false,
                        'message' => 'No users were found'
                    ], RESTController::HTTP_NOT_FOUND );
                }
            }
            else {
                $this->response($decodedToken, RESTController::HTTP_UNAUTHORIZED);
            }
		}
		else {
			$this->response(['Authentication failed'], RESTController::HTTP_UNAUTHORIZED);
		}
    }

    //INPUT USER
    public function users_post()
    {
        $headers = $this->input->request_headers();
		if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status'])
            {
                $data = $this->post('data'); //Must be An ARRAY => Accepted ARRAY KEY(oauth_provider, oauth_uid, first_name, last_name, email); if Registrasi Manual(password)
                if ($data === null) {
                    $this->response( [
                        'status' => false,
                        'message' => 'The Data Incorrect'
                    ], RESTController::HTTP_NOT_ACCEPTABLE);
                }else{
                    $insert = $this->user_Model->input_user($data);
                    if ($insert>0) {
                        $this->response( [
                            'status' => true,
                            'message' => 'The Data Inserted'
                        ], RESTController::HTTP_CREATED);
                    }else{
                        $this->response( [
                            'status' => false,
                            'message' => 'INTERNAL ERROR'
                        ], RESTController::HTTP_INTERNAL_ERROR);
                    }
                }
            }
            else {
                $this->response($decodedToken, RESTController::HTTP_UNAUTHORIZED);
            }
		}
		else {
			$this->response(['Authentication failed'], RESTController::HTTP_UNAUTHORIZED);
		}
    }

    // UPDATE USER
    public function users_put()
    {
        $headers = $this->input->request_headers();
		if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status'])
            {
                $update_data = $this->put('update_data');
                $where_data = $this->put('where_data');
                if ($update_data === null || $where_data === null) {
                    $this->response( [
                        'status' => false,
                        'message' => 'The Params Incorrect'
                    ], RESTController::HTTP_NOT_ACCEPTABLE);
                }else{
                    $update = $this->user_Model->update_user($update_data, $where_data);
                    if ($update>0) {
                        $this->response( [
                            'status' => true,
                            'message' => 'The Data Updated'
                        ], RESTController::HTTP_CREATED);
                    }else{
                        $this->response( [
                            'status' => false,
                            'message' => 'INTERNAL ERROR'
                        ], RESTController::HTTP_INTERNAL_ERROR);
                    }
                }
            }
            else {
                $this->response($decodedToken, RESTController::HTTP_UNAUTHORIZED);
            }
		}
		else {
			$this->response(['Authentication failed'], RESTController::HTTP_UNAUTHORIZED);
		}
    }

    // DELETE USER
    public function users_delete()
    {
        $headers = $this->input->request_headers();
		if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status'])
            {
                $where_data = $this->delete('where_data');
                if ($where_data === null) {
                    if ($this->delete('confirm_all')) {
                        $delete = $this->user_Model->delete_all();
                        $this->response( [
                            'status' => true,
                            'message' => 'ALL Data Deleted'
                        ], RESTController::HTTP_OK);
                    }else {
                        $this->response( [
                            'status' => false,
                            'message' => 'Forbidden'
                        ], RESTController::HTTP_FORBIDDEN);
                    }
                }else{
                    $delete = $this->user_Model->delete_user($where_data);
                    if ($delete) {
                        $this->response( [
                            'status' => true,
                            'message' => 'The Data Deleted'
                        ], RESTController::HTTP_OK);
                    }else{
                        $this->response( [
                            'status' => false,
                            'message' => 'INTERNAL ERROR'
                        ], RESTController::HTTP_INTERNAL_ERROR);
                    }
                }
            }
            else {
                $this->response($decodedToken, RESTController::HTTP_UNAUTHORIZED);
            }
		}
		else {
			$this->response(['Authentication failed'], RESTController::HTTP_UNAUTHORIZED);
		}
    }
}