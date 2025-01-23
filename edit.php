<?php
header('Content-Type: application/json'); // Set Content-Type header
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection function
function getDatabaseConnection()
{
  $conn = new mysqli("localhost", "root", "", "papreg2");
  if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['response' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
  }
  return $conn;
}

// General function to fetch data from a table by ID
function fetchDataByTable($tableName, $id)
{
  $conn = getDatabaseConnection();

  // Validate table name to prevent SQL injection
  $allowedTables = ['table1', 'table2'];
  if (!in_array($tableName, $allowedTables)) {
    http_response_code(400);
    echo json_encode(['response' => 'Invalid table name']);
    $conn->close();
    exit();
  }

  $sql = "SELECT * FROM $tableName WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id);

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode(['response' => 'success', 'data' => $data]);
  } else {
    http_response_code(500);
    echo json_encode(['response' => 'SQL Error: ' . $stmt->error]);
  }

  $stmt->close();
  $conn->close();
}

// Main logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'] ?? null;

  if (!$id || !is_numeric($id)) {
    http_response_code(400);
    echo json_encode(['response' => 'Invalid or missing ID']);
    exit();
  }

  if ($_POST['action'] === 'getAll') {
    fetchDataByTable('table1', (int)$id);
  } elseif ($_POST['action'] === 'getAll2') {
    fetchDataByTable('table2', (int)$id);
  } else {
    http_response_code(400);
    echo json_encode(['response' => 'Invalid action']);
  }
} else {
  http_response_code(405);
  echo json_encode(['response' => 'Only POST requests are allowed.']);
}
