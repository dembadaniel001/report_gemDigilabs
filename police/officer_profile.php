<?php
// officer_profile.php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Access denied. Please log in.";
    exit;
}

$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT fullname, badge_number, id_number, rank, email, phone FROM users WHERE id = ?");
$stmt->execute([$userId]);
$officer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$officer) {
    echo "Officer not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Officer Profile</title>
  <style>
    :root {
      --police-blue: #003366;
      --police-gold: #ffd700;
      --success: #d4edda;
      --error: #f8d7da;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      margin: 0;
      padding: 0;
    }

    .nav-bar {
      background: var(--police-blue);
      color: white;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
    }

    .nav-links {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
    }

    .nav-links a {
      color: white;
      text-decoration: none;
    }

    .hamburger {
      display: none;
      font-size: 24px;
      background: none;
      border: none;
      color: white;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      .nav-links {
        display: none;
        flex-direction: column;
        background: var(--police-blue);
        position: absolute;
        top: 60px;
        left: 0;
        width: 100%;
        padding: 10px 15px;
        box-sizing: border-box;
        z-index: 10;
      }

      .nav-links a {
        padding: 8px 0;
        display: block;
      }

      .nav-links.active {
        display: flex;
      }

      .hamburger {
        display: block;
      }
    }

    .container {
      max-width: 600px;
      margin: 40px auto;
      background: #fff;
      padding: 25px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: var(--police-blue);
      margin-bottom: 20px;
    }

    .alert {
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
      font-weight: bold;
    }

    .success {
      background-color: var(--success);
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .error {
      background-color: var(--error);
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    form label {
      display: block;
      margin: 12px 0 6px;
      font-weight: bold;
    }

    form input[type="text"],
    form input[type="email"],
    form input[type="tel"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
      margin-bottom: 10px;
      box-sizing: border-box;
    }

    form input[disabled] {
      background-color: #e9ecef;
    }

    .submit-btn {
      width: 100%;
      padding: 12px;
      background: var(--police-blue);
      color: white;
      border: none;
      border-radius: 3px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 15px;
    }

    .submit-btn:hover {
      background-color: #002244;
    }
  </style>
</head>
<body>

  <!-- Navigation -->
  <nav class="nav-bar">
    <button class="hamburger" onclick="toggleMenu()">☰</button>
    <div class="nav-links" id="navLinks">
      <a href="officer_dashboard.html">Dashboard</a>
      <a href="new_occurrence_entry.html">New Occurrence</a>
      <a href="records.php">Records</a>
      <a href="officer_profile.php">Profile</a>
      <a href="logout.php">Logout</a>
    </div>
  </nav>

  <!-- Profile Container -->
  <div class="container">
    <h2>Officer Profile</h2>

    <?php if (isset($_GET['success'])): ?>
      <div class="alert success">Profile updated successfully.</div>
    <?php elseif (isset($_GET['error'])): ?>
      <div class="alert error">Error: <?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <form method="POST" action="update_profile.php">
      <label for="fullname">Full Name</label>
      <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($officer['fullname']); ?>" disabled>

      <label for="badgeNumber">Badge Number</label>
      <input type="text" id="badgeNumber" name="badgeNumber" value="<?php echo htmlspecialchars($officer['badge_number']); ?>" disabled>

      <label for="idNumber">National ID Number</label>
      <input type="text" id="idNumber" name="idNumber" value="<?php echo htmlspecialchars($officer['id_number']); ?>" disabled>

      <label for="rank">Rank</label>
      <input type="text" id="rank" name="rank" value="<?php echo htmlspecialchars($officer['rank']); ?>" disabled>

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($officer['email']); ?>" required>

      <label for="phone">Phone Number</label>
      <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($officer['phone']); ?>" required>

      <button type="submit" class="submit-btn">Update Profile</button>
    </form>
  </div>

  <script>
    function toggleMenu() {
      document.getElementById("navLinks").classList.toggle("active");
    }
  </script>
</body>
</html>
