<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Curl\Curl;

class Sms extends CI_Controller {

	public $curl = null;
	public $sms_url = null;

	public function __construct()
	{
		parent::__construct();
		$this->curl = new Curl();
		$this->load->library("blowfishMod128");

		$this->sms_url = $this->config->item('sms_url');
	}

	public function verify(){

		$receive_time = microtime(true);

		log_message("debug", "Received Time: " . $receive_time, false);

		$this->load->model("users_model");

		$from = $this->input->get("from");
		$msg = $this->input->get("msg");

		$user_login = $this->users_model->user_verify($from);
		$user_login = reset($user_login);
		$cipher = $this->users_model->getCipherText($user_login->id);

		log_message("debug", "CIPHER TEXT: " . $cipher, false);

		$imei = $user_login->company;

		$xor = base64_decode($msg);
		$ct = $this->xor_string($xor, $imei);

		log_message("debug", "XOR TEXT: " . $ct, false);
		if($ct == $cipher){

			$verified_time = microtime(true);

			$data = array(
				"verified_date" => date("Y-m-d H:i:s"),
				"status" => 1,
				"received_time"=>$receive_time,
				"verified_time"=>$verified_time
			);

			$this->users_model->verifyLogin($user_login->id, $data);
		}

	}


	public function get_unread_messages()
	{
		$result = array();
		$this->load->model("users_model");
		$cipher = $this->users_model->getCipherText();

		$created_date = $this->users_model->getCreatedDateTime();
		$imei = $this->session->userdata("imei");
		$expiry = $this->config->item("sms_expiration_time");

		$date = new DateTime( $created_date );
		$date2 = new DateTime( date("Y-m-d H:i:s") );

		$diffInSeconds = $date2->getTimestamp() - $date->getTimestamp();

		if($diffInSeconds <= $expiry){

		$x = $this->curl->get( $this->sms_url . '?status=0' );
		$messages = array();

		if($x){
			foreach($x->messages as $msg){
				if($this->session->userdata("phone") == $msg->sender){
					$xor = base64_decode($msg->message);
					$ct = $this->xor_string($xor, $imei);

					if($ct == $cipher){
						$messages[] = $msg;
						break;
					}
				}
			}

			if(count($messages) > 0){
				$this->curl->put($this->sms_url . $messages[0]->id );
				$data = array(
					"verified_date" => date("Y-m-d H:i:s"),
					"status" => 1
				);

				$this->users_model->verifyLogin($this->session->userdata("user_login"), $data);
				$result['success'] = 1;
			}else{
				$result['success'] = 0;
			}
		}else{
			$result = array(
				'success' => 0,
				'msg' => "Invalid SMS API"
			);
		}
		}else{
			$result = array(
				'success' => 0,
				'msg' => "SMS Verification Expired."
			);
		}


		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result) );
	}

	public function send_message(){

			$blowfishMod = new BlowfishMod128();
			$imei = $this->session->userdata("imei");
			$text = $this->getRandomStr();
			$key = $this->getRandomStr();

			$numbers = range(0, 15);
			shuffle($numbers);
			$n = array_chunk($numbers, 6);
			$random = $n[0];

			$encrypt_dt = date("Y-m-d H:i:s");

			$start = microtime(true);
			$blowfish = $blowfishMod->encrypt($text, $key, $random);
			$end = microtime(true);

			$msg = base64_encode($blowfish->cipher);
			$rs = array();
			 $send_url = $this->sms_url . "SendSMS/user=&password=123456&phoneNumber=" . $this->session->userdata("phone") . "&msg=" . str_replace("=", "_", $msg);
			
			$result = $this->curl->get($send_url);

			if($result){
				$time_sent = date("Y-m-d H:i:s");

				$data = array(
					"encrypted_text" => $blowfish->cipher,
					"random_number" => implode(",", $random),
					"created_date" => $time_sent,
					'encrypt_dt' => $encrypt_dt,
					'encrypt_start' => $start,
					'encrypt_end' => $end
				);

				$this->load->model("users_model");
				$this->users_model->user_login($data, $this->session->userdata('user_login'));
				$rs = array(
					'success' => 1,
					'msg' => 'Message Sent'
				);

				$this->output
					->set_content_type('application/json')
					->set_output(json_encode($rs) );
			}else{
//				$rs = array(
//					'success' => 0,
//					'msg' => 'Invalid SMS API'
//				);
				echo "Invalid SMS API";
			}


	}

	public function getRandomStr($strlen=32){
		$randHexStr = implode( array_map( function() { return dechex( mt_rand( 0, 15 ) ); }, array_fill( 0, $strlen, null ) ) );
		return strtoupper($randHexStr);
	}
	
	function xor_string($string, $key) {
		$str_len = strlen($string);
		$key_len = strlen($key);

		for($i = 0; $i < $str_len; $i++) {
			$string[$i] = $string[$i] ^ $key[$i % $key_len];
		}

		return $string;
	}
}
