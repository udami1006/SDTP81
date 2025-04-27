<?php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
                <li class="active">
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

            <div class="admin-login">
                <a href="./components/login.php">
                    <span class="link-name">Admin</span>
                </a>
            </div>

        </div>

        <div class="container">

            <div class="table-wrapper">

                <h2>Sensor Data Management</h2>
                <table class="fl-table">
                    <thead>
                        <tr>
                            <th>Sensor ID</th>
                            <th>Name</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1001</td>
                            <td>Colomo</td>
                            <td>6.012546</td>
                            <td>8.326598</td>
                            <td>Active</td>
                            <td>
                                <!-- Form for Delete with confirmation -->
                                <form action="" method="POST" onsubmit="return confirmDelete()">
                                    <input type="hidden" name="sensor_id" value="<?php echo $row['sensor_id']; ?>">
                                    <button class="button-26" role="button" type="submit" name="delete">Delete</button>
                                    <button class="button-27" role="button" type="submit"
                                        onclick="location.href='./components/edit_sensor.php?sensor_id=<?php echo $row['sensor_id']; ?>'">Edit</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="new-sensor">
                <!-- Form to add a new sensor -->
                <h3 style="padding: 40px;">Add New Sensor</h3>
                <form style="padding: 40px;" action="" method="POST">
                    <div class="input-group">
                        <label for="name">Sensor Name</label>
                        <input type="text" name="name" placeholder="Sensor Name" required>
                    </div>
                    <div class="input-group">
                        <label for="lat">Latitude</label>
                        <input type="text" name="lat" placeholder="Latitude" required>
                    </div>
                    <div class="input-group">
                        <label for="lng">Longitude</label>
                        <input type="text" name="lng" placeholder="Longitude" required>
                    </div>
                    <div class="input-group">
                        <label for="status">Status</label>
                        <select name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn" name="insert">Add</button>

                </form>

            </div>
        </div>
    </section>
</body>

</html>

?>