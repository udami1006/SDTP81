<?php
header('Content-Type: application/json');
include '../config/config.php';

ob_start();

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

if (!isset($_GET['sensorId'])) {
    echo json_encode(["error" => "Sensor ID is required"]);
    exit();
}

$sensorId = intval($_GET['sensorId']);

$sql = "SELECT aqi_value, recorded_at FROM air_quality_data WHERE sensor_id = ? ORDER BY recorded_at ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $sensorId);
$stmt->execute();
$result = $stmt->get_result();

$aqi_data = [];
while ($row = $result->fetch_assoc()) {
    $aqi_data[] = [
        "date" => $row["recorded_at"],
        "aqi" => $row["aqi_value"]  
    ];
}

$stmt->close();
$conn->close();

echo json_encode($aqi_data);
ob_end_flush();
?>