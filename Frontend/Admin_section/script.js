// script.js

// Get the canvas elements
const dogChartCanvas = document.getElementById('dog-blood-types-chart');
const catChartCanvas = document.getElementById('cat-blood-types-chart');

// Create the charts
const dogChart = new Chart(dogChartCanvas, {
  type: 'pie',
  data: {
    labels: ['DEA 1.1', 'DEA 1.2', 'DEA 3', 'DEA 4', 'DEA 5', 'DEA 6', 'DEA 7', 'DEA 8'],
    datasets: [{
      label: 'Dog Blood Types',
      data: [90, 50, 25, 10, 5, 2, 1],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(126, 87, 194, 0.2)',
        'rgba(201, 203, 207, 0.2)'
      ],
      borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(126, 87, 194, 1)',
        'rgba(201, 203, 207, 1)'
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
    labels: ['A', 'B', 'AB'],
    datasets: [{
      label: 'Cat Blood Types',
      data: [30, 20, 15],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
      ],
      borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
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