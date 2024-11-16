<!DOCTYPE html>
<html lang="en">

<?php include('header.php'); ?>
<?php include 'navbar.php'; ?>
<?php include 'connect.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $petSpecies = $_POST['petSpecies'] ?? '';
    $location = $_POST['location'] ?? '';
    $bloodType = $_POST['bloodType'] ?? '';
    $serviceHours = $_POST['serviceHours'] ?? '';

    // Prepare SQL query with placeholders for filtering
    $query = "
        SELECT name, location, type, blood 
        FROM blood_banks 
        WHERE type = :petSpecies 
        AND location = :location 
        AND blood = :bloodType
    ";

    // Prepare the statement
    $stmt = $pdo->prepare($query);

    // Bind parameters
    $stmt->bindParam(':petSpecies', $petSpecies, PDO::PARAM_STR);
    $stmt->bindParam(':location', $location, PDO::PARAM_STR);
    $stmt->bindParam(':bloodType', $bloodType, PDO::PARAM_STR);

    // Execute the query
    $stmt->execute();

    // Fetch results
    $filteredResults = $stmt->fetchAll();

    $jsonResults = json_encode($filteredResults);
}
?>

<body>

    <div class="container-fluid">
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
                        <label for="location" class="form-label">Location *</label>
                        <select class="form-select" id="location" name="location">
                            <option value="Bangkok">Bangkok</option>
                            <option value="Chiang Mai">Chiang Mai</option>
                            <option value="Phuket">Phuket</option>
                            <!-- Add more locations as needed -->
                        </select>
                    </div>
                </div>

                <!-- Blood Type -->
                <div class="row mb-3">

                    <!-- Blood Type -->
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


        <div id="search-results" class="container mt-4">
            <!-- Results will be dynamically populated here -->
        </div>
    </div>

</body>

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
                        <h5>${item.name}</h5>
                        <p>Location: ${item.location}</p>
                        <p>Type: ${item.type}</p>
                        <p>Blood Type: ${item.blood}</p>
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