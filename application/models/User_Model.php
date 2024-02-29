<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model {
    private $tableName;
    private $primaryKey;

    function __construct() {
        parent::__construct();

        $this->tableName = 'users';
        $this->primaryKey = 'id_user';
    }
    
    public function checkUser($username, $password){
        $this->db->select("*");
        $this->db->from($this->tableName);
        $this->db->where(array('email'=>$username, 'password'=>$password));
        return $this->db->get()->num_rows();
    }

    public function checkUserWithProvider($data = array()){
        if(!empty($data)){
            //check whether user data already exists in database with same oauth info
            $this->db->select("".$this->primaryKey.", is_block");
            $this->db->from($this->tableName);
            $this->db->where(array('oauth_provider'=>$data['oauth_provider'], 'oauth_uid'=>$data['oauth_uid']));
            $prevQuery = $this->db->get();
            $prevCheck = $prevQuery->num_rows();
            
            if($prevCheck > 0){
                $prevResult = $prevQuery->row_array();
                
                //update user data
                $data['modified'] = date("Y-m-d H:i:s");
                $update = $this->db->update($this->tableName, $data, array($this->primaryKey => $prevResult[$this->primaryKey]));
                
                //get user ID
                $userID = $prevResult[$this->primaryKey];
                if ($prevResult['is_block']) {
                    $userID = -1;
                }
            }else{
                //insert user data
                $data['created']  = date("Y-m-d H:i:s");
                $data['modified'] = date("Y-m-d H:i:s");
                $insert = $this->db->insert($this->tableName, $data);
                
                //get user ID
                $userID = $this->db->insert_id();
            }
        }
        
        //return user ID
        return $userID?$userID:0;
    }

    public function get_users(){
        return $this->db->get($this->tableName);
    }
    public function get_user_where($whereData = array()){
        return $this->db->get_where($this->tableName, $whereData);
    }
    public function input_user($data){
        $this->db->insert($this->tableName, $data);
        $input_id = $this->db->insert_id();
        return $input_id?$input_id:0;
    }
    public function update_user($updateData, $whereData){
        $this->db->update($this->tableName, $updateData, $whereData);
        return $this->db->affected_rows();
    }
    public function delete_user($whereData){
        return $this->db->delete($this->tableName, $whereData);
    }
    public function delete_all(){
        return $this->db->empty_table($this->tableName);
    }
    
}