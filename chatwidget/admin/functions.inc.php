<?php
if (!function_exists('pr')) {
	function pr($arr){
		echo '<pre>';
		print_r($arr);
	}
}

if (!function_exists('prx')) {
	function prx($arr){
		echo '<pre>';
		print_r($arr);
		die();
	}
}

if (!function_exists('get_safe_value')) {
	function get_safe_value($con,$str){
		if($str!=''){
			$str=trim($str);
			return mysqli_real_escape_string($con,$str);
		}
	}
}

if (!function_exists('check_admin_auth')) {
	function check_admin_auth() {
		// Start session if not already started
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		
		// Check if admin is not logged in
		if(!isset($_SESSION['username'])) {
			header('location:login.php');
			die();
		}
		
		// Regenerate session ID periodically to prevent session fixation
		if (!isset($_SESSION['last_session_regenerate']) || 
			(time() - $_SESSION['last_session_regenerate']) > 1800) { // 30 minutes
			session_regenerate_id(true);
			$_SESSION['last_session_regenerate'] = time();
		}
	}
}

if (!function_exists('get_user_bots')) {
	function get_user_bots($con, $user_id) {
		$sql = "SELECT * FROM settings WHERE user_id = '$user_id' ORDER BY id DESC";
		$res = mysqli_query($con, $sql);
		$data = array();
		while($row = mysqli_fetch_assoc($res)) {
			$data[] = $row;
		}
		return $data;
	}
}