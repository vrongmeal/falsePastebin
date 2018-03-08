<?php
session_start();
require_once("mysql.php");
$pid = $_GET["p_id"];
$action = $_GET["action"];
$access = $_GET["access"];
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT username FROM pastes WHERE id = ?";
    if ($result = $link->prepare($sql)) {
        $result->bind_param("d", $temp_id);
        $temp_id = $pid;
        $result->execute();
        $result->store_result();
        if ($result->num_rows == 1) {
            $result->bind_result($username);
            while ($result->fetch()) {
                if ($username == $_SESSION["user"]) {
                    if ($action == "delete") {
                        $q = "DELETE FROM pastes WHERE id = " . $pid;
                        $ans = $link->query($q);
                        header("location: index.php");
                    } elseif ($action == "toggle") {
                        if ($access == 1) {
                            $q = "UPDATE pastes SET public = 0 WHERE id = " . $pid;
                            $ans = $link->query($q);
                            header("location: index.php");
                        } elseif ($access == 0) {
                            $q = "UPDATE pastes SET public = 1 WHERE id = " . $pid;
                            $ans = $link->query($q);
                            header("location: index.php");
                        } else {
                            include("error404.php");
                        }
                    } else {
                        include("error404.php");
                    }
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