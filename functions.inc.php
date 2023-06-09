<?php

function emptyInputSignUp($username, $pwd, $pwdRepeat) {
    $result;
    if (empty($username) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUid($username) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username) {
    $sql = "SELECT * FROM users WHERE usersName = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        mysqli_stmt_close($stmt);
        return $row;
    } else {
        mysqli_stmt_close($stmt);
        return false;
    }
}

function createUser($conn, $username, $pwd) {
    $sql = "INSERT INTO users (usersName, usersPwd, usersTime) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: signup.php?error=stmtfailed");
        exit();
    }
    $time = 0;
    mysqli_stmt_bind_param($stmt, "ssi", $username, $pwd, $time);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: index.php?error=none");
    exit();
}

function emptyInputLogIn($username, $pwd) {
    $result;
    if (empty($username) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username);

    if ($uidExists === false) {
        header("location: login.php?error=wronglogin");
        exit();
    }
    $pwdDB = $uidExists["usersPwd"];

    if ($pwdDB !== $pwd) {
        header("location: login.php?error=wronglogin");
        exit();
    } else if ($pwdDB === $pwd) {
        if ($uidExists["adminStat"] === 1) {
            header("location: adminpage.php");
            exit();
        } else {
            session_start();
            $_SESSION["usersid"] = $uidExists["usersId"];
            $_SESSION["usersname"] = $uidExists["usersName"];
            $_SESSION["userstime"] = $uidExists["usersTime"];
            header("location: timetrackerpage.php");
            exit();
        }
    }
}
