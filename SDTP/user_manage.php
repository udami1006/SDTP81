<?php
session_start();
include './config/config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM admins";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert'])) {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
    $role = $_POST['status_role'];
    $status = $_POST['status'];

    if ($password !== $c_password) {
        echo "<script>alert('Passwords do not match!'); window.location.href='user_manage.php';</script>";
        exit();
    }
    
    $stmt = $conn->prepare("INSERT INTO admins (username, name, password, role, status) VALUES (?, ?, ?, ?,?)");
    $stmt->bind_param("sssss", $username, $name, $password, $role, $status);
    if ($stmt->execute()) {
        header("Location: user_manage.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('Account deleted successfully!');</script>";
            header("Location: user_manage.php");
            exit();
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
                            <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['password']; ?></td>
                                <td><?php echo $row['role']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td>
                                    <!-- Form for Delete with confirmation -->
                                    <form action="" method="POST" onsubmit="return confirmDelete()">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button class="button-26" role="button" type="submit"
                                            name="delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="new-sensor-forms">
                    <h2 style="padding: 30px 40px 0px 40px;">Create User</h2>
                    <form style="padding: 40px; width: 40%;" action="" method="POST" onsubmit="return confirmDelete()">
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
    </script>
    <script src="./js/actions.js"></script>
</body>

</html>

<?php
$conn->close();
?>