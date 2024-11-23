<footer id="footer" style="background-color: #2a2929; color: #fff; padding: 3rem 0; display: none;">
    <div class="container">
        <div class="row text-center text-md-start">

            <!-- Logo Section -->
            <div class="col-md-2 mb-4">
                <a class="navbar-brand" href="index.php" style="color: var(--text-color);">
                    <img src="src/images/logo2.svg" alt="Pawsitive Logo" width="150" height="150" class="d-inline-block align-text-top">
                </a>
            </div>

            <!-- About Section -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Pawsitive</h5>
                <p>Pawsitive provides progressive, accessible, and affordable healthcare, tailored for emergencies.</p>
                <p class="mb-0">&copy; Pawsitive PTY LTD 2024. All rights reserved.</p>
            </div>

            <!-- Website Links Section -->
            <div class="col-md-2 mb-4">
                <h5 class="fw-bold">Website</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">About</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Search for blood</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">News</a></li>
                </ul>
            </div>

            <!-- Location Links Section -->
            <div class="col-md-2 mb-4">
                <h5 class="fw-bold">Location</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Bangkok</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Ayutthaya</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Phuket</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Chiang Mai</a></li>
                </ul>
            </div>

            <!-- Help Section -->
            <div class="col-md-2 mb-4">
                <h5 class="fw-bold">Help</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Help center</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Platform support</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Instructions</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>


<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    body {
        position: relative;
        padding-bottom: 5rem;
        /* Add space for the footer */
    }

    .footer {
        background-color: #2a2929;
        color: #fff;
        padding: 3rem 0;
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        /* Ensure the footer is above other content */
        display: none;
        /* Hidden by default */
    }

    .container {
        max-width: 1140px;
        margin: 0 auto;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.addEventListener('scroll', function() {
            const footer = document.getElementById('footer');
            // Check if the user has scrolled to the bottom of the page
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                footer.style.display = 'block'; // Show footer when at the bottom
            } else {
                footer.style.display = 'none'; // Hide footer when not at the bottom
            }
        });
    });
</script>