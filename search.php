<!DOCTYPE html>
<html lang="en">

<?php include('header.php'); ?>
<?php include 'navbar.php'; ?>
<?php include 'connect.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $bloodType = $_POST['bloodType'] ?? '';
    $city = $_POST['city'] ?? '';

    try {
        // Prepare SQL query with placeholders for filtering
        $query = "
            SELECT Blood_Types.Blood_Type_Name, Clinic.Clinic_Name, Clinic.Clinic_City, Clinic.Clinic_Open_Time
            FROM Storage

            JOIN Blood_Types ON Storage.Blood_Type_ID = Blood_Types.Blood_Type_ID
            JOIN Clinic ON Storage.Clinic_ID = Clinic.Clinic_ID

            WHERE Blood_Types.Blood_Type_Name = :bloodType
            AND Clinic.Clinic_City = :city
        ";

        // Prepare the statement
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':bloodType', $bloodType, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Fetch results
        $filteredResults = $stmt->fetchAll();

        $jsonResults = json_encode($filteredResults);

        echo $jsonResults;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

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
                    </select>
                </div>
            </div>

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
                <div class="col-md-6">
                    <label for="serviceHours" class="form-label">Service Hours</label>
                    <select class="form-select" id="serviceHours" name="serviceHours">
                        <option value="Morning">Morning</option>
                        <option value="Afternoon">Afternoon</option>
                        <option value="Evening">Evening</option>
                    </select>
                </div>
            </div>

            <button id="search-button" type="submit" class="btn btn-danger w-100">Search</button>
        </form>
    </div>
</div>



</body>
<?php include('footer.php'); ?>

<script>
    // This part checks if PHP has already returned search results
    <?php if (isset($jsonResults)): ?>
        const searchResults = <?php echo $jsonResults; ?>;

        // Display results in the 'search-results' div
        const resultsContainer = document.getElementById('search-results');
        if (searchResults.length > 0) {
            searchResults.forEach(item => {
                const resultItem = document.createElement('div');
                resultItem.className = 'result-item mb-3';
                resultItem.innerHTML = `
                        <h5>Clinic Name: ${item.Clinic_Name}</h5>
                        <p>City: ${item.Clinic_City}</p>
                        <p>Blood Type: ${item.Blood_Type_Name}</p>
                        <p>Service Hours: ${item.Clinic_Open_Time}</p>
                    `;
                resultsContainer.appendChild(resultItem);
            });
        } else {
            resultsContainer.innerHTML = '<p>No results found.</p>';
        }
    <?php endif; ?>

    // JavaScript to handle dynamic search results (without page reload)
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent form from reloading the page

        const formData = new FormData(this);
        const resultsContainer = document.getElementById('search-results');
        resultsContainer.innerHTML = '<p>Loading...</p>';

        // Fetch the search results dynamically using the same page (this file)
        fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Extract search results from the page response
                const resultsStart = data.indexOf('<div id="search-results"');
                const resultsEnd = data.indexOf('</div>', resultsStart) + 6;
                const resultsHTML = data.substring(resultsStart, resultsEnd);

                // Replace the current results with the new ones
                resultsContainer.innerHTML = resultsHTML;

            })
            .catch(error => {
                resultsContainer.innerHTML = '<p>An error occurred while searching.</p>';
                console.error(error);
            });
    });
</script>

</html>