<?php
session_start();

if(isset($_SESSION['peopleid']) && $_SESSION['peopleid'] != '') {
    header('Location: talk.php');
}
?>

<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 <meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1"/>
 <title>Finger Whisper Login</title>
<style type="text/css">
 body{font-family:Consolas,Arial;font-size:16px;background:#fff;color:#000; padding:0; margin:0; border:4px solid #fff;}
 .title{padding:0; margin:0;border:0;text-align:center;}
 .logt{font-family:Consolas,Arial;font-size:20px;color:#333;}
 td{text-align:right;}
</style>
</head><body>
<div class="title">
  <div style="font:italic bold 36px Arial;color:#069;">Finger Whisper</div>
  <div style="text-align:right">-- Wisdom on Palm --</div>
  <div style="text-align:left">--&gt; <?php echo $_GET['message']; ?> </div>
<form name="logform" action="login.php" method="post">
<table align=center>
<tr><td><span class="logt"> Room </span></td><td><input type="text" value="Eden289" class="logt" name="room" id="room" size=16 /></td></tr>
<tr><td><span class="logt"> Name </span></td><td><input type="text" class="logt" name="people" id="people" size=16 /></td></tr>
<tr><td><span class="logt"> Password </span></td><td><input type="text" class="logt" name="pass" id="pass" size=16 /></td></tr>
<tr><td> </td><td><input type="submit" class="logt" value="Join Us" /></td></tr>
</table>
</form>
</div>
---
<div style="font:normal normal 12px Arial;color:#666;">
People talking without speaking<br>
People hearing without listening<br>
People writing songs that voices never share<br>
And no one dare<br>
Disturb the sound of silence<br>
...<br>
The words of the prophets<br>
Are written on the subway walls and tenement halls<br>
And whispered in the sounds of silence<br>
<t> -- The Sound of Silence</t>
</div>
</body></html>
