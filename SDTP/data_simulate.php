<?php
session_start();
include './config/config.php';

// Redirect if admin session is not set
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM simulation_settings WHERE id = 1";
$result = $conn->query($sql);

$simu_settings = $result->num_rows > 0 ? $result->fetch_assoc() : [
    'simulation_status' => 'stopped',
    'baseline_aqi' => 0,
    'variation' => 0,
    'frequency' => 0
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $simulation_status = $_POST['simulation_status'];
    $baseline_aqi = $_POST['baseline_aqi'];
    $variation = $_POST['variation'];
    $frequency = $_POST['frequency'];

    // Corrected SQL query (use `id = 1`, not `sensor_id = 1`)
    $stmt = $conn->prepare("UPDATE simulation_settings SET simulation_status = ?, baseline_aqi = ?, variation = ?, frequency = ? WHERE id = 1");
    $stmt->bind_param("siii", $simulation_status, $baseline_aqi, $variation, $frequency);

    if ($stmt->execute()) {
        echo "<script>alert('Simulation settings updated successfully!'); window.location.href = 'data_simulate.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/login.css" />
    <script src="https://kit.fontawesome.com/857ecf43e2.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Air Quality Monitoring Dashboard</title>
</head>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="./images/air-quality-96.png" alt="logo" />
            </div>

            <span class="logo_name">Air Quality Monitoring</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li>
                    <a href="./index.php">
                        <i class="fa-solid fa-house"></i>
                        <span class="link-name">Dahsboard</span>
                    </a>
                </li>
                <?php
                  if (isset($_SESSION['admin'])) { 
                ?>
                <li>
                    <a href="./sensors.php">
                        <i class="fa-solid fa-tablet-button"></i>
                        <span class="link-name">Sensors</span>
                    </a>
                </li>
                <li class="active">
                    <a href="./data_simulate.php">
                        <i class="fa-solid fa-chart-simple"></i>
                        <span class="link-name">Data Simulate</span>
                    </a>
                </li>
                <li>
                    <a href="./user_manage.php">
                        <i class="fa-solid fa-users-gear"></i>
                        <span class="link-name">User Manage</span>
                    </a>
                </li>

                <?php 
                  }
                ?>
                <li>
                    <a href="./notifications.php">
                        <i class="fa-solid fa-bell"></i>
                        <span class="link-name">Notification</span>
                    </a>
                </li>
                <li>
                    <a href="./help.php">
                        <i class="fa-solid fa-circle-info"></i>
                        <span class="link-name">Help</span>
                    </a>
                </li>

            </ul>

            <ul class="logout-mode">
                <li>
                    <a href="./components/logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="link-name">Logout</span>
                    </a>
                </li>


                <li class="mode">
                    <a href="#">
                        <i class="fa-solid fa-moon"></i>
                        <span class="link-name">Dark Mode</span>
                    </a>

                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="fa-solid fa-bars sidebar-toggle"></i>

            <div class=" search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search here..." />
            </div>

            <?php
              if (isset($_SESSION['admin'])) { 
            ?>
            <img src="./images/Profile-PNG-Photo.png" alt="" />
            <?php 
              }else{
            ?>

            <div class="admin-login">
                <a href="./components/login.php">
                    <span class="link-name">Admin</span>
                </a>
            </div>

            <?php
              }
            ?>

        </div>

        <div class="container">

            <div class="table-wrapper">

                <h2 style="padding: 30px 40px 0px 40px;">Data Simulation Management</h2>
                <div class="new-sensor-forms">

                    <form style="padding: 40px; width: 40%;" action="" method="POST" onsubmit="return confirmDelete()">
                        <div class="input-group">
                            <label for="simulation_status">Simulation Status</label>
                            <select name="simulation_status" required>
                                <option value="running"
                                    <?php echo ($simu_settings['simulation_status'] == 'running') ? 'selected' : ''; ?>>
                                    Start</option>
                                <option value="stopped"
                                    <?php echo ($simu_settings['simulation_status'] == 'stopped') ? 'selected' : ''; ?>>
                                    Stop</option>
                            </select>

                        </div>
                        <div class="input-group">
                            <label for="baseline_aqi">Baseline AQI</label>
                            <input type="text" name="baseline_aqi" value="<?php echo $simu_settings['baseline_aqi']; ?>"
                                required>
                        </div>
                        <div class="input-group">
                            <label for="variation">Variation</label>
                            <input type="text" name="variation" value="<?php echo $simu_settings['variation']; ?>"
                                required>
                        </div>
                        <div class="input-group">
                            <label for="frequency">Frequency</label>
                            <input type="text" name="frequency" value="<?php echo $simu_settings['frequency']; ?>"
                                required>
                        </div>
                        <button type="submit" class="btn" name="update">Update Simulate</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
    function confirmDelete() {
        return confirm("Are you sure you want to update the simulation?");
    }
    </script>
    <script src="./js/actions.js"></script>
</body>

</html>

<?php
$conn->close();
?>