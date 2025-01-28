<?php
header('Content-Type: application/json; charset=utf-8'); // Set JSON Header

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
  try {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'papreg2';

    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
      throw new Exception('Database connection failed: ' . $conn->connect_error);
    }

    $action = $_POST['action'];
    $formId = isset($_POST['formId']) ? (int)$_POST['formId'] : 0;

    if (in_array($action, ['deleteform', 'deletetable', 'deletetable2']) && $formId <= 0) {
      throw new Exception('Invalid or missing formId');
    }

    switch ($action) {
      case 'deleteform':
        // ตรวจสอบให้แน่ใจว่าคอลัมน์ 'id' ในตาราง 'main' มีจริง หรือเปลี่ยนชื่อคอลัมน์ตามความต้องการ
        $stmt = $conn->prepare("UPDATE main SET texts = '' WHERE sid = ?");
        break;

      case 'deletetable':
        $stmt = $conn->prepare("DELETE FROM table1 WHERE id = ?");
        break;

      case 'deletetable2':
        $stmt = $conn->prepare("DELETE FROM table2 WHERE id = ?");
        break;

      default:
        throw new Exception('Invalid action');
    }

    if (!$stmt) {
      throw new Exception('Failed to prepare statement: ' . $conn->error);
    }

    $stmt->bind_param('i', $formId);
    if (!$stmt->execute()) {
      throw new Exception('Failed to execute query: ' . $stmt->error);
    }
    echo json_encode(['status' => 'success']);
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
  } finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
  }
} else {
  http_response_code(400);
  echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
