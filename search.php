<!DOCTYPE html>
<html lang="en">

<?php include('header.php'); ?>
<?php include 'navbar.php'; ?>
<?php include 'connect.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch inputs
    $bloodType = $_POST['bloodType'] ?? '';
    $city = $_POST['city'] ?? '';
    $serviceHours = $_POST['serviceHours'] ?? '';

    try {
        // Prepare SQL query with placeholders
        $query = "
            SELECT 
                BLOOD_TYPES.Blood_Type_Name, 
                CLINICS.Clinic_Name, 
                CLINICS.Clinic_City, 
                CLINICS.Clinic_Open_Time, 
                CLINICS.Clinic_Close_Time
            FROM 
                STORAGE
            JOIN 
                BLOOD_TYPES ON STORAGE.Blood_Type_ID = BLOOD_TYPES.Blood_Type_ID
            JOIN 
                CLINICS ON STORAGE.Clinic_ID = CLINICS.Clinic_ID
            WHERE 
                BLOOD_TYPES.Blood_Type_Name = :bloodType
                AND CLINICS.Clinic_City = :city
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

        // Prepare the statement
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':bloodType', $bloodType, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Fetch results
        $filteredResults = $stmt->fetchAll();

        // Encode results to JSON
        $jsonResults = json_encode($filteredResults);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<body>

    <div class="container-fluid">
        <!-- Search Form -->
        <form id="searchForm" action="search.php" method="POST">

            <div class="container">
                <!-- Blood Search -->
                <div class="row mb-3">
                    <span>
                        Blood Search
                        <i class="ri-menu-search-line" style="color: var(--link-hovered-color);"></i>
                    </span>
                </div>

                <!-- Pet Species -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="petSpecies" class="form-label">Pet Species</label>
                        <select class="form-select" id="petSpecies" name="petSpecies">
                            <option value="Dog">Dog</option>
                            <option value="Cat">Cat</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="city" class="form-label">City *</label>
                        <select class="form-select" id="city" name="city">
                            <option value="Bangkok">Bangkok</option>
                            <option value="Chiang Mai">Chiang Mai</option>
                            <option value="Phuket">Phuket</option>
                            <!-- Add more cities as needed -->
                        </select>
                    </div>
                </div>

                <!-- Blood Type -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="bloodType" class="form-label">Blood Type *</label>
                        <select class="form-select" id="bloodType" name="bloodType">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>

                    <!-- Service Hours -->
                    <div class="col-md-6">
                        <label for="serviceHours" class="form-label">Service Hours</label>
                        <select class="form-select" id="serviceHours" name="serviceHours">
                            <option value="Morning">Morning</option>
                            <option value="Afternoon">Afternoon</option>
                            <option value="Evening">Evening</option>
                        </select>
                    </div>
                </div>

                <!-- Search Button -->
                <button id="search-button" type="submit" class="btn bg-black text-white w-100">Search</button>
            </div>
        </form>

        <!-- Search Results -->
        <div id="search-results" class="container mt-4">
            <!-- Results will be dynamically populated here -->
        </div>
    </div>

</body>

<script>
    // Handle results from PHP
    <?php if (isset($jsonResults)): ?>
        const searchResults = <?php echo $jsonResults; ?>;

        // Display results in 'search-results'
        const resultsContainer = document.getElementById('search-results');
        if (searchResults.length > 0) {
            searchResults.forEach(item => {
                const resultItem = document.createElement('div');
                resultItem.className = 'result-item mb-3';
                resultItem.innerHTML = `
                    <h5>Clinic Name: ${item.Clinic_Name}</h5>
                    <p>City: ${item.Clinic_City}</p>
                    <p>Blood Type: ${item.Blood_Type_Name}</p>
                    <p>Service Hours: ${item.Clinic_Open_Time} - ${item.Clinic_Close_Time}</p>
                `;
                resultsContainer.appendChild(resultItem);
            });
        } else {
            resultsContainer.innerHTML = '<p>No results found.</p>';
        }
    <?php endif; ?>

    // AJAX Fetch for Dynamic Results
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submit

        const formData = new FormData(this);
        const resultsContainer = document.getElementById('search-results');
        resultsContainer.innerHTML = '<p>Loading...</p>';

        // Fetch results dynamically
        fetch('', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            resultsContainer.innerHTML = '';
            if (data.length > 0) {
                data.forEach(item => {
                    const resultItem = document.createElement('div');
                    resultItem.className = 'result-item mb-3';
                    resultItem.innerHTML = `
                        <h5>Clinic Name: ${item.Clinic_Name}</h5>
                        <p>City: ${item.Clinic_City}</p>
                        <p>Blood Type: ${item.Blood_Type_Name}</p>
                        <p>Service Hours: ${item.Clinic_Open_Time} - ${item.Clinic_Close_Time}</p>
                    `;
                    resultsContainer.appendChild(resultItem);
                });
            } else {
                resultsContainer.innerHTML = '<p>No results found.</p>';
            }
        })
        .catch(error => {
            resultsContainer.innerHTML = '<p>An error occurred while searching.</p>';
            console.error(error);
        });
    });
</script>

</html>
