<?php
require_once '../db.php';

if (!isset($_GET['ob_number']) || empty($_GET['ob_number'])) {
    echo "OB number not provided.";
    exit;
}

$ob_number = $_GET['ob_number'];

$stmt = $pdo->prepare("SELECT * FROM occurrences WHERE ob_number = ?");
$stmt->execute([$ob_number]);
$occurrence = $stmt->fetch();

if (!$occurrence) {
    echo "No occurrence found for OB Number: " . htmlspecialchars($ob_number);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Occurrence Detail</title>
  <style>
    :root {
      --police-blue: #003366;
      --police-gold: #FFD700;
      --police-red: #d7261e;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 700px;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-top: 5px solid var(--police-blue);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: var(--police-blue);
    }

    .detail {
      margin-bottom: 15px;
    }

    .detail label {
      font-weight: bold;
      display: inline-block;
      width: 200px;
      color: var(--police-blue);
    }

    .detail span {
      display: inline-block;
    }

    .actions {
      margin-top: 30px;
      text-align: center;
    }

    .actions a, .actions button {
      padding: 10px 15px;
      text-decoration: none;
      background: var(--police-blue);
      color: #fff;
      border-radius: 3px;
      margin: 0 5px;
      display: inline-block;
      border: none;
      cursor: pointer;
      transition: 0.3s;
    }

    .actions a:hover, .actions button:hover {
      background: var(--police-gold);
      color: black;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Occurrence Detail</h2>

    <div class="detail">
      <label>OB Number:</label>
      <span><?= htmlspecialchars($occurrence['ob_number']) ?></span>
    </div>

    <div class="detail">
      <label>Reference Number:</label>
      <span><?= htmlspecialchars($occurrence['reference_number']) ?></span>
    </div>

    <div class="detail">
      <label>Occurrence Date:</label>
      <span><?= htmlspecialchars($occurrence['occurrence_date']) ?></span>
    </div>

    <div class="detail">
      <label>Occurrence Time:</label>
      <span><?= htmlspecialchars($occurrence['occurrence_time']) ?></span>
    </div>

    <div class="detail">
      <label>Case File Number:</label>
      <span><?= htmlspecialchars($occurrence['case_file_number']) ?></span>
    </div>

    <div class="detail">
      <label>Nature of Occurrence:</label>
      <span><?= htmlspecialchars($occurrence['nature_of_occurrence']) ?></span>
    </div>

    <div class="detail">
      <label>Remarks:</label>
      <span><?= nl2br(htmlspecialchars($occurrence['remarks'])) ?></span>
    </div>

    <div class="actions">
      <a id="backButton" href="records.php">Back to Records</a>
      <button onclick="window.print()">Print</button>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const params = new URLSearchParams(window.location.search);
      const from = params.get("from");

      const backButton = document.getElementById("backButton");
      if (from === "admin") {
        backButton.href = "records.php";
      } else {
        backButton.href = "records.php";
      }
    });
  </script>
</body>
</html>
