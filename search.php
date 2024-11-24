<?php session_start(); ?>
<?php include 'connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('header.php'); ?>
    <title>Search</title>
</head>

<?php include 'navbar.php'; ?>

<body>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 800px; border-radius: 12px; background-color: #f1efe7;">

            <div class="text-center mb-4 d-flex justify-content-center align-items-center">
                <h4 class="fw-bold mb-0 me-2" style="color: #2a2929;">Blood Search</h4>
                <i class="ri-menu-search-line" style="color: #d62323; font-size: 1.5rem;"></i>
            </div>

            <form id="searchForm" action="search.php" method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="petSpecies" class="form-label">Pet Species</label>
                        <select class="form-select" id="petSpecies" name="petSpecies">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="city" class="form-label">City </label>
                        <select class="form-select" id="city" name="city">
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="bloodType" class="form-label">Blood Type</label>
                        <select class="form-select" id="bloodType" name="bloodType">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="serviceHours" class="form-label">Service Hours</label>
                        <select class="form-select" id="serviceHours" name="serviceHours">
                            <option value="Morning">Morning</option>
                            <option value="Afternoon">Afternoon</option>
                            <option value="Evening">Evening</option>
                        </select>
                    </div>
                </div>

                <button id="search-button" name="sub" class="btn btn-danger w-100">Search</button>
            </form>

            <div id="search-results" class="mt-4">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sub'])) {
                    $bloodType = $_POST['bloodType'] ?? '';
                    $city = $_POST['city'] ?? '';
                    $petSpecies = $_POST['petSpecies'] ?? '';
                    $serviceHours = $_POST['serviceHours'] ?? '';

                    try {
                        // Updated SQL query
                        $query = "
                        SELECT DISTINCT
                            BLOOD_TYPES.Blood_Type_Name,
                            CLINICS.Clinic_Name,
                            CITIES.City_Name AS Clinic_City,
                            CLINICS.Clinic_Open_Time,
                            CLINICS.Clinic_Close_Time
                        FROM STORAGE
                        JOIN BLOOD_TYPES ON STORAGE.Blood_Type_ID = BLOOD_TYPES.Blood_Type_ID
                        JOIN CLINICS ON STORAGE.Clinic_ID = CLINICS.Clinic_ID
                        JOIN CITIES ON CLINICS.Clinic_City_ID = CITIES.City_ID
                        JOIN USERS ON STORAGE.Donor_ID = USERS.User_ID
                        JOIN PETS ON USERS.User_Pet_ID = PETS.Pet_ID
                        WHERE 
                            BLOOD_TYPES.Blood_Type_Name = :bloodType
                            AND CITIES.City_Name = :city
                            AND PETS.Pet_Type = :petSpecies
                    ";

                        // Add optional filter for service hours
                        if (!empty($serviceHours)) {
                            if ($serviceHours === 'Morning') {
                                $query .= " AND CLINICS.Clinic_Open_Time BETWEEN '06:00:00' AND '12:00:00'";
                            } elseif ($serviceHours === 'Afternoon') {
                                $query .= " AND CLINICS.Clinic_Open_Time BETWEEN '12:00:00' AND '18:00:00'";
                            } elseif ($serviceHours === 'Evening') {
                                $query .= " AND CLINICS.Clinic_Open_Time BETWEEN '18:00:00' AND '23:59:59'";
                            }
                        }

                        // Prepare the query
                        $stmt = $pdo->prepare($query);

                        // Bind parameters
                        $stmt->bindParam(':bloodType', $bloodType, PDO::PARAM_STR);
                        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
                        $stmt->bindParam(':petSpecies', $petSpecies, PDO::PARAM_STR);

                        // Execute the query
                        $stmt->execute();

                        // Fetch results
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Check if results are available
                        if ($results && count($results) > 0) {
                            // Start the table
                            echo '<table class="table table-bordered">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Blood Type</th>';
                            echo '<th>Clinic Name</th>';
                            echo '<th>City</th>';
                            echo '<th>Open Time</th>';
                            echo '<th>Close Time</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            // Loop through the results and populate the table rows
                            foreach ($results as $row) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['Blood_Type_Name']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['Clinic_Name']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['Clinic_City']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['Clinic_Open_Time']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['Clinic_Close_Time']) . '</td>';
                                echo '</tr>';
                            }

                            // End the table
                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            // No results found
                            echo '<div class="alert alert-warning">No results found for the selected criteria.</div>';
                        }
                    } catch (PDOException $e) {
                        echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
                    }
                }
                ?>
            </div>
        </div>

    </div>

    <script>
        // Populate dropdowns
        function populateDropdown(url, dropdownId) {
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const dropdown = document.getElementById(dropdownId);
                    dropdown.innerHTML = '<option value="">Select</option>';
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item;
                        option.textContent = item;
                        dropdown.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Load dropdown data on page load
        document.addEventListener('DOMContentLoaded', () => {
            populateDropdown('fetch_options.php?type=cities', 'city');
            populateDropdown('fetch_options.php?type=bloodTypes', 'bloodType');
            populateDropdown('fetch_options.php?type=petSpecies', 'petSpecies');
        });
    </script>
</body>
<?php include('footer.php'); ?>

</html>