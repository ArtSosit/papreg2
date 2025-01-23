<?php
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(0);

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
  // สร้างคำสั่ง SQL
  $query = "SELECT * FROM table2";
  $stmt = $conn->prepare($query);

  // ตรวจสอบการเตรียม statement
  if (!$stmt) {
    http_response_code(500);
    echo json_encode([
      'response' => 'error',
      'message' => 'Query preparation failed: ' . $conn->error
    ]);
    exit;
  }

  // ดำเนินการ statement
  $stmt->execute();

  // ตรวจสอบข้อผิดพลาดในการ execute
  if ($stmt->error) {
    http_response_code(500);
    echo json_encode([
      'response' => 'error',
      'message' => 'Query execution failed: ' . $stmt->error
    ]);
    exit;
  }

  // ดึงผลลัพธ์จาก query
  $result = $stmt->get_result();
  $data = $result->fetch_all(MYSQLI_ASSOC);

  // ตรวจสอบว่ามีข้อมูลใน table2 หรือไม่
  if (empty($data)) {
    http_response_code(404);
    echo json_encode([
      'response' => 'error',
      'message' => 'No data found in table2'
    ]);
    exit;
  }

  // ส่งผลลัพธ์กลับไปเป็น JSON
  http_response_code(200);
  echo json_encode([
    'response' => 'success',
    'data' => $data
  ]);

  // ปิด statement และ connection
  $stmt->close();
  $conn->close();
}
