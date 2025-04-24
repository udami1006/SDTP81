<<<<<<< Updated upstream
=======
<?php
session_start();
include './config/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="./css/style.css" />
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
                <li class="active">
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

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <span class="text">Dashboard</span>
                </div>
                <div class="subtitle">
                    <i class="fa-solid fa-map"></i>
                    <h3 class="text">Map</h3>
                </div>
                <main>
                    <div id="map"></div>
                    <div id="legend" class="legend">
                        <h3>AQI Legend</h3>
                        <div class="legend-item" style=""><span style="background-color: green;"></span> Good (0-50)
                        </div>
                        <div class="legend-item" style=""><span style="background-color: yellow;"></span> Moderate
                            (51-100)
                        </div>
                        <div class="legend-item" style=""><span style="background-color: orange;"></span> Unhealthy
                            (101-150)
                        </div>
                        <div class="legend-item" style=""><span style="background-color: red;"></span> Very Unhealthy
                            (151-200)
                        </div>

                    </div>
                </main>


            </div>


        </div>
    </section>

    <script src="./js/script.js"></script>
    <script src="./js/actions.js"></script>
    <script>
    function callPhpScript() {
        fetch('./components/generate_aqi_data.php')
            .then(response => response.text())
            .then(data => {
                console.log('Data generated:', data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    callPhpScript();

    setInterval(callPhpScript, 900000); 
    </script>
</body>

</html>
>>>>>>> Stashed changes
