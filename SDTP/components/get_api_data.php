<?php
header('Content-Type: application/json');
include '../config/config.php';
ob_start();

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

$sql = "SELECT s.sensor_id, s.name, s.lat, s.lng, a.aqi_value
    FROM sensors s
    JOIN air_quality_data a ON s.sensor_id = a.sensor_id
    WHERE a.recorded_at = (
        SELECT MAX(recorded_at)
        FROM air_quality_data
        WHERE sensor_id = s.sensor_id
    )
";



$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["error" => "Database query failed", "details" => $conn->error]);
    exit();
}

$aqi_data = [];
while ($row = $result->fetch_assoc()) {
    $aqi_data[] = $row;
}

echo json_encode($aqi_data);

ob_end_flush(); 

?>