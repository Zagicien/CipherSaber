<?php
class CipherSaber {
	public $key = "";
	public $range = [];
	public $N = 1;
	function __construct(string $key, int $N = 1) {
		$this->key = $key;
		$this->N = $N;
		$this->range = range(0, 255);
	}
	function crypt(string $iv, string $data) {
		$this->_setup_key($iv);
		$output = $this->_do_crypt($data);
		$this->range = range(0, 255);
		return $output;
	}
	function encrypt(string $data) {
		$iv = $this->_gen_iv();
		return $iv . $this->crypt($iv, $data);
	}
	function decrypt(string $data) {
		$iv = substr($data, 0, 10);
		$message = substr($data, 10);
		return $this->crypt($iv, $message);
	}
	function _gen_iv() {
		$iv = "";
		foreach (range(1, 10) as $x) {
			$iv .= chr(rand(0, 255));
		}
		return $iv;
	}
	function _setup_key(string $data) {
		foreach (str_split($this->key . $data) as $i => $value) $key[$i] = ord($value);
		$j = 0;
		$length = count($key);
		foreach (range(1, $this->N) as $x) {
			foreach (range(0, 255) as $i) {
				$j += ($this->range[$i] + ($key[$i % $length]));
				$j %= 256;
				$this->range[$i] = $this->range[$j];
				$this->range[$j] = $this->range[$i];
			}
		}
	}
	function _do_crypt(string $data) {
		$i = 0;
		$j = 0;
		$n = 0;
		$output = '';
		foreach (range(0, strlen($data) - 1) as $_) {
			$i++;
			$i %= 256;
			$j += $this->range[$i];
			$j %= 256;
			$this->range[$i] = $this->range[$j];
			$this->range[$j] = $this->range[$i];
			$n = $this->range[$i] + $this->range[$j];
			$n %= 256;
			$output .= chr($this->range[$n] ^ ord(substr($data, $_, 1)));
		}
		return $output;
	}
}