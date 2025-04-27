<?php
include '../config/config.php';

$settingsQuery = "SELECT * FROM simulation_settings WHERE id = 1";
$settingsResult = $conn->query($settingsQuery);

if ($settingsResult->num_rows > 0) {
    $settings = $settingsResult->fetch_assoc();
    
    if ($settings['simulation_status'] == 'running') {
        $baselineAQI = (int) $settings['baseline_aqi'];
        $variation = (int) $settings['variation']; 
        $frequency = (int) $settings['frequency']; 

        function generateAqiValue($baseline, $variation) {
            return rand(max(0, $baseline - $variation), min(500, $baseline + $variation));
        }

        $sql = "SELECT sensor_id FROM sensors";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sensor_id = $row['sensor_id'];
                $aqi_value = generateAqiValue($baselineAQI, $variation);

                $insert_sql = "INSERT INTO air_quality_data (sensor_id, aqi_value, recorded_at) 
                               VALUES ($sensor_id, $aqi_value, NOW())";
                
                if ($conn->query($insert_sql) !== TRUE) {
                    echo "Error: " . $conn->error . "\n";
                }
            }
        }
    } else {
        echo "Simulation is stopped.\n";
    }
} else {
    echo "Simulation settings not found.\n";
}

$conn->close();
?>