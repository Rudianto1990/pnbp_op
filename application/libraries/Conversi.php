<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conversi {

function floatvalue($val){
    $val = str_replace(",",".",$val);
    $val = preg_replace('/\.(?=.*\.)/', '', $val);

    return
    floatval($val);
 }
}
// $number = "1,323,125.00";
// echo floatvalue($number);
