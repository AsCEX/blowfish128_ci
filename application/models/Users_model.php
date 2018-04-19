<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model{

	public function get_user_login($id = null){
		if($id){
			$this->db->where("id", $id);
		}
		$query = $this->db->get("user_login");
		return $query->result_array();
	}

	public function user_login($data, $id=null){
		if($id){
			$this->db->where("id", $id);
			$this->db->update("user_login", $data);

			return $id;
		}else{
			$this->db->insert("user_login", $data);

			return $this->db->insert_id();
		}


	}

	public function user_verify($mobile = ""){
		$sql = "SELECT user_login.id, company FROM user_login
				LEFT JOIN users ON users.id = user_login.user_id
				WHERE users.phone = '" . trim($mobile) . "'
				ORDER by user_login.created_date DESC LIMIT 1";
		
		$query = $this->db->query($sql);     log_message("debug", $this->db->last_query(), false);

		return $query->result();
	}

	public function verifyLogin($id, $data){

		$this->db->where('id', $id);
		$this->db->update('user_login', $data);
	}

	public function getCipherText($id = null){

		if(!$id){
			$id = $this->session->userdata("user_login");
		}

		$sql = "SELECT encrypted_text FROM user_login WHERE id = ?";
		$query = $this->db->query($sql, array($id));

		$result = $query->result();

		if($result){
			return $result[0]->encrypted_text;
		}

		return "";
	}


	public function getCreatedDateTime(){
		$sql = "SELECT created_date FROM user_login WHERE id = ?";
		$query = $this->db->query($sql, array($this->session->userdata("user_login")));

		$result = $query->result();

		if($result){
			return $result[0]->created_date;
		}

		return "";
	}
}
