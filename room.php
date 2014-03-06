<?php
session_start();

    $con = mysql_connect('localhost', 'root', '');
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("fingerwhisper",$con);
    mysql_query("set names utf8");

    $roomid = $_SESSION['roomid'];
    $roomname = $_SESSION['roomname'];

    $sql = "select  people.id, people.name, pre, next from people,circle where roomid = $roomid and people.id = circle.peopleid;";
    $circlesql = mysql_query($sql);
    $circlenum = mysql_num_rows($circlesql);

    $id2name = Array();
    $id2next = Array();
    $startid = 0;
    while($circleinfo = mysql_fetch_array($circlesql)) {
        $startid = $circleinfo['id'];
        $id2name[$circleinfo['id']] = $circleinfo['name'];
        $id2next[$circleinfo['id']] = $circleinfo['next'];
    }

mysql_close($con);

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
 td.chosen{background:#eee;color:#069;}
 a{font-size:16px;background:#eee;color:#069;text-decoration:none;}
</style>
</head><body>

<div class="title">
<?php echo $circlenum; ?> People in <?php echo $roomname; ?>
</div>

<div>
<table border="0" width="100%">
<tr>
  <td rowspan="<?php echo $circlenum; ?>" style="width:40px;text-align:center;vertical-align:top;">
  ↓<br />↓<br />↓
</td>
<?php

for($i=0;$i < $circlenum;$i++) {
    echo '<td';
    if($startid == $_SESSION['peopleid']) {
        echo ' class="chosen"';
    }
    echo "> $id2name[$startid] </td></tr>\n<tr>";
    $startid = $id2next[$startid];
}
?>
<td colspan="2"><a href="talk.php">BACK</a></td>
</tr>
</table>
</div>
</body></html>
