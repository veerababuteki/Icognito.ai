<?php
/**
 * Security and Validation Functions
 */

function sanitize_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
	return $data;
}

function get_safe_value($con, $str) {
	if (empty($str)) {
		return '';
	}
	$str = sanitize_input($str);
	return mysqli_real_escape_string($con, $str);
}

function validate_file($file, $allowed_types = ['image/png', 'image/jpg', 'image/jpeg'], $max_size = 5242880) {
	if (!isset($file['error']) || is_array($file['error'])) {
		return ['status' => false, 'message' => 'Invalid file parameters'];
	}

	if ($file['error'] !== UPLOAD_ERR_OK) {
		return ['status' => false, 'message' => 'File upload failed'];
	}

	if (!in_array($file['type'], $allowed_types)) {
		return ['status' => false, 'message' => 'Invalid file type'];
	}

	if ($file['size'] > $max_size) {
		return ['status' => false, 'message' => 'File too large'];
	}

	return ['status' => true, 'message' => 'File is valid'];
}

/**
 * Chat Related Functions
 */

function save_chat_message($con, $user_id, $message, $timestamp = null) {
	$user_id = (int)$user_id;
	$message = get_safe_value($con, $message);
	$timestamp = $timestamp ?? date('Y-m-d H:i:s');
	
	$sql = "INSERT INTO chat_messages (user_id, message, created_at) VALUES (?, ?, ?)";
	$stmt = mysqli_prepare($con, $sql);
	mysqli_stmt_bind_param($stmt, "iss", $user_id, $message, $timestamp);
	return mysqli_stmt_execute($stmt);
}

function get_chat_history($con, $user_id, $limit = 50) {
	$user_id = (int)$user_id;
	$limit = (int)$limit;
	
	$sql = "SELECT * FROM chat_messages WHERE user_id = ? ORDER BY created_at DESC LIMIT ?";
	$stmt = mysqli_prepare($con, $sql);
	mysqli_stmt_bind_param($stmt, "ii", $user_id, $limit);
	mysqli_stmt_execute($stmt);
	
	$result = mysqli_stmt_get_result($stmt);
	return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Session Management
 */

function init_session() {
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	if (!isset($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	}
}

function verify_csrf_token($token) {
	return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Error Handling
 */

function log_error($message, $context = []) {
	$log_entry = date('Y-m-d H:i:s') . ' - ' . $message . ' - ' . json_encode($context) . PHP_EOL;
	error_log($log_entry, 3, BASE_PATH . '/logs/error.log');
}

// Remove debug functions from production
if ($_SERVER['SERVER_NAME'] !== 'localhost') {
	function pr() { return false; }
	function prx() { return false; }
} else {
	function pr($arr) {
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}
	
	function prx($arr) {
		pr($arr);
		die();
	}
}

function get_product($con,$limit='',$cat_id='',$product_id=''){

	$sql="select product.*,categories.categories from product,categories where product.status=1";
	if($cat_id!=''){
		$sql.=" and product.categories_id=$cat_id ";
	}
	if($product_id!=''){
		$sql.=" and product.id=$product_id ";
	}
	$sql.=" and product.categories_id=categories.id ";
	$sql.=" order by product.id asc";
	if($limit!=''){
		$sql.=" limit $limit";
	}
	
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}