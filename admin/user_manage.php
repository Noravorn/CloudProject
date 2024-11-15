<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <aside class="col-md-2 bg-white vh-100 p-3 shadow">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <img src="../src/images/logo.svg" alt="Logo" class="img-fluid me-2" style="width: 80px;">
                        <h2 class="h5">Pet <span class="text-danger">Blood Bank</span></h2>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary d-md-none" id="close-btn">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <nav class="nav flex-column">
                    <a href="#" class="nav-link text-secondary d-flex align-items-center mb-2">
                        <i class="bi bi-grid-fill me-2"></i> Dashboard
                    </a>
                    <a href="#" class="nav-link text-secondary d-flex align-items-center mb-2">
                        <i class="bi bi-clock-history me-2"></i> History
                    </a>
                    <a href="#" class="nav-link text-secondary d-flex align-items-center mb-2">
                        <i class="bi bi-paw me-2"></i> Pet Data
                    </a>
                    <a href="#" class="nav-link text-secondary d-flex align-items-center mb-2">
                        <i class="bi bi-pencil-square me-2"></i> Edit Pet Data
                    </a>
                    <a href="#" class="nav-link text-primary d-flex align-items-center mb-2 active">
                        <i class="bi bi-person-circle me-2"></i> User Management
                    </a>
                    <a href="#" class="nav-link text-secondary d-flex align-items-center mb-2">
                        <i class="bi bi-hospital me-2"></i> Clinic Management
                    </a>
                    <a href="#" class="nav-link text-danger d-flex align-items-center mt-auto">
                        <i class="bi bi-box-arrow-left me-2"></i> Logout
                    </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="col-md-10 bg-light vh-100">
                <div class="container py-3">
                    <h1 class="h4">Dashboard</h1>
                    <p class="text-muted">Welcome to the Pet Blood Bank Management System.</p>
                </div>
            </main>
        </div>
    </div>

</body>

</html>