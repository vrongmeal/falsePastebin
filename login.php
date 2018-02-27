<?php
session_start();
require_once("mysql.php");
$err = $second_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"])) || empty(trim($_POST["password"]))) {
        $err = "Please enter valid credentials";
    } else {
        $sql = "SELECT id FROM users WHERE username = ? AND password = ?";
        if ($result = $link->prepare($sql)) {
            $result->bind_param("ss", $temp_username, $temp_password);
            $temp_username = trim($_POST["username"]);
            $temp_password = trim($_POST["password"]);
            if ($result->execute()) {
                $result->store_result();
                if ($result->num_rows != 1) {
                    $err = "You have entered either wrong username or password";
                } else {
                    $_SESSION["user"] = $_POST["username"];
                    header("location: index.php");
                }
            } else {
                echo "Error! Please try again later.";
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
    <title>Login: falsePastebin</title>
    <link href="https://fonts.googleapis.com/css?family=Lobster|Source+Sans+Pro:300,400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheet/welcome.css">
</head>
<body>
    <div class="makespace"></div>
    <?php
    if ($err) {
        echo '<div class="error">';
        echo '<p>' . $err . '</p>';
        echo '</div>';
    }
    ?>
    <div class="container">
        <div class="logo"><span>false</span>Pastebin</div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h1>Login</h1>
            <p class="row">
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </p>
            <p class="row">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </p>
            <p class="row"><input type="submit" value="Login"></p>
            <p class="link">New here? <a href="register.php">Create an account</a></p>
        </form>
    </div>
</body>
</html>