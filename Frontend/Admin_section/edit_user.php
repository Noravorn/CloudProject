<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Material Icons-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"
          rel="stylesheet">
    <!--Stylesheet-->
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="./images/Pawsitive logo.png" alt="Logo">
                    <h2>Pet <span class="danger">Blood Bank</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>

            <div class="sidebar">
                <a href="#">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">history</span>
                    <h3>History</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">pets</span>
                    <h3>Pet Data</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">edit</span>
                    <h3>Edit Pet Data</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">account_circle</span>
                    <h3>User Management</h3>
                </a>
                <a href="#" class="active">
                    <span class="material-icons-sharp">edit</span>
                    <h3>Edit User</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">local_hospital</span>
                    <h3>Clinic Management</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">edit</span>
                    <h3>Edit Clinic</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!-- END OF SIDEBAR -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./script.js"></script>
</body>
</html>