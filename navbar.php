<nav class="navbar navbar-expand-lg" style="padding: 0 20px;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Logo on the Left -->
        <a class="navbar-brand" href="index.php" style="color: var(--text-color);">
            <img src="src/images/logo.svg" alt="Pawsitive Logo" width="100" height="100" class="d-inline-block align-text-top">
        </a>

        <!-- Centered Links -->
        <div class="d-flex flex-grow-1 justify-content-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a id="about-link" class="nav-link" href="about.php" style="color: var(--text-color);">About</a>
                </li>
                <li class="nav-item">
                    <a id="information-link" class="nav-link" href="information.php" style="color: var(--text-color);">Information</a>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['User_ID'])): ?>
                        <a class="nav-link" href="logout.php" style="color: var(--text-color);">
                            <i class="ri-logout-box-line"></i> Logout
                        </a>
                    <?php else: ?>
                        <a class="nav-link" href="login.php" style="color: var(--text-color);">
                            <i class="ri-user-line"></i> Login
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>

        <!-- Right-aligned Blood Search -->
        <div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="search.php" style="color: var(--text-color);">
                        <span>Blood Search</span>
                        <i class="ri-menu-search-line" style="color: var(--link-hovered-color);"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
