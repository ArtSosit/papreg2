<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
  // Database configuration
  $host = 'localhost';
  $username = 'root';
  $password = ''; // Update if necessary
  $dbname = 'papreg2'; // Replace with your database name

  // Create a connection to the database
  $conn = new mysqli($host, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit();
  }

  $action = $_POST['action'];
  $formId = isset($_POST['formId']) ? (int)$_POST['formId'] : 0;

  // Validate formId for actions that require it
  if (($action === 'deleteform' || $action === 'deletetable' || $action === 'deletetable2') && $formId <= 0) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid or missing formId']);
    $conn->close();
    exit();
  }

  switch ($action) {
    case 'deleteform':
      $stmt = $conn->prepare("DELETE FROM main WHERE sid = ?");
      break;

    case 'deletetable':
      $stmt = $conn->prepare("DELETE FROM table1 WHERE id = ?");
      break;

    case 'deletetable2':
      $stmt = $conn->prepare("DELETE FROM table2 WHERE id = ?");
      break;

    default:
      http_response_code(400);
      echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
      $conn->close();
      exit();
  }

  // Execute the statement
  if ($stmt) {
    $stmt->bind_param('i', $formId);

    if ($stmt->execute()) {
      echo json_encode(['status' => 'success', 'message' => "Record with ID $formId deleted successfully."]);
    } else {
      http_response_code(500);
      echo json_encode(['status' => 'error', 'message' => 'Failed to delete data: ' . $stmt->error]);
    }

    $stmt->close();
  } else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement: ' . $conn->error]);
  }

  // Close the database connection
  $conn->close();
  exit();
}
