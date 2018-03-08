<?php
require "mysql.php";
$current = strtotime("+330 minutes" ,time());
$sql = "SELECT id, created_at FROM pastes";
$q = $link->prepare($sql);
$q->execute();
$q->bind_result($id, $time);
while ($q->fetch()) {
    $time_stamp = strtotime($time);
    $expire = strtotime($time . "+3 days");
    if ($expire <= $current) {
        require "mysql.php";
        $qry = "DELETE FROM pastes WHERE id = ?";
        $ans = $link->prepare($qry);
        $ans->bind_param("d", $id);
        $ans->execute();
    }
}
?>