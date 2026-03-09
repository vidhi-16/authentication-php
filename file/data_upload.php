<?php
header("Content-Type: application/json");

require_once "db.php"; 

// Allow only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => false,
        "message" => "Only POST method allowed"
    ]);
    exit;
}

// Check file upload
if (!isset($_FILES['file'])) {
    echo json_encode([
        "status" => false,
        "message" => "No file uploaded"
    ]);
    exit;
}

$file = $_FILES['file'];

// Validate file type
$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if ($fileExtension !== 'csv') {
    echo json_encode([
        "status" => false,
        "message" => "Only CSV files are allowed"
    ]);
    exit;
}

// Open CSV file
$handle = fopen($file['tmp_name'], "r");
if (!$handle) {
    echo json_encode([
        "status" => false,
        "message" => "Unable to read file"
    ]);
    exit;
}

$data = [];
$rowNumber = 0;


$stmt = $con->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
if (!$stmt) {
    die(json_encode([
        "status" => false,
        "message" => "Prepare statement failed: " . $con->error
    ]));
}

// Read CSV
while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $rowNumber++;

    // Skip empty rows
    if (count($row) < 3) continue;

    // Skip header row
    if ($rowNumber == 1 && strtolower($row[0]) == 'name') continue;

    $name = trim($row[0]);
    $email = trim($row[1]);
    $password = trim($row[2]);

    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  
    $stmt->bind_param("sss", $name, $email, $hashedPassword);
    if ($stmt->execute()) {
        $data[] = [
            "name" => $name,
            "email" => $email,
            "password" => $hashedPassword
        ];
    } else {
        
        continue;
    }
}

$stmt->close();
fclose($handle);

// Output JSON
echo json_encode([
    "status" => true,
    "message" => "CSV processed and data uploaded successfully",
    "total_records" => count($data),
    "data" => $data
]);