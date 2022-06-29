<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function redirect_ssl() {
	if( (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "") || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] != 'https') || (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] != 'on') ){
		$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("Location: $redirect");
	}
}