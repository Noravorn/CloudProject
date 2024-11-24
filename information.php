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

<script>

    loadContent("information_patient");

    // Attach click event listeners to sidebar links
    document.querySelectorAll("#sidebar a").forEach(link => {
        link.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent default link behavior

            const section = this.getAttribute("data-section"); // Get the section name

            if (section === "logout") {
                window.location.href = this.href; // Redirect for logout
            } else {
                loadContent(section); // Load the content dynamically
            }
        });
    });

    // Function to load content into the main element
    function loadContent(section) {
        const mainContent = document.getElementById("main-content");

        // Optional: Show a loading message while fetching content
        mainContent.innerHTML = "<p>Loading...</p>";

        // Fetch the content (e.g., through AJAX)
        fetch(`${section}.php`)
            .then(response => {
                if (!response.ok) throw new Error("Network error");
                return response.text();
            })
            .then(html => {
                mainContent.innerHTML = html; // Replace main content with fetched HTML
            })
            .catch(error => {
                mainContent.innerHTML = `<p>Error loading content: ${error.message}</p>`;
            });
    }
</script>


<?php include('footer.php'); ?>
</html>

