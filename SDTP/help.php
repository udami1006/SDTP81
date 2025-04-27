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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <script src="https://cdn.tailwindcss.com"></script>
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
                <li>
                    <a href="./notifications.php">
                        <i class="fa-solid fa-bell"></i>
                        <span class="link-name">Notification</span>
                    </a>
                </li>
                <li class="active">
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

        <div class="max-w-5xl mt-12 mx-auto px-6 py-10">
            <h1 class="text-4xl font-bold text-blue-700 mb-6">Real-time Air Quality Monitoring Dashboard for
                Colombo</h1>

            <section class="mb-10">
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">Overview</h2>
                <p>
                    Air pollution is a growing concern in Colombo, impacting public health and the environment. The
                    Colombo Municipal Council is developing a real-time air quality monitoring system to provide
                    publicly accessible AQI data.
                    This dashboard simulates air quality data from sensors across Colombo and displays real-time and
                    historical AQI trends.
                </p>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">System Features</h2>
                <ul class="list-disc ml-6 space-y-1">
                    <li>Real-time AQI data visualization on a map</li>
                    <li>Historical AQI trend charts</li>
                    <li>Sensor management (simulated)</li>
                    <li>Automated AQI data simulation</li>
                    <li>Alert configuration and display</li>
                    <li>User management for system admins</li>
                </ul>
            </section>

            <section class="mb-10">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">User Roles</h2>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-blue-600">Monitoring Admin (Environmental Agency/System Admin)
                    </h3>
                    <p class="mb-2">Responsible for system configuration and simulated sensor management.</p>
                    <ul class="list-disc ml-6 space-y-1">
                        <li>Secure login</li>
                        <li>Register and manage sensors on the map</li>
                        <li>Configure simulation parameters</li>
                        <li>Set AQI alert thresholds and display settings</li>
                        <li>Manage admin user accounts</li>
                        <li>View system and simulation status dashboard</li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-blue-600">Data Provider (Simulated Sensor Data Generator)</h3>
                    <p class="mb-2">Responsible for automated AQI data generation.</p>
                    <ul class="list-disc ml-6 space-y-1">
                        <li>Generates AQI data at regular intervals (e.g., every 5-15 mins)</li>
                        <li>Stores data for historical access</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-blue-600">Public User</h3>
                    <p class="mb-2">Accesses real-time and historical AQI data.</p>
                    <ul class="list-disc ml-6 space-y-1">
                        <li>No login required</li>
                        <li>Map view with color-coded AQI markers</li>
                        <li>Click on markers to view AQI and trends</li>
                        <li>Interactive charts for daily trends</li>
                        <li>Legend for AQI color codes</li>
                    </ul>
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">AQI Color Legend</h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 bg-green-500 rounded-full"></div>
                        <span>Good</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 bg-yellow-400 rounded-full"></div>
                        <span>Moderate</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 bg-orange-500 rounded-full"></div>
                        <span>Unhealthy for Sensitive Groups</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 bg-red-600 rounded-full"></div>
                        <span>Unhealthy</span>
                    </div>
                </div>
            </section>
        </div>
    </section>
    <script src="./js/actions.js"></script>
</body>

</html>