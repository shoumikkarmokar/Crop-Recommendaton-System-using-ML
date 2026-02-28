<link rel="icon" type="image/x-icon" href="static/crop.ico">
<?php
// 1. Get form data safely
function getPostFloat($key) {
    return isset($_POST[$key]) && is_numeric($_POST[$key]) ? floatval($_POST[$key]) : 0.0;
}

$N = getPostFloat('Nitrogen');
$P = getPostFloat('Phosporus');
$K = getPostFloat('Potassium');
$temperature = getPostFloat('Temperature');
$humidity = getPostFloat('Humidity');
$ph = getPostFloat('pH');
$rainfall = getPostFloat('Rainfall');

// 2. Connect to MySQL
$servername = "localhost";
$username = "root";        // database username
$password = "";            // database password
$dbname   = "u313075777_crop";  // database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. Query function
function getCrop($conn, $N, $P, $K, $temperature, $humidity, $ph, $rainfall, $range) {
    $stmt = $conn->prepare("SELECT label, season, districts FROM crop_recommendation 
        WHERE ABS(N - ?) <= ? 
          AND ABS(P - ?) <= ? 
          AND ABS(K - ?) <= ? 
          AND ABS(temperature - ?) <= ? 
          AND ABS(humidity - ?) <= ? 
          AND ABS(ph - ?) <= ? 
          AND ABS(rainfall - ?) <= ? 
        LIMIT 1");

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind all 14 parameters as doubles
    $stmt->bind_param(
        "dddddddddddddd",
        $N, $range,
        $P, $range,
        $K, $range,
        $temperature, $range,
        $humidity, $range,
        $ph, $range,
        $rainfall, $range
    );

    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->fetch_assoc();
}

// 4. Try ranges
$crop = getCrop($conn, $N, $P, $K, $temperature, $humidity, $ph, $rainfall, 10);
if (!$crop) $crop = getCrop($conn, $N, $P, $K, $temperature, $humidity, $ph, $rainfall, 20);
if (!$crop) $crop = getCrop($conn, $N, $P, $K, $temperature, $humidity, $ph, $rainfall, 30);
if (!$crop) {
    $result = $conn->query("SELECT label, season, districts FROM crop_recommendation LIMIT 1");
    $crop = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Recommendation Result</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f1f2f6;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
    }
    .result-box {
      max-width: 600px;
      margin: auto;
      padding: 30px 20px;
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    .result-box img {
      width: 400px;
      height: 200px;
      object-fit: contain;
      margin-bottom: 20px;
    }
    h2 {
      color: #2c3e50;
      font-weight: bold;
      margin-bottom: 20px;
    }
    p {
      font-size: 20px;
      margin: 10px 0;
    }
    .btn-primary {
      padding: 10px 20px;
      border-radius: 8px;
    }
    @media (max-width: 576px) {
      .result-box {
        padding: 25px 15px;
      }
      p {
        font-size: 16px;
      }
      .result-box img {
        width: 120px;
        height: auto;
      }
    }
  </style>
</head>
<body>
  <div class="result-box">
    <img src="static/crop.png" alt="Crop Icon">
    <h2>Recommended Crop</h2>
    <p><strong>Crop:</strong> <?= htmlspecialchars($crop['label']) ?></p>
    <p><strong>Suitable Seasons:</strong> <?= htmlspecialchars($crop['season']) ?></p>
    <p><strong>Grown in Districts:</strong> <?= htmlspecialchars($crop['districts']) ?></p>
    <a href="index.php" class="btn btn-primary mt-4">Try Another</a>
  </div>
</body>
</html>