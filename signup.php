<?php
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo "<p>Fill in all fields!</p>";
    } else if ($_GET["error"] == "invaliduid") {
        echo "<p>Choose proper username!</p>";
    } else if ($_GET["error"] == "passwordsdontmatch") {
        echo "<p>Passwords do not match!</p>";
    } else if ($_GET["error"] == "usernametaken") {
        echo "<p>Username not available. Try again!</p>";
    } else if ($_GET["error"] == "stmtfailed") {
        echo "<p>Something went wrong, try again!</p>";
    } else if ($_GET["error"] == "none") {
        echo "<p>You have signed up!</p>";
    }
}
?>

<style>
<?php include 'style.css'; ?>
</style>

<section class="signup-form">
    <h2>Sign Up</h2>
    <div>
        <form action="signup-inc.php" method="post">
            <input type="text" name="uid" placeholder="Username...">
            <input type="password" name="pwd" placeholder="Password...">
            <input type="password" name="pwdrepeat" placeholder="Repeat Password...">
            <button type="submit" name="submit">Sign up</button>
        </form>
    </div>
</section>




