<!DOCTYPE html>
<html lang="en">

<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>


<body>
    <div class="container-fluid p-5">
        <div class="row gap-5">
            <!-- Sidebar -->
            <nav id="sidebar" class="col rounded-3 p-3 h-100" style="background-color: var(--secondary-color);">
                <a href="#" class="nav-link" data-section="patient-info">Patient Information</a>
                <a href="#" class="nav-link" data-section="history">History</a>
                <a href="#" class="nav-link" data-section="logout">Logout</a>
            </nav>

            <!-- Main Content -->
            <main class="col-6 bg-white rounded-3 p-5 shadow-sm">
                <div id="patient-info">
                    <h3 class="mb-3">Patient Information</h3>

                    <p>Owner Title: <span>User Title</span></p>
                    <p>Owner Name: <span>UserF UserL</span></p>
                    <p>Owner Email: <span>User_email</span></p>
                    <p>Owner Phone: <span>User phone num</span></p>
                    <p>Address: <span>User Address</span></p>
                    <p>Pet Name: <span>Pet Name</span></p>
                    <div class="additional-info">
                        <p>Pet ID: <span>Pet ID</span></p>
                        <p>Pet Age: <span>Pet Age</span></p>
                        <p>Pet Blood Type: <span>Pet Blood Type</span></p>
                        <p>Registered Clinic: <span>User Clinic</span></p>
                    </div>
                </div>
            </main>

            <!-- Pet Name Dropdown -->
            <div class="col rounded-3 p-5" style="background-color: var(--secondary-color);">
                <div class="dropdown">
                    <label for="pet-name" class="form-label">Pet Name</label>
                    <select id="pet-name" class="form-select">
                        <option>Select Pet</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

</body>


<style>
    #sidebar a {
        display: block;
        color: var(--text-color);
        text-decoration: none;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    #sidebar a:hover {
        background-color: var(--link-hovered-color);
        color: white;
    }
</style>
<?php include('footer.php'); ?>
</html>

