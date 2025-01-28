<?php
// Enable error reporting for debugging (remove in production)

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Establish a database connection (shared for all actions)
$servername = "localhost";
$username = "root"; // Change this to your DB username
$password = ""; // Change this to your DB password
$dbname = "papreg2"; // Change this to your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(['response' => 'Database connection failed: ' . $conn->connect_error]);
  exit();
}

// Check if this is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the action from POST data
  $action = isset($_POST['action']) ? $_POST['action'] : null;

  if ($action === 'saveform') {
    // Retrieve and decode the Base64 reason
    $encodeddata = $_POST['data'] ?? null;
    $formId = $_POST['formId'] ?? null;

    if ($encodeddata && $formId) {
      $data = urldecode(base64_decode($encodeddata));

      // Use INSERT ... ON DUPLICATE KEY UPDATE
      $stmt = $conn->prepare("
        INSERT INTO main (sid, texts) 
        VALUES (?, ?) 
        ON DUPLICATE KEY UPDATE 
        texts = VALUES(texts)
      ");
      $stmt->bind_param("is", $formId, $data);

      if ($stmt->execute()) {
        echo json_encode(['response' => 'Data saved successfully!']);
      } else {
        http_response_code(500);
        echo json_encode(['response' => 'Failed to save data: ' . $stmt->error]);
      }

      $stmt->close();
    } else {
      http_response_code(400);
      echo json_encode(['response' => 'Invalid input data.']);
    }
  } elseif ($action === 'Allsave') {
    // รับข้อมูลจาก POST
    $id = $_POST['formId'] ?? null; // ID ที่ส่งมาจากฝั่งไคลเอนต์
    $originInfo = $_POST['origin_info'] ?? "<p><br></p>";
    $updatedInfo = $_POST['updated_info'] ?? "<p><br></p>";
    $improvInfo = $_POST['improv_info'] ?? "<p><br></p>";

    // ตรวจสอบว่ามี ID หรือไม่
    if ($id) {
      // อัปเดตข้อมูลใน table1 หากมี ID
      $stmt = $conn->prepare("
            INSERT INTO table1 (id, origin_info, updated_info, improv_info) 
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
                origin_info = VALUES(origin_info),
                updated_info = VALUES(updated_info),
                improv_info = VALUES(improv_info)
        ");
      $stmt->bind_param("isss", $id, $originInfo, $updatedInfo, $improvInfo);
    } else {
      // หากไม่มี ID ให้แทรกข้อมูลใหม่
      $stmt = $conn->prepare("
            INSERT INTO table1 (origin_info, updated_info, improv_info) 
            VALUES (?, ?, ?)
        ");
      $stmt->bind_param("sss", $originInfo, $updatedInfo, $improvInfo);
    }

    // ดำเนินการ SQL
    if ($stmt->execute()) {
      http_response_code(200);
      echo json_encode(['response' => 'success', 'message' => 'Data saved successfully!']);
    } else {
      http_response_code(500);
      echo json_encode(['response' => 'error', 'message' => 'Failed to save data: ' . $stmt->error]);
    }
    $stmt->close();
  } elseif ($action === 'Allsave2') {
    // รับข้อมูลจาก POST
    $id = $_POST['formId'] ?? null;
    $list_subject = $_POST['list_subject'] ?? null;
    $fields = [
      $_POST['selectedethics'] ?? null,
      $_POST['selectedknowledge'] ?? null,
      $_POST['selectedcognitive'] ?? null,
      $_POST['selectedrelationship'] ?? null,
      $_POST['selectedanalysis'] ?? null
    ];

    // ตรวจสอบว่าข้อมูลสำคัญไม่ว่าง
    if (!$list_subject) {
      http_response_code(400);
      echo json_encode(['response' => 'Missing required field: list_subject']);
      exit;
    }

    // สร้าง SQL และ Bind Params
    $query = $id
      ? "INSERT INTO table2 (id, list_subject, row2, row3, row4, row5, row6) 
      VALUES (?, ?, ?, ?, ?, ?, ?) 
      ON DUPLICATE KEY UPDATE 
      list_subject=VALUES(list_subject), row2=VALUES(row2), row3=VALUES(row3), 
      row4=VALUES(row4), row5=VALUES(row5), row6=VALUES(row6)"
      : "INSERT INTO table2 (list_subject, row2, row3, row4, row5, row6) 
      VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
      http_response_code(500);
      echo json_encode(['response' => 'Failed to prepare SQL statement: ' . $conn->error]);
      exit;
    }

    $id ? $stmt->bind_param("issssss", $id, $list_subject, ...$fields)
      : $stmt->bind_param("ssssss", $list_subject, ...$fields);

    // Execute SQL และตรวจสอบผลลัพธ์
    if ($stmt->execute()) {
      http_response_code(200);
      $response = ['response' => 'Data saved successfully!'];
      echo json_encode($response);
    } else {
      http_response_code(500);
      echo json_encode(['response' => 'Failed to save to table2: ' . $stmt->error]);
    }

    // ปิด statement
    $stmt->close();
  } else {
    http_response_code(405);
    echo json_encode(['response' => 'Only POST requests are allowed.']);
  }


  // Close database connection
  $conn->close();
}
