<?php
require 'Base32.class.php';
require 'CipherSaber.class.php';
$Cipher = new CipherSaber("my sad secret key");
$output = $Cipher->encrypt("Here is a secret message for you");
echo Base32::encode($output); // wr0zum2clmqkeo1qtpcc4mviutd2eqdutpuo3uyu0xfivlpnxxuybkhyvhbw5r40xclq
