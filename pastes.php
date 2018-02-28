<?php
session_start();
require_once("mysql.php");
$pid = $_GET["p_id"];
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT public, username, title, paste, created_at FROM pastes WHERE id = ?";
    if ($result = $link->prepare($sql)) {
        $result->bind_param("d", $temp_id);
        $temp_id = $pid;
        $result->execute();
        $result->store_result();
        if ($result->num_rows == 1) {
            $result->bind_result($public, $username, $title, $paste, $date);
            while ($result->fetch()) {
                if (($public == 1) || ($public == 0 && $username == $_SESSION["user"])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paste by @<?php echo htmlspecialchars($username); ?></title>
    <link href="https://fonts.googleapis.com/css?family=Lobster|Source+Sans+Pro:300,400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheet/welcome.css">
</head>
<body>
    <div class="makespace"></div>
    <div class="container">
        <div class="logo"><span>false</span>Pastebin</div>
        <h1><?php echo $title; ?></h1>
        <p class="paste-info">
            Paste submitted by <span>@<?php echo $username; ?></span><br>at <span><?php echo $date; ?></span>
        </p>
        <span class="paste">
            <?php echo $paste; ?>
        </span>
    </div>
</body>
</html>
<?php
                } else {
                    include("error404.php");
                }
            }
        } else {
            include("error404.php");
        }
        $result->close();
    }
    $link->close();
}
?>