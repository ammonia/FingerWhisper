<?php
session_start();

$tips = '';
if(!isset($_SESSION['peopleid']) || $_SESSION['peopleid'] == '') {
    header('Location: index.php');
    die();
}

$con = mysql_connect('localhost', 'root', '');
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("fingerwhisper",$con);
mysql_query("set names utf8");
   
$roomid = $_SESSION['roomid'];
$roomname = $_SESSION['roomname'];
$sql = "select count(*) as cc from circle where roomid = $roomid;";
$ccresult = mysql_query($sql);
$ccinfo = mysql_fetch_array($ccresult);
$cc = $ccinfo['cc'];

$preid = $_SESSION['preid'];
$talksql = '';
$prename = 'No one';
$nextname = 'No one';
if($preid != 0) {
    $presql = mysql_query("select name from people where id = $preid;");
    $preinfo = mysql_fetch_array($presql);
    $prename = $preinfo['name'];

    $nextid = $_SESSION['nextid'];
    $nextsql = mysql_query("select name from people where id = $nextid;");
    $nextinfo = mysql_fetch_array($nextsql);
    $nextname = $nextinfo['name'];

    $sql = "select * from talk where roomid = $roomid and ( peopleid = $preid or state <> 0) order by phptime desc limit 10;";
    $talksql = mysql_query($sql);
}

// insert words
if(isset($_POST['words']) && trim($_POST['words']) != '') {
    $words = htmlspecialchars($_POST['words']);
    if(strlen($words) > 210) {
        $tips = 'Letters should not be more than 210.';
    }
    else {
        $roomid = $_SESSION['roomid'];
        $peopleid = $_SESSION['peopleid'];
        $sql = "insert ";
        $time = time();
        $sql = "insert into talk (roomid, peopleid, words, state, phptime) values ($roomid,$peopleid,'$words',0,$time);";
        mysql_query($sql);
    }
}
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 <meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1"/>
 <title>Finger Whisper</title>
<style type="text/css">
 body{font-family:Consolas,Arial,"宋体";font-size:16px;background:#fff;color:#333;padding:0;margin:0;border:4px solid #fff;max-width:100%;}
 .title{background:#069;color:#fff;border:4px solid #069;}
 input{font-family:Consolas,Arial;font-size:16px;}
 a{font-size:16px;color:#fff;text-decoration:none;}
 #listen{min-height:20px;}
 .words{font:normal normal 20px Times New Roman,宋体;color:#000;padding:6px;}
 .people, .time{font-family:Consolas;font-size:12px;color:#666;}
 td.btd{background:#069;color:#fff;text-align:center;width:100px;}
</style>
</head><body>

<div class="title">
<a href="room.php">See <?php echo $cc; ?> People in <?php echo $roomname; ?></a></div>
<div id="say">
<form name="logform" action="talk.php" method="post">
<span class="people">To <?php echo $nextname; ?>:</span>
<div><textarea rows="2" cols="33" name="words" id="words" style="width:98%" maxlength="210">
<?php echo $tips; ?>
</textarea></div>
<div style="text-align:right;margin:2px;"><input type="submit" name="submit" value=" Say "/></div>
</form>
</div>

<div id="listen">
<span class="people">From <?php echo $prename; ?>:</span>
<?php
if($talksql == '') {
    echo '<div class="words">'.$prename.' said nothing.</div>';
}
else {
    $t = time();
    while($talkinfo = mysql_fetch_array($talksql)) {
        echo '<div class="words">'.$talkinfo['words'].'<span class="time"> --';
        $t = time() - $talkinfo['phptime'];
        if($t < 60) {
            echo $t.' sec ago.</span></div>';
        }
        else if($t < 3600) {
            echo intval($t/60).' min ago.</span></div>';
        }
        else {
            echo intval($t/3600).' h ago.</span></div>';
        }
    }
}

mysql_close($con);
?>
</div>

<div>
<table border=0 width=100%><tr>
<td class="btd"><a href="leave.php">Leave</a></td>
<td style="color:#069;background:#eee;font-size:12px;text-align:center;">
	Email me at quhuix@gmail.com
</td>
<td style="display:none;"><a href="settings.php">Settings</a></td>
</tr></table>
</div>
</body></html>
