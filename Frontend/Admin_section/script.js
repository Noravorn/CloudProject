// script.js

// Get the canvas elements
const dogChartCanvas = document.getElementById('dog-blood-types-chart');
const catChartCanvas = document.getElementById('cat-blood-types-chart');

// Create the charts
const dogChart = new Chart(dogChartCanvas, {
  type: 'pie',
  data: {
    labels: ['A', 'B', 'AB', 'O'],
    datasets: [{
      label: 'Dog Blood Types',
      data: [10, 20, 30, 40],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
      ],
      borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
      ],
      borderWidth: 1
    }]
  },
  options: {
    title: {
      display: true,
      text: 'Dog Blood Types'
    }
  }
});

const catChart = new Chart(catChartCanvas, {
  type: 'pie',
  data: {
    labels: ['A', 'B', 'AB', 'O'],
    datasets: [{
      label: 'Cat Blood Types',
      data: [10, 20, 30, 40],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
      ],
      borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
      ],
      borderWidth: 1
    }]
  },
  options: {
    title: {
      display: true,
      text: 'Cat Blood Types'
    }
  }
});