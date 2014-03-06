<?php
session_start();

$con = mysql_connect('localhost', 'root', '');
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("fingerwhisper",$con);
mysql_query("set names utf8");

$roomid = $_SESSION['roomid'];
$peopleid = $_SESSION['peopleid'];
$preid = 0;
$nextid = 0;
if($preid != $peopleid) {
    $nextid = $_SESSION['nextid'];
    $preid = $_SESSION['preid'];
}

// update circle
$sql = "delete from circle where roomid =$roomid and peopleid = $peopleid limit 1;";
mysql_query($sql);
$sql = "update circle set next=$nextid where roomid =$roomid and peopleid = $preid limit 1;";
mysql_query($sql);
$sql = "update circle set pre=$preid where roomid =$roomid and peopleid = $nextid limit 1;";
mysql_query($sql);

// publish a note that a new person join in
$words = $_SESSION['peoplename'].' left.';
$time = time();
$sql = "insert into talk (roomid, peopleid, words, state, phptime) values ($roomid,$peopleid,'$words',-1,$time);";
mysql_query($sql);

mysql_close($con);
session_destroy();

header("Location: index.php");
?>
