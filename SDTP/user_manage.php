<?php

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
                <li class="active">
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

            <img src="./images/Profile-PNG-Photo.png" alt="" />
            

            <div class="admin-login">
                <a href="./components/login.php">
                    <span class="link-name">Admin</span>
                </a>
            </div>

        </div>

        <div class="container">

            <div class="table-wrapper">

                <h2 style="padding: 30px 40px 0px 40px;">User Management</h2>

                <div class="table-wrapper">
                    <table class="fl-table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr>
                                <td>User</td>
                                <td>user</td>
                                <td>user123</td>
                                <td>admin</td>
                                <td>Active</td>
                                <td>
                                    <!-- Form for Delete with confirmation -->
                                    <form action="" method="POST" >
                                        <input type="hidden" name="id" value="1001">
                                        <button class="button-26" role="button" type="submit"
                                            name="delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                           
                        </tbody>
                    </table>
                </div>

                <div class="new-sensor-forms">
                    <h2 style="padding: 30px 40px 0px 40px;">Create User</h2>
                    <form style="padding: 40px; width: 40%;" action="" method="POST" >
                        <div class="input-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" placeholder="username" required>
                        </div>
                        <div class="input-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" placeholder="name" required>
                        </div>
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" placeholder="password" required>
                        </div>
                        <div class="input-group">
                            <label for="c_password">Confirm Password</label>
                            <input type="password" name="c_password" placeholder="confirm password" required>
                        </div>
                        <div class="input-group">
                            <label for="status_role">Role</label>
                            <select name="status_role" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
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
        </div>
    </section>

    <script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete admin?");
    }
    
</body>

</html>

?>