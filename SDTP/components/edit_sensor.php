<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['sensor_id'])) {
    $sensor_id = $_GET['sensor_id'];

    $stmt = $conn->prepare("SELECT * FROM sensors WHERE sensor_id = ?");
    $stmt->bind_param("i", $sensor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $sensor = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("UPDATE sensors SET name = ?, lat = ?, lng = ?, status = ? WHERE sensor_id = ?");
        $stmt->bind_param("ssssi", $name, $lat, $lng, $status, $sensor_id);
        if ($stmt->execute()) {
            echo "<script>alert('Sensor updated successfully!');</script>";
            header("Location: ../sensors.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css" />
    <title>Edit Sensor Data</title>
</head>

<body>
    <div class="new-sensor-forms">
        <h2>Edit Sensor Data</h2>
        <form style="padding: 40px; width: 40%;" action="" method="POST">
            <div class="input-group">
                <label for="name">Sensor Name</label>
                <input type="text" name="name" value="<?php echo $sensor['name']; ?>" required>
            </div>
            <div class="input-group">
                <label for="lat">Latitude</label>
                <input type="text" name="lat" value="<?php echo $sensor['lat']; ?>" required>
            </div>
            <div class="input-group">
                <label for="lng">Longitude</label>
                <input type="text" name="lng" value="<?php echo $sensor['lng']; ?>" required>
            </div>
            <div class="input-group">
                <label for="status">Status</label>
                <select name="status" required>
                    <option value="active" <?php if ($sensor['status'] == 'active') echo 'selected'; ?>>Active</option>
                    <option value="inactive" <?php if ($sensor['status'] == 'inactive') echo 'selected'; ?>>Inactive
                    </option>
                </select>
            </div>
            <button type="submit" class="btn" name="insert">Update Sensor</button>
        </form>
    </div>
</body>

</html>