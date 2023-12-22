<?php

function string_to_blob_hex($text){
    return strtoupper(bin2hex($text));
}

function hex_blob_to_string($hex){
  return hex2bin(strtolower($hex));
}

// function string_to_blob_hex($text){
//   $binaryData = '';
//     for ($i = 0, $len = strlen($text); $i < $len; $i++) {
//         $binaryData .= pack('C', ord($text[$i]));
//     }
//     return bin2hex($binaryData);
// }

// function hex_blob_to_string($hex){
//   $binaryData = hex2bin($hex);
//       $text = '';
//     $length = strlen($binaryData);

//     for ($i = 0; $i < $length; $i++) {
//         $text .= chr(unpack('C', $binaryData[$i])[1]);
//     }

//     return $text;
// }


// function string_to_blob($inp){
//   $str = encrypt($inp);
//   $bin = "";
//   for($i = 0, $j = strlen($str); $i < $j; $i++) 
//   $bin .= decbin(ord($str[$i])) . " ";
//   return $bin;
// }

// function blob_to_string($bin){
//   $char = explode(' ', $bin);
//   $userStr = '';
//   foreach($char as $ch) 
//   $userStr .= chr(bindec($ch));
//   return decrypt($userStr);
// }

// function encrypt($data) {
//     $key = 'd7l3kt0PhTmL4Tn5GatItTmF49pMh3A';
//     $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
//     $cipher = 'aes-256-cbc';
//     $options = 0;
//     // deepcode ignore HardcodedNonCryptoSecret: <please specify a reason of ignoring this>
//     return base64_encode(openssl_encrypt($data, $cipher, $key, $options, $iv));
// }

// function decrypt($data) {
//     $key = 'd7l3kt0PhTmL4Tn5GatItTmF49pMh3A';
//     $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
//     $cipher = 'aes-256-cbc';
//     $options = 0;
//     // deepcode ignore HardcodedNonCryptoSecret: <please specify a reason of ignoring this>
//     return openssl_decrypt(base64_decode($data), $cipher, $key, $options, $iv);
// }