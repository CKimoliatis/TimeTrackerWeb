
<!DOCTYPE html>
<html>
    <head>
        <title>Admin Page</title>
        <link rel="stylesheet" href="adminstyle.css">
    </head>
    <body>
        <?php
        require_once 'dbh.inc.php';

        $users = [];

        $query = "SELECT * FROM users";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }

        if (isset($_POST['logout'])) {
            session_destroy();
            header("location: index.php");
            exit();
        }

        if (isset($_POST['update'])) {
            $passwords = $_POST['password'];
            $admin = $_POST['admin'];

            foreach ($passwords as $userID => $password) {
                $sql = "UPDATE users SET usersPwd = ? WHERE usersId = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "si", $password, $userID);
                $success = mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }

            foreach ($admin as $userID => $adminStatus) {
                $sql = "UPDATE users SET adminStat = ? WHERE usersId = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ii", $adminStatus, $userID);
                $success = mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }

            if ($success) {
                $message = "Update successful.";
            } else {
                $message = "Update failed. Error: " . mysqli_error($conn);
            }

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        
        ?>

        <div>
            <?php if (isset($message)) echo $message; ?>
        </div>

        <form method="post" action="">
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Elapsed Time</th>
                        <th>Admin Status</th>
                        <th>Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <input type="text" name="name[]" value="<?php echo $user['usersName']; ?>" disabled>
                                <input type="hidden" name="userID[]" value="<?php echo $user['usersId']; ?>">
                            </td>
                            <td>
                                <input type="text" name="password[<?php echo $user['usersId']; ?>]" value="<?php echo $user['usersPwd']; ?>">
                            </td>
                            <td>
                                <input type="text" name="time[]" value="<?php echo $user['usersTime']; ?>" disabled>
                            </td>
                            <td>
                                <select name="admin[<?php echo $user['usersId']; ?>]">
                                    <option value="0" <?php if ($user['adminStat'] == 0) echo 'selected'; ?>>False</option>
                                    <option value="1" <?php if ($user['adminStat'] == 1) echo 'selected'; ?>>True</option>
                                </select>
                            </td>
                            <td>
                                <button type="submit" name="update">Update</button>
                            </td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <button id="logout" type="submit" name="logout">Log out</button>
        </form>
    </body>
</html>