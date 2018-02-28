<?php
session_start();
require_once("mysql.php");
$paste = "";
$paste_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["paste"]))) {
        $paste_err = "Don't leave it blank!";
    } else {
        $sql = "INSERT INTO pastes (username, public, title, paste) VALUES (?, ?, ?, ?)";
        if ($result = $link->prepare($sql)) {
            $result->bind_param("sdss", $temp_user, $temp_public, $temp_title, $temp_paste);
            $temp_user = $_SESSION["user"];
            $temp_public = $_POST["public"];
            if (empty($_POST["title"])) {
                $temp_title = "Untitled";
            } else {
                $temp_title = $_POST["title"];
            }
            $temp_paste = $_POST["paste"];
            if ($result->execute()) {
                header("location: index.php");
            } else {
                $paste_err = "Sorry, couldn't create your paste!";
            }
        }
        $result->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard @<?php echo htmlspecialchars($_SESSION["user"]); ?></title>
    <link rel="stylesheet" type="text/css" href="stylesheet/main.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="float_left"><a class="logo" href="index.php"><span>false</span>Pastebin</a></div>
            <div class="float_right dashboard">
                <?php echo htmlspecialchars($_SESSION["user"]); ?>'s <span>Dashboard</span>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
    <div class="makespace"></div>
    <div class="content">
        <?php
        if ($paste_err) {
            echo '<div class="error">';
            echo "<p>" . $paste_err . "</p>";
            echo "</div>";
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>New Paste</h1>
            <p class="row">
                <label for="title">Paste title</label>
                <input type="text" name="title" id="title" placeholder="Untitled">
            </p>
            <textarea name="paste" wordwrap placeholder="Write your paste here"></textarea>
            <div class="row">
                <p class="option"><label class="opt"><input type="radio" name="public" value="1" checked> Public</label>
                <label class="opt"><input type="radio" name="public" value="0"> Private</label></p>
                <p class="button"><input type="Submit" value="Paste it"></p>
            </div>
        </form>
        <div class="box">
            <h1>My pastes</h1>
            <ul>
                <?php
                $q = "SELECT id, title, created_at, public FROM pastes WHERE username = ?";
                if ($ans = $link->prepare($q)) {
                    $ans->bind_param("s", $temp_username);
                    $temp_username = $_SESSION["user"];
                    $ans->execute();
                    $ans->store_result();
                    if($ans->num_rows > 0) {
                        $ans->bind_result($view_id, $view_title, $view_date, $view_public);
                        echo "<ul>";
                        while ($ans->fetch()) {
                            if ($view_public == 1) {
                                $public = "Public";
                                $not_public = "Private";
                            } else {
                                $public = "Private";
                                $not_public = "Public";
                            }
                            echo "<li>";
                            echo "<h2>" . $view_title . "</h2>";
                            echo "<p>Created at " . $view_date . " (" . $public . ")</p>";
                            echo '<a href="pastes.php?p_id=' . $view_id . '">View Paste</a> / <a href="action.php?p_id=' . $view_id . '&action=toggle&access=' . $view_public . '">' . $not_public . '</a> / <a href="action.php?p_id=' . $view_id . '&action=delete">Delete</a></p>';
                            echo "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo '<h2 class="no-posts">No pastes to show, go ahead and create one </h2>';
                    }
                    $ans->close();
                }
                $link->close();
                ?>
            </ul>
        </div>
    </div>
</body>
</html>