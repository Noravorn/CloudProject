<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('header.php'); ?>
    <title>Home</title>
</head>

<?php include('navbar.php'); ?>

<body>
    <div class="banner" style="background-color: #f1efe7; color: #2a2929; padding: 4rem 0;">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Content -->
                <div class="col-md-6 text-center text-md-start mb-4 mb-md-0">
                    <h1 class="banner-title fw-bold mb-4">"Connecting Pets to <br> Life-Saving Blood Resources"</h1>
                    <p class="mb-4">Pawsitive provides progressive, accessible, and affordable healthcare, tailored for emergencies.</p>
                    <a href="search.php" class="btn btn-lg text-white" style="background-color: #c32b45; transition: background-color 0.3s ease;"
                        onmouseover="this.style.backgroundColor='#b51d1d'" onmouseout="this.style.backgroundColor='#d62323'">Search for Blood Resources</a>
                </div>

                <!-- Right Image -->
                <div class="col-md-6 text-center">
                    <img src="src/images/corgicover.gif" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <main>

        <section class="py-5" style="background-color: #f9f9f9;">
            <div class="container">
                <!-- Section Header -->
                <div class="text-center mb-5">
                    <h3 class="fw-bold">Our Features</h3>
                    <div class="mx-auto mb-4" style="width: 100px; height: 2px; background-color: #2a2929;"></div>
                    <p class="text-muted mx-auto" style="max-width: 600px;">
                        Discover the innovative features of our pet blood bank platform, designed to streamline pet blood donation and save lives effectively.
                    </p>
                </div>
                <!-- Features Grid -->

                <div class="row g-4">
                    <!-- Features Item -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm text-center card-hover" style="border-radius: 15px; background-color: #fff;">
                            <div class="p-4">
                                <img src="src/images/lock.png" style="width: 80px; height: auto;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Secure and Reliable</h5>
                                <p class="card-text text-muted">Built on AWS cloud infrastructure, our platform ensures data safety and reliability for a trustworthy user experience.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Features Item -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm text-center card-hover" style="border-radius: 15px; background-color: #fff;">
                            <div class="p-4">
                                <img src="src/images/emergen.png" style="width: 80px; height: auto;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Emergency Support</h5>
                                <p class="card-text text-muted">During critical situations, our system provides real-time updates on blood stock availability, helping you locate the nearest donor or clinic quickly.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Features Item -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm text-center card-hover" style="border-radius: 15px; background-color: #fff;">
                            <div class="p-4">
                                <img src="src/images/usin.png" style="width: 80px; height: auto;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold">User-Friendly Interface</h5>
                                <p class="card-text text-muted">Designed for ease of use, our platform ensures a seamless experience for registering pets, searching for blood, and contacting clinics.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Features Item -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm text-center card-hover" style="border-radius: 15px; background-color: #fff;">
                            <div class="p-4">
                                <img src="src/images/network.png" style="width: 80px; height: auto;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Wide Network of Clinics</h5>
                                <p class="card-text text-muted">Partnered with veterinary clinics and hospitals across Thailand, our platform connects pet owners with the resources they need, wherever they are.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Features Item -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm text-center card-hover" style="border-radius: 15px; background-color: #fff;">
                            <div class="p-4">
                                <img src="src/images/datab.png" style="width: 80px; height: auto;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Comprehensive Database</h5>
                                <p class="card-text text-muted">Our platform hosts a centralized database for pet blood donors and available blood types, ensuring seamless access to vital information for pet owners and veterinarians.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Features Item -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm text-center card-hover" style="border-radius: 15px; background-color: #fff;">
                            <div class="p-4">
                                <img src="src/images/clk.png" style="width: 80px; height: auto;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Real-Time Updates</h5>
                                <p class="card-text text-muted">Stay informed with live data on donor availability and blood compatibility, ensuring efficient decision-making during emergencies.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!--How to Use Section -->
        <section class="py-5" style="background-color: #f1efe7; color: #2a2929;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <img src="src/images/7.png" class="img-fluid">
                    </div>
                    <div class="col-md-6">
                        <h3 style="color: #2a2929;">How to Use Our Website</h3>
                        <p style="color: #2a2929;">
                            Our platform is designed to simplify pet blood donation. From registering your pet as a blood donor to searching for compatible blood types during emergencies, everything is just a few clicks away. Explore the intuitive interface and experience seamless access to vital resources.
                        </p>
                        <a href="#" class="btn btn-lg text-white" style="background-color: #c32b45; transition: background-color 0.3s ease;"
                            onmouseover="this.style.backgroundColor='#b51d1d'" onmouseout="this.style.backgroundColor='#d62323'">Learn More</a>
                    </div>
                </div>
        </section>




        <!-- Articles Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h3 class="fw-bold">Check out our latest articles</h3>
                    <div class="mx-auto" style="width: 100px; height: 2px; background-color: #2a2929;"></div>
                </div>
                <div class="row g-4">
                    <!-- Article Item 1 -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm card-hover">
                            <img src="src/images/21.png" class="card-img-top" alt="Article">
                            <div class="card-body">
                                <h5 class="card-title">Understanding Pet Blood Types</h5>
                                <p class="card-text text-muted">A simple guide to pet blood types and their compatibility for transfusions.</p>
                                <a href="#" class="btn btn-link text-decoration-none" style="color: #c32b45;">Read More</a>
                            </div>
                        </div>
                    </div>
                    <!-- Article Item 2 -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm card-hover">
                            <img src="src/images/22.png" class="card-img-top" alt="Article">
                            <div class="card-body">
                                <h5 class="card-title">Emergency Preparedness for Pet Owners</h5>
                                <p class="card-text text-muted">Tips on how to prepare for emergencies and access vital blood resources quickly.</p>
                                <a href="#" class="btn btn-link text-decoration-none" style="color: #c32b45;">Read More</a>
                            </div>
                        </div>
                    </div>
                    <!-- Article Item 3 -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm card-hover">
                            <img src="src/images/23.png" class="card-img-top" alt="Article">
                            <div class="card-body">
                                <h5 class="card-title">Stories of Saved Lives</h5>
                                <p class="card-text text-muted">Inspiring stories of pets who received life-saving blood transfusions.</p>
                                <a href="#" class="btn btn-link text-decoration-none" style="color: #c32b45;">Read More</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>



</body>
<?php include('footer.php'); ?>

</html>