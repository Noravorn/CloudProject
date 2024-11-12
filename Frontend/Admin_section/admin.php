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
                <a href="#" class="active">
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
                <a href="#">
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
         <main>
             <h1>Dashboard</h1>
             <div class="insights">
                 <div class="blood-type">
                    <div class="top">
                        <span class="material-icons-sharp">pets</span>
                        <h3>Total Dog Blood Types</h3>
                    </div>
                    <div class="Chart">
                        <canvas id="dog-blood-types-chart"></canvas>
                    </div>
                 </div>
                 <!-- END OF DOG BLOOD TYPE -->

                 <div class="blood-type">
                    <div class="top">
                        <span class="material-icons-sharp">pets</span>
                        <h3>Total Cat Blood Types</h3>
                    </div>
                    <div class="Chart">
                         <canvas id="cat-blood-types-chart"></canvas>
                     </div>
                 </div>
                 <!-- END OF CAT BLOOD TYPE -->
             </div>
             <!-- END OF INSIGHTS -->
              
             <div class="counts">
                <div class="users">
                    <div class="top">
                        <span class="material-icons-sharp">group</span>
                        <h3>Total Users</h3>
                    </div>
                    <div class="number">
                        <h1>233</h1>
                    </div>
                 </div>
                 <!-- END OF USERS -->

                 <div class="pets">
                    <div class="top">
                        <span class="material-icons-sharp">pets</span>
                        <h3>Total Pets</h3>
                    </div>
                    <div class="number">
                        <h1>657</h1>
                    </div>
                 </div>
                 <!-- END OF PETS -->

                 <div class="clinic">
                    <div class="top">
                        <span class="material-icons-sharp">local_hospital</span>
                        <h3>Total Clinics</h3>
                    </div>
                    <div class="number">
                        <h1>211</h1>
                    </div>
                 </div>
                 <!-- END OF CLINICS -->
             </div>
             <!-- END OF COUNTS -->

             <div class="recent-donations">
                <h2>Recent Donations</h2>
             </div>
         </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./script.js"></script>
</body>
</html>