<?php
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo "<p>Fill in all fields!</p>";
    } else if ($_GET["error"] == "wronglogin") {
        echo "<p>Incorrect login information!</p>";
    }
}
?>

<style>
<?php include 'style.css'; ?>
</style>

<section class="signup-form">
    <h2>Log In</h2>
    <div>
        <form action="login-inc.php" method="post">
            <input type="text" name="uid" placeholder="Username...">
            <input type="password" name="pwd" placeholder="Password...">
            <button type="submit" name="submit">LogIn</button>
        </form>
    </div>
</section>


