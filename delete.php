<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
  // Database configuration
  $host = 'localhost';
  $username = 'root';
  $password = ''; // Update this if your database has a password
  $dbname = 'papreg2'; // Replace with your database name

  // Create a connection to the database
  $conn = new mysqli($host, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['response' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
  }

  // Handle single formId deletion
  if ($_POST['action'] === 'deleteform' && isset($_POST['formId'])) {
    $formId = isset($_POST['formId']) ? (int)$_POST['formId'] : 0;

    if ($formId > 0) {
      // Prepare and execute the delete query
      $stmt = $conn->prepare("DELETE FROM main WHERE sid = ?");
      $stmt->bind_param('i', $formId);

      if ($stmt->execute()) {
        echo json_encode(['response' => 'success']);
      } else {
        http_response_code(500);
        echo json_encode(['response' => 'Failed to delete data: ' . $stmt->error]);
      }

      $stmt->close();
    } else {
      http_response_code(400);
      echo json_encode(['response' => 'Invalid formId']);
    }
  }

  // Handle multiple formIds deletion
  else if ($_POST['action'] === 'deletetable' && isset($_POST['formId'])) {
    $formId = isset($_POST['formId']) ? (int)$_POST['formId'] : 0;

    if ($formId > 0) {
      // Prepare and execute the delete query
      $stmt = $conn->prepare("DELETE FROM table1 WHERE id = ?");
      $stmt->bind_param('i', $formId);

      if ($stmt->execute()) {
        echo json_encode(['response' => 'success']);
      } else {
        http_response_code(500);
        echo json_encode(['response' => 'Failed to delete data: ' . $stmt->error]);
      }

      $stmt->close();
    } else {
      http_response_code(400);
      echo json_encode(['response' => 'Invalid formId']);
    }
    $conn->close();
    exit();
  } else if ($_POST['action'] === 'deletetable2' && isset($_POST['formId'])) {
    $formId = isset($_POST['formId']) ? (int)$_POST['formId'] : 0;

    if ($formId > 0) {
      // Prepare and execute the delete query
      $stmt = $conn->prepare("DELETE FROM table2 WHERE id = ?");
      $stmt->bind_param('i', $formId);

      if ($stmt->execute()) {
        echo json_encode(['response' => 'success', 'message' => "Record with id $formId deleted successfully."]);
      } else {
        http_response_code(500);
        echo json_encode(['response' => 'error', 'message' => 'Failed to delete data: ' . $stmt->error]);
      }

      $stmt->close();
    } else {
      http_response_code(400);
      echo json_encode(['response' => 'error', 'message' => 'Invalid or missing formId']);
    }
  } else {
    http_response_code(400);
    echo json_encode(['response' => 'error', 'message' => 'Invalid action or missing parameters']);
  }

  // Close the database connection
  $conn->close();
  exit();
}
