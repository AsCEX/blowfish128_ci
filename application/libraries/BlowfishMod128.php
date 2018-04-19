<?php 
require_once( __DIR__ . '/blowfish128.php');


class BlowfishMod128 {

	public $padding_cbc = 0;
	public $padding = Blowfish128::BLOWFISH_PADDING_RFC;
	public $mode = NULL;
	public $k = "";
	public $pt = "";
	public $ct = "";
	public $iv = NULL;
	public $time = 0;

	public $hexText = "";
	public $hexKey = "";
	public $hexIV = "";


	public $plain_text = "";
	public $encryption_key = "";
	public $ciphertext =  "";

	public function encrypt($pt, $k, $random=array(), $iv = null){
		    $this->hexText = $pt;
		    $this->hexKey = $k;
		    $this->hexIV = $iv;

			$this->k = pack('H' . strlen($k), $k);
		    $this->pt = pack('H' . strlen($pt), $pt);


			$this->mode = Blowfish128::BLOWFISH_MODE_CBC;
			if(!$iv){
				$this->mode = Blowfish128::BLOWFISH_MODE_EBC;
			}

		    if ($this->mode == Blowfish128::BLOWFISH_MODE_CBC) {
		      $this->iv = trim($iv);
		      $this->iv = pack('H' . strlen($iv), $iv);
		      $this->padding_cbc = 64 - strlen($this->hexText);
		    }


		    if ($this->mode == Blowfish128::BLOWFISH_MODE_CBC) {
		      $this->padding = Blowfish128::BLOWFISH_PADDING_ZERO;
		    } else {
		      $this->padding = Blowfish128::BLOWFISH_PADDING_NONE;
		    }

			$bfish = Blowfish128::encrypt($this->pt, $this->k, $random, $this->mode, $this->padding, $this->iv);

			$this->ciphertext = $bfish['ciphertext'];

			$time = $bfish['end'] - $bfish['start'];
			$pt = unpack("H".strlen($this->hexText), $this->pt);
			$unpack_pt = reset($pt);
			$plain_text = strtoupper($unpack_pt);

			$ek = unpack("H".strlen($this->hexKey), $this->k);
			$unpack_ek = reset($ek);
			$encryption_key = strtoupper($unpack_ek);

			$ct = unpack("H".(strlen($this->hexText)+$this->padding_cbc), $this->ciphertext);
			$unpack_ct = reset($ct);
			$cipher_text =  strtoupper($unpack_ct);
			
//			$_iv = strtoupper(reset(unpack("H".strlen($this->hexIV), $this->iv)));
			$_iv = null;

			//Blowfish::decrypt($expected_ciphertext, $this->k, $mode, $padding, $iv);

			return (object)array(
				'plaintext' => $plain_text,
				'key' => $encryption_key,
				'cipher' => $cipher_text,
				'iv' => $_iv,
				'encryption_time' => $time,
				'rand' => $bfish['rand']
			);
	}

	public function decrypt($ct, $k, $random=array(), $iv=null){

		    $this->hexText = $ct;
		    $this->hexKey = $k;
		    $this->hexIV = $iv;


			$this->k = pack('H' . strlen($k), $k);
		    $this->ct = pack('H' . strlen($ct), $ct);


			$this->mode = Blowfish128::BLOWFISH_MODE_CBC;
			if(!$iv){
				$this->mode = Blowfish128::BLOWFISH_MODE_EBC;
			}

		    if ($this->mode == Blowfish128::BLOWFISH_MODE_CBC) {
		      $this->iv = trim($iv);
		      $this->iv = pack('H' . strlen($iv), $iv);
		    }


		    if ($this->mode == Blowfish128::BLOWFISH_MODE_CBC) {
		      $this->padding = Blowfish128::BLOWFISH_PADDING_ZERO;
		    } else {
		      $this->padding = Blowfish128::BLOWFISH_PADDING_NONE;
		    }
		    $b = new Blowfish128();
			$bfish = $b->decrypt($this->ct, $this->k, $random, $this->mode, $this->padding, $this->iv);
			$this->plaintext = $bfish['plaintext'];

			$time = $bfish['end'] - $bfish['start'];

			$cipher_text = strtoupper(reset(unpack("H".strlen($this->hexText), $this->ct)));
			$encryption_key = strtoupper(reset(unpack("H".strlen($this->hexKey), $this->k)));
			$plain_text =  rtrim(strtoupper(reset(unpack("H*" , $this->plaintext))),"0");
			$_iv = strtoupper(reset(unpack("H".strlen($this->hexIV), $this->iv)));

			return (object)array(
				'plaintext' => $plain_text,
				'key' => $encryption_key,
				'cipher' => $cipher_text,
				'iv' => $_iv,
				'encryption_time' => $time,
				'rand' => $bfish['rand']
			);
	}


	function ham_distance($string1, $string2){
		$len1 = strlen($string1);
		$len2 = strlen($string2);
		$length = $len1;
		if($len2 > $len1){
			$length	= $len2;
		}

		$string1 = str_pad($string1, $length, "0", STR_PAD_LEFT);
		$string2 = str_pad($string2, $length, "0", STR_PAD_LEFT);
	    $res = array_diff_assoc(str_split($string1), str_split($string2));
	    return count($res);
	}

	function convBase($numberInput, $fromBaseInput, $toBaseInput)
	{
	    if ($fromBaseInput==$toBaseInput) return $numberInput;
	    $fromBase = str_split($fromBaseInput,1);
	    $toBase = str_split($toBaseInput,1);
	    $number = str_split($numberInput,1);
	    $fromLen=strlen($fromBaseInput);
	    $toLen=strlen($toBaseInput);
	    $numberLen=strlen($numberInput);
	    $retval='';
	    if ($toBaseInput == '0123456789')
	    {
	        $retval=0;
	        for ($i = 1;$i <= $numberLen; $i++)
	            $retval = bcadd($retval, bcmul(array_search($number[$i-1], $fromBase),bcpow($fromLen,$numberLen-$i)));
	        return $retval;
	    }
	    if ($fromBaseInput != '0123456789')
	        $base10=$this->convBase($numberInput, $fromBaseInput, '0123456789');
	    else
	        $base10 = $numberInput;
	    if ($base10<strlen($toBaseInput))
	        return $toBase[$base10];
	    while($base10 != '0')
	    {
	        $retval = $toBase[bcmod($base10,$toLen)].$retval;
	        $base10 = bcdiv($base10,$toLen,0);
	    }
	    return $retval;
	}

	function isBinary($str) {

		if (strspn ( $str , '01') == strlen($str)) {
		    return true;
		}

		return false;

	}

}
