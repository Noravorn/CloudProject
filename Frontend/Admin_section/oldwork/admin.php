<!DOCTYPE html>
<html>

<head>
  <title>Admin Dashboard</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" type="text/css" href="../styles.css">
</head>

<body>

  <?php include 'admin_header.php'; ?>

  <div class="dashboard-container">
    <div class="charts-container">
      <div class="chart">
        <h2>Dog Blood Types</h2>
        <canvas id="dog-blood-types-chart"></canvas>
      </div>
      <div class="chart">
        <h2>Cat Blood Types</h2>
        <canvas id="cat-blood-types-chart"></canvas>
      </div>
    </div>
    <div class="widgets-container">
      <div class="widget">
        <h2>Total Users</h2>
        <p id="total-users-count"></p>
      </div>
      <div class="widget">
        <h2>Total Pets</h2>
        <p id="total-pets-count"></p>
      </div>
      <div class="widget">
        <h2>Total Clinics</h2>
        <p id="total-clinics-count"></p>
      </div>
      <div class="widget">
        <h2>Total Donations</h2>
        <p id="total-donations-count"></p>
      </div>
    </div>
    <div class="recent-donations-container">
      <h2>Recent Donations</h2>
      <div id="recent-donations-list"></div>
    </div>
  </div>

  <?php include 'footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="script.js"></script>
</body>

</html>