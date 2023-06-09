<?php
session_start();
$usersid = $_SESSION["usersid"];
$usersname = $_SESSION["usersname"];
$userstime = $_SESSION["userstime"];

require_once 'dbh.inc.php';

function trackTimeInSeconds($start_time) {
    $current_time = time();
    $elapsed_time = $current_time - $start_time;

    return $elapsed_time;
}

function getTotalElapsedTimeFromDatabase($username) {
    global $conn;

    $sql = "SELECT usersTime FROM users WHERE usersName = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $usersTime);

    $totalTime = 0;

    if (mysqli_stmt_fetch($stmt)) {
        $totalTime = $usersTime;
    }

    mysqli_stmt_close($stmt);

    return $totalTime;
}

if (isset($_POST["stop_tracking"])) {
    $start_time = $_POST["start_time"];

    $timeInSeconds = trackTimeInSeconds($start_time);

    $sql = "UPDATE users SET usersTime = usersTime + ? WHERE usersName = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $timeInSeconds, $usersname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if (isset($timeInSeconds)) {
    echo "Session total: " . formatTime($timeInSeconds) . " (HH:MM:SS)";
}

function formatTime($timeInSeconds) {
    $hours = floor($timeInSeconds / 3600);
    $minutes = floor(($timeInSeconds % 3600) / 60);
    $seconds = $timeInSeconds % 60;

    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}
?>

<form method="post" action="">
    <input type="hidden" name="start_time" value="<?php echo time(); ?>">
    <?php if (!isset($timeInSeconds) && !isset($formattedTime)) { ?>
        <button id="stop_button" type="submit" name="stop_tracking">Stop Tracking</button>
    <?php } ?>
</form>

<?php
if (isset($_POST["stop_tracking"]) && isset($timeInSeconds)) {
    $totalElapsedTime = getTotalElapsedTimeFromDatabase($usersname);
    $formattedTotalElapsedTime = formatTime($totalElapsedTime);
    echo "Total elapsed time: " . $formattedTotalElapsedTime . " (HH:MM:SS)";
    echo "<script>document.getElementById('stop_button').style.display = 'none';</script>";
    echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 7000);</script>";
}
?>
