<?php
session_start();
require_once("mysql.php");
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a valid username";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($result = $link->prepare($sql)) {
            $result->bind_param("s", $temp_username);
            $temp_username = trim($_POST["username"]);
            if ($result->execute()) {
                $result->store_result();
                if ($result->num_rows == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Error! Please try again later.";
            }
        }
        $result->close();
    }
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a valid password";
    } elseif (strlen($_POST["password"]) < 8) {
        $password_err = "Password must be atleast 8 characters";
    } else {
        $password = trim($_POST["password"]);
    }
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "";
    } else {
        $confirm_password = $_POST["confirm_password"];
        if ($confirm_password != $password) {
            $confirm_password_err = "Your passwords do not match, try again!";
        }
    }
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        if ($result = $link->prepare($sql)) {
            $result->bind_param("ss", $temp_username, $temp_password);
            $temp_username = $username;
            $temp_password = $password;
            if ($result->execute()) {
                $_SESSION["user"] = $username;
                header("location: index.php");
            } else {
                echo "Sorry, we couldn't sign you up, try again later!";
            }
        }
        $result->close();
    }
    $link->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - falsePastebin</title>
    <link href="https://fonts.googleapis.com/css?family=Lobster|Source+Sans+Pro:300,400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheet/welcome.css">
</head>
<body>
    <div class="makespace"></div>
    <?php
    if ($username_err || $password_err || $confirm_password_err) {
        echo '<div class="error">';
        if ($username_err) {
            echo '<p>' . $username_err . '</p>';
        }
        if ($password_err) {
            echo '<p>' . $password_err . '</p>';
        }
        if ($confirm_password_err) {
            echo '<p>' . $confirm_password_err . '</p>';
        }
        echo '</div>';
    }
    ?>
    <div class="container">
        <div class="logo"><span>false</span>Pastebin</div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <h1>Sign up</h1>
                <p class="row">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username">
                </p>
                <p class="row">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                </p>
                <p class="row">
                    <label for="confirm_password">Retype Password</label>
                    <input type="password" name="confirm_password" id="confirm_password">
                </p>
                <p class="row"><input type="submit" value="Create new account"></p>
                <p class="link">Have an existing account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>