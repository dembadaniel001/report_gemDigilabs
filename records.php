<?php
// Include the database connection file
require_once 'db.php';

// Get the search query from the GET request, or set to empty string if not provided
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Set the default order for records (most recent first)
$orderBy = "ORDER BY created_at DESC";

// If a search query is provided, prepare a statement to search by OB number, date, or nature
if ($search) {
  $stmt = $pdo->prepare("
    SELECT id, ob_number, occurrence_date, occurrence_time, nature_of_occurrence
    FROM occurrences
    WHERE ob_number LIKE ? OR occurrence_date LIKE ? OR nature_of_occurrence LIKE ?
    $orderBy
  ");
  $like = "%$search%";
  $stmt->execute([$like, $like, $like]);
} else {
  // If no search, select all records ordered by creation time
  $stmt = $pdo->query("
    SELECT id, ob_number, occurrence_date, occurrence_time, nature_of_occurrence
    FROM occurrences
    $orderBy
  ");
}

// Fetch all records as an associative array
$records = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Occurrence Records</title>
  <style>
  /* CSS Variables for police theme colors */
  :root {
    --police-blue: #003366;
    --police-red: #d7261e;
    --police-gold: #ffd700;
  }

  body {
    font-family: Arial, sans-serif;
    background: #f2f2f2;
    margin: 0;
    padding: 0;
  }

  /* Navigation bar styles */
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

  /* Hamburger menu for mobile */
  .hamburger {
    display: none;
    font-size: 24px;
    background: none;
    border: none;
    color: white;
    cursor: pointer;
  }

  /* Responsive navigation for mobile */
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

  /* Main container styles */
  .container {
    max-width: 1000px;
    margin: 40px auto;
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }

  h2 {
    text-align: center;
    color: var(--police-blue);
    margin-bottom: 20px;
  }

  /* Search bar styles */
  .search-bar {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
  }

  .search-bar input[type="text"] {
    width: 60%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 3px 0 0 3px;
    outline: none;
  }

  .search-bar button {
    padding: 8px 16px;
    border: 1px solid var(--police-blue);
    background: var(--police-blue);
    color: #fff;
    border-radius: 0 3px 3px 0;
    cursor: pointer;
  }

  .search-bar button:hover {
    background: #002244;
    border-color: #002244;
  }

  /* Table styles */
  table {
    width: 100%;
    border-collapse: collapse;
  }

  thead {
    background: var(--police-blue);
    color: #fff;
  }

  th, td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
  }

  tr:nth-child(even) {
    background: #f9f9f9;
  }

  /* Make table rows clickable */
  tr.clickable-row {
    cursor: pointer;
  }

  tr.clickable-row:hover {
    background-color: #e0f0ff;
  }

  /* Responsive adjustments for small screens */
  @media (max-width: 600px) {
    .search-bar {
    flex-direction: column;
    align-items: center;
    }

    .search-bar input[type="text"] {
    width: 100%;
    margin-bottom: 10px;
    border-radius: 3px;
    }

    .search-bar button {
    width: 100%;
    border-radius: 3px;
    }

    th:last-child,
    td:last-child {
    display: none;
    }
  }
  </style>
</head>
<body>

  <!-- Officer Navigation Bar -->
  <nav class="nav-bar">
  <!-- Hamburger menu for mobile -->
  <button class="hamburger" onclick="toggleMenu()">☰</button>
  <div class="nav-links" id="navLinks">
    <a href="officer_dashboard.html">Dashboard</a>
    <a href="new_occurrence_entry.html">New Occurrence</a>
    <a href="records.php">Records</a>
    <a href="officer_profile.php">Profile</a>
    <a href="logout.php">Logout</a>
  </div>
  </nav>

  <div class="container">
  <h2>Occurrence Records</h2>

  <!-- Search form -->
  <form class="search-bar" method="GET" action="records.php">
    <input type="text" name="search" placeholder="Search by OB Number, Date, or Nature..." value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit">Search</button>
  </form>

  <!-- Occurrence records table -->
  <table>
    <thead>
    <tr>
      <th>OB Number</th>
      <th>Date</th>
      <th>Time</th>
      <th>Nature of Occurrence</th>
      <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($records): ?>
      <?php foreach ($records as $row): ?>
      <!-- Each row is clickable and links to the occurrence detail page -->
      <tr class="clickable-row" data-url="occurrence_detail.php?ob_number=<?php echo urlencode($row['ob_number']); ?>">
        <td><?php echo htmlspecialchars($row['ob_number']); ?></td>
        <td><?php echo htmlspecialchars($row['occurrence_date']); ?></td>
        <td><?php echo htmlspecialchars($row['occurrence_time']); ?></td>
        <td><?php echo htmlspecialchars($row['nature_of_occurrence']); ?></td>
        <td><a href="occurrence_detail.php?ob_number=<?php echo urlencode($row['ob_number']); ?>">View Details</a></td>
      </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <!-- Show message if no records found -->
      <tr><td colspan="5">No records found.</td></tr>
    <?php endif; ?>
    </tbody>
  </table>
  </div>

  <script>
  // Toggle navigation menu on mobile
  function toggleMenu() {
    const navLinks = document.getElementById('navLinks');
    navLinks.classList.toggle('active');
  }

  // Make table rows clickable (navigate to detail page)
  document.querySelectorAll('.clickable-row').forEach(row => {
    row.addEventListener('click', () => {
    window.location.href = row.getAttribute('data-url');
    });
  });
  </script>
</body>
</html>
