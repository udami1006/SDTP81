<?php
session_start();
include './config/config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_alerts'])) {
    $moderate = $_POST['moderate'];
    $unhealthy = $_POST['unhealthy'];
    $very_unhealthy = $_POST['very_unhealthy'];
    $hazardous = $_POST['hazardous'];
    $enable_alerts = isset($_POST['enable_alerts']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE alert_settings SET moderate = ?, unhealthy = ?, very_unhealthy = ?, hazardous = ?, enable_alerts = ? WHERE id = 1");
    $stmt->bind_param("iiiii", $moderate, $unhealthy, $very_unhealthy, $hazardous, $enable_alerts);

    if ($stmt->execute()) {
        echo "<script>alert('Alert thresholds updated successfully!');</script>";
    } else {
        echo "Error updating settings: " . $stmt->error;
    }
}

// Fetch current alert settings
$sql = "SELECT * FROM alert_settings WHERE id = 1";
$result = $conn->query($sql);
$alert_settings = $result->fetch_assoc();

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
                <li>
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
                <li class="active">
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

        <div class="table-wrapper">

            <div class="new-sensor-forms">

                <h2 style="padding: 30px 40px 0px 40px;">AQI Alert Configuration</h2>

                <form method="POST" action="" style="padding: 40px; width: 40%;">
                    <div class="input-group">
                        <label>AQI Threshold for Moderate</label>
                        <input type="number" name="moderate" value="<?php echo $alert_settings['moderate']; ?>"
                            required>
                    </div>
                    <div class="input-group">
                        <label>AQI Threshold for Unhealthy</label>
                        <input type="number" name="unhealthy" value="<?php echo $alert_settings['unhealthy']; ?>"
                            required>
                    </div>
                    <div class="input-group">
                        <label>AQI Threshold for Very Unhealthy</label>
                        <input type="number" name="very_unhealthy"
                            value="<?php echo $alert_settings['very_unhealthy']; ?>" required>
                    </div>
                    <div class="input-group">
                        <label>AQI Threshold for Hazardous</label>
                        <input type="number" name="hazardous" value="<?php echo $alert_settings['hazardous']; ?>"
                            required>
                    </div>
                    <div class="input-group check">
                        <label>Enable Alerts</label>
                        <input type="checkbox" name="enable_alerts"
                            <?php echo $alert_settings['enable_alerts'] ? 'checked' : ''; ?>>
                    </div>
                    <button type="submit" class="btn" name="update_alerts">Update Alerts</button>
                </form>
            </div>
        </div>
    </section>
    <script src="./js/actions.js"></script>
</body>

</html>

<?php
$conn->close();
?>