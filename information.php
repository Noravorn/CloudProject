<!DOCTYPE html>
<html lang="en">

<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>


<body>
    <div class="container-fluid p-5">
        <div class="row gap-5">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-2 rounded-3 p-3 h-100" style="background-color: var(--secondary-color);">
                <a href="#" class="nav-link" data-section="information_patient">Patient Information</a>
                <a href="#" class="nav-link" data-section="information_pet">Pet Information</a>
                <a href="#" class="nav-link" data-section="information_history">Donation History</a>
            </nav>

            <!-- Main Content -->
            <main id="main-content" class="col-8 bg-white rounded-3 p-5 shadow-sm">
            </main>
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

