<?php
// admin.php

// Include the header file
include 'admin_header.php';

// Create the dashboard container
echo '<div class="dashboard-container">';

  // Create the charts container
  echo '<div class="charts-container">';
    // Create the dog blood types chart
    echo '<div class="chart">';
      echo '<h2>Dog Blood Types</h2>';
      echo '<canvas id="dog-blood-types-chart"></canvas>';
    echo '</div>';

    // Create the cat blood types chart
    echo '<div class="chart">';
      echo '<h2>Cat Blood Types</h2>';
      echo '<canvas id="cat-blood-types-chart"></canvas>';
    echo '</div>';
  echo '</div>';

  // Create the widgets container
  echo '<div class="widgets-container">';
    // Create the total users widget
    echo '<div class="widget">';
      echo '<h2>Total Users</h2>';
      echo '<p id="total-users-count"></p>';
    echo '</div>';

    // Create the total pets widget
    echo '<div class="widget">';
      echo '<h2>Total Pets</h2>';
      echo '<p id="total-pets-count"></p>';
    echo '</div>';

    // Create the active clinics widget
    echo '<div class="widget">';
      echo '<h2>Active Clinics</h2>';
      echo '<p id="active-clinics-count"></p>';
    echo '</div>';

    // Create the total donations widget
    echo '<div class="widget">';
      echo '<h2>Total Donations</h2>';
      echo '<p id="total-donations-count"></p>';
    echo '</div>';
  echo '</div>';

  // Create the recent donations container
  echo '<div class="recent-donations-container">';
    echo '<h2>Recent Donations</h2>';
    echo '<div id="recent-donations-list"></div>';
  echo '</div>';

echo '</div>';

// Include the footer file
include 'footer.php';
?>