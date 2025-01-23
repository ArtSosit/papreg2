<?php
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(0);

try {
  $conn = new mysqli("localhost", "root", "", "papreg2");

  if ($conn->connect_error) {
    throw new Exception("Connection failed: " . $conn->connect_error);
  }

  $action = $_GET['action'] ?? '';
  if ($action === 'table1') {
    $query = "SELECT * FROM table1"; // เปลี่ยน query ตามที่ต้องการ
    $stmt = $conn->prepare($query);

    if (!$stmt) {
      echo json_encode(['response' => 'error', 'message' => 'Query preparation failed']);
      exit;
    }

    $stmt->execute();

    if ($stmt->error) {
      echo json_encode(['response' => 'error', 'message' => 'Query execution failed']);
      exit;
    }

    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    // ส่งผลลัพธ์กลับเป็น JSON
    echo json_encode(['response' => 'success', 'data' => $data]);
  } elseif ($action === 'table2') {
    $formIds = [6, 7, 8];

    if (!empty($formIds) && is_array($formIds)) {
      $placeholders = implode(',', array_fill(0, count($formIds), '?'));
      $query = "SELECT * FROM test2 WHERE fid IN ($placeholders)";
      $stmt = $conn->prepare($query);

      if (!$stmt) {
        die("Prepare failed: " . $conn->error);
      }
      $stmt->bind_param(str_repeat('i', count($formIds)), ...$formIds);
      $stmt->execute();

      if ($stmt->error) {
        die("Query failed: " . $stmt->error);
      }
      $result = $stmt->get_result();
      $data = $result->fetch_all(MYSQLI_ASSOC);

      echo json_encode(['response' => 'success', 'data' => $data]);
    } else {
      http_response_code(400);
      echo json_encode(['response' => 'error', 'message' => 'Invalid form IDs']);
    }
  }

  $conn->close();
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['response' => 'error', 'message' => $e->getMessage()]);
}
