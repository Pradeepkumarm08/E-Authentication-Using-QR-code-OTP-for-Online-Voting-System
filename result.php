<?php
session_start();
include("db.php");
$sql = "SELECT party, COUNT(*) as count FROM vote GROUP BY party";
$result = $con->query($sql);
$parties = [];
$votes = [];
$totalVotes = 0;
while ($row = $result->fetch_assoc()) {
    $parties[] = $row['party'];
    $votes[] = $row['count'];
    $totalVotes += $row['count'];
}
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Voting Results 2026</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
    }
    .header {
      background-color: #007bff;
      color: white;
      padding: 15px;
      text-align: center;
    }
    nav a {
      margin: 0 15px;
      color: white;
      text-decoration: none;
      font-weight: bold;
    }
    .main-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding: 30px;
      align-items: stretch;
    }
    .bar-results {
      flex: 1;
      min-width: 300px;
      max-width: 600px;
      padding-right: 30px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .pie-chart {
      flex: 1;
      min-width: 300px;
      max-width: 500px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
    }
    .party-bar {
      margin-bottom: 25px;
    }
    .party-name {
      font-weight: bold;
      margin-bottom: 5px;
    }
    .bar-container {
      background-color: #e9ecef;
      border-radius: 20px;
      overflow: hidden;
      height: 30px;
      position: relative;
    }
    .bar-fill {
      height: 100%;
      line-height: 30px;
      color: white;
      font-weight: bold;
      padding-left: 10px;
      display: flex;
      align-items: center;
    }
    .green { background-color: #28a745; }
    .blue { background-color: #17a2b8; }
    .red { background-color: #dc3545; }
    .orange { background-color: #fd7e14; }
    .purple { background-color: #6f42c1; }
    canvas {
      width: 100% !important;
      height: 100% !important;
      max-width: 400px;
      max-height: 400px;
    }
    .canvas-wrapper {
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    @media (max-width: 768px) {
      .main-container {
        flex-direction: column;
        align-items: center;
      }
      .bar-results, .pie-chart {
        padding: 0;
        max-width: 100%;
      }
      canvas {
        max-height: 300px;
      }
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>Election Commission of India</h1>
    <nav>
      <a href="dashboard.php">Home</a>
      <a href="authenticate.php">Vote</a>
      <a href="result.php">Results</a>
      <a href="about.php">About Us</a>
      <a href="profile.php">Profile</a>
    </nav>
  </div>
  <div class="main-container">
    <div class="bar-results">
      <h2>Voting Results 2026</h2>
      <?php
        $colors = ['green', 'blue', 'red', 'orange', 'purple'];
        for ($i = 0; $i < count($parties); $i++) {
          $party = $parties[$i];
          $voteCount = $votes[$i];
          $percentage = $totalVotes > 0 ? round(($voteCount / $totalVotes) * 100) : 0;
          $colorClass = $colors[$i % count($colors)];
      ?>
        <div class="party-bar">
          <div class="party-name"><?php echo htmlspecialchars($party); ?></div>
          <div class="bar-container">
            <div class="bar-fill <?php echo $colorClass; ?>" style="width: <?php echo $percentage; ?>%;">
              <?php echo $percentage; ?>% - <?php echo $voteCount; ?> Votes
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="pie-chart">
      <h2>Vote Share</h2>
      <div class="canvas-wrapper">
        <canvas id="pieChart"></canvas>
      </div>
    </div>
  </div>
  <script>
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    const dataLabels = <?php echo json_encode($parties); ?>;
    const dataVotes = <?php echo json_encode($votes); ?>;
    const colors = ['#28a745', '#17a2b8', '#dc3545', '#fd7e14', '#6f42c1'];
    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: dataLabels,
        datasets: [{
          data: dataVotes,
          backgroundColor: colors
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });
  </script>
</body>
</html>
