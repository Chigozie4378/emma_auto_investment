<?php
include "../../../autoload/loader.php";

$data = json_decode(file_get_contents("php://input"), true);
$password = $data['password'] ?? '';
$page = $data['page'] ?? '';

$shared = new Shared();
$username = $shared->getUsername();
$auth_ctr = new AuthController();

header('Content-Type: application/json');

if (!$username || !$page) {
  echo json_encode(['success' => false, 'message' => 'Missing username or page.']);
  exit;
}

$result = $auth_ctr->checkUsername($username);

if (!$result->num_rows) {
  echo json_encode(['success' => false, 'message' => 'User not found.']);
  exit;
}

$row = $result->fetch_assoc();
$storedPassword = $row['password'];

if (password_verify($password, $storedPassword) || md5($password) === $storedPassword) {
  $_SESSION["verified_$page"] = true;
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => 'Incorrect password.']);
}
