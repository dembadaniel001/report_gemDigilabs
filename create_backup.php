<?php
// === CONFIGURATION ===
// Database connection settings
$dbHost     = 'localhost';    // Database host
$dbUsername = 'root';         // Database username
$dbPassword = '';             // Database password (update if needed)
$dbName     = 'occurrence_book'; // Name of the database to back up
$backupDir  = 'backups/';     // Directory where backups will be stored (must exist)

// === TIMESTAMPED FILENAME ===
// Generate a filename with the current date and time for uniqueness
$date = date('Y_m_d_His');    // Format: Year_Month_Day_HourMinuteSecond
$backupFile = $backupDir . "backup_{$date}.sql"; // Full path to the backup file

// === EXECUTE BACKUP ===
// Build the mysqldump command to export the database
$command = "mysqldump --user={$dbUsername} --password={$dbPassword} --host={$dbHost} {$dbName} > {$backupFile}";

// For Windows, wrap the command in cmd /c and use double quotes
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $command = "cmd /c \"{$command}\"";
}

// Run the command and capture the output and result code
exec($command, $output, $result);

// === RESPONSE ===
// Check if the backup was successful
if ($result === 0) {
    // Success: Notify user and redirect
    echo "<script>alert('Backup created successfully as {$backupFile}'); window.location.href='backup_system.html';</script>";
} else {
    // Failure: Notify user and redirect
    echo "<script>alert('Backup failed! Make sure mysqldump is installed and backups folder is writable.'); window.location.href='backup_system.html';</script>";
}
?>
