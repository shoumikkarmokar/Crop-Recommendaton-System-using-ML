<?php
include "db.php";
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Crop Recommendation System</title>
<link rel="icon" type="image/x-icon" href="static/crop.ico">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
  background: linear-gradient(to right, #a8edea, #fed6e3);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.navbar {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.form-section {
  background: white;
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
  margin-top: 40px;
  margin-bottom: 40px;
}
h1 {
  font-weight: 700;
  text-align: center;
  margin-bottom: 30px;
  color: #2d3436;
}
.card-custom {
  background: #2d3436;
  color: white;
  border-radius: 20px;
  margin: auto;
  margin-top: 30px;
  text-align: center;
  padding: 25px 20px;
  max-width: 400px;
}
.recommend-text {
  font-size: 22px;
  font-weight: bold;
  margin-top: 10px;
  color: #00cec9;
}
.season-text {
  font-size: 16px;
  margin-top: 10px;
  color: #ffeaa7;
}
footer {
  text-align: center;
  padding: 15px 0;
  background-color: #2d3436;
  color: white;
  margin-top: 30px;
}
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">🌿 Crop Recommendation System</a>
  </div>
</nav>

<div class="container">
  <div class="form-section">
    <h1>🌱 Find the Best Crop for You!</h1>

    <form action="predict.php" method="POST">
      <div class="row g-3">
        <div class="col-md-4">
          <label>Nitrogen</label>
          <input type="number" name="Nitrogen" class="form-control" required>
        </div>

        <div class="col-md-4">
          <label>Phosphorus</label>
          <input type="number" name="Phosporus" class="form-control" required>
        </div>

        <div class="col-md-4">
          <label>Potassium</label>
          <input type="number" name="Potassium" class="form-control" required>
        </div>

        <div class="col-md-4">
          <label>Temperature</label>
          <input type="number" step="0.01" name="Temperature" class="form-control" required>
        </div>

        <div class="col-md-4">
          <label>Humidity</label>
          <input type="number" step="0.01" name="Humidity" class="form-control" required>
        </div>

        <div class="col-md-4">
          <label>Soil pH</label>
          <input type="number" step="0.01" name="pH" class="form-control" required>
        </div>

        <div class="col-md-4">
          <label>Rainfall</label>
          <input type="number" step="0.01" name="Rainfall" class="form-control" required>
        </div>
      </div>

      <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Get Recommendation</button>
      </div>
    </form>

    <?php if (isset($_GET['crop'])): ?>
      <div class="card-custom">
        <img src="static/crop.png" style="width:200px; margin:20px auto;">
        <h5>Recommended Crop:</h5>
        <div class="recommend-text"><?= htmlspecialchars($_GET['crop']) ?></div>
        <h6 class="mt-3">Best Season:</h6>
        <div class="season-text"><?= htmlspecialchars($_GET['season']) ?></div>
      </div>
    <?php endif; ?>

  </div>
</div>

<footer>
© 2025 Crop Recommendation System
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>