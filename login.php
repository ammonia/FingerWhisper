<?php
session_start();

if(isset($_SESSION['peopleid']) && $_SESSION['peopleid'] != '') {
    header('Location: talk.php');
    die();
}

// Wanna login
if(isset($_POST['room']) && $_POST['room'] != '') {
    $con = mysql_connect('localhost', 'root', '');
    if (!$con) {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("fingerwhisper",$con);
    mysql_query("set names utf8");

    // Check whether room already exist
    $room = str_replace(' ','',$_POST['room']);
    $_SESSION['roomname'] = $room;
    $sql = "select * from room where name = '$room' ;";
    $roomsql = mysql_query($sql);
    $roomnum = mysql_num_rows($roomsql);
    if($roomnum==0) {
        // Room not exist, create one.
        $insert_sql = "insert into room (name) values ('$room');";
        $insert_room = mysql_query($insert_sql);
        $_SESSION['roomid'] = intval(mysql_insert_id());
    }
    else {
        $roominfo = mysql_fetch_array($roomsql);
        $_SESSION['roomid'] = intval($roominfo['id']);
    }

    // Check whether input a name (Anonymous is illegal)
    $peoplename = str_replace(' ','',$_POST['people']);
    if($peoplename != '' && $peoplename != 'Anonymous') {
        $_SESSION['peoplename'] = $peoplename;
        $pass = md5($_POST['pass']);
        $sql = "select * from people where name = '$peoplename' ;";
        $peoplesql = mysql_query($sql);
        $peoplenum = mysql_num_rows($peoplesql);

        // if name exist, check password; if not, create one.
        if($peoplenum==0) {
            $insert_sql = "insert into people (name,password) values ('$peoplename','$pass');";
            $insert_people = mysql_query($insert_sql);
            $_SESSION['peopleid'] = mysql_insert_id();
        }
        else {
            $peopleinfo = mysql_fetch_array($peoplesql);
            if($pass == $peopleinfo['password']) {
                $_SESSION['peopleid'] = $peopleinfo['id'];
            }
            else {
                mysql_close($con);
                header('Location: index.php?message=Wrong-Password.');
                die();
            }
        }
    }
    else {  // did not input a name, use Anonymous for him
        $peoplename = 'Anonymous';
        $insert_sql = "insert into people values ();";
        $insert_people = mysql_query($insert_sql);
        $_SESSION['peopleid'] = mysql_insert_id();
        $_SESSION['peoplename'] = 'Anonymous';
    }

    // find a place randomly in the room and let him join the circle
    $roomid = $_SESSION['roomid'];
    $peopleid = $_SESSION['peopleid'];

    $sql = "select * from circle where roomid = $roomid;";
    $circlesql = mysql_query($sql);
    $circlenum = mysql_num_rows($circlesql);
    if($circlenum == 0) {
        $sql = "insert into circle (roomid, peopleid, pre, next) values ($roomid,$peopleid,0,0);";
        $_SESSION['preid'] = 0;
        $_SESSION['nextid'] = 0;
    }
    else if($circlenum == 1) {
        $circleinfo = mysql_fetch_array($circlesql);
        $updateid = $circleinfo['id'];
        mysql_query("update circle set pre = $peopleid, next = $peopleid where id = $updateid limit 1;");
        $nextid = $circleinfo['peopleid'];
        $sql = "insert into circle (roomid, peopleid, pre, next) values ($roomid,$peopleid,$nextid,$nextid);";
        $_SESSION['preid'] = $nextid;
        $_SESSION['nextid'] = $nextid;
    }
    else {
        $randp = rand(0, $circlenum);
        $circleinfo = mysql_fetch_array($circlesql);
        for($i = 0 ; $i < $randp ; $i++) {
            $circleinfo = mysql_fetch_array($circlesql);
        }
        $circleid = $circleinfo['id'];
        $preid = $circleinfo['peopleid'];
        $nextid = $circleinfo['next'];
        mysql_query("update circle set next = $peopleid where id = $circleid limit 1;");
        mysql_query("update circle set pre = $peopleid where peopleid = $nextid and roomid = $roomid limit 1;");
        $sql = "insert into circle (roomid, peopleid, pre, next) values ($roomid,$peopleid,$preid,$nextid);";
        $_SESSION['preid'] = $preid;
        $_SESSION['nextid'] = $nextid;
    }
    mysql_query($sql);

    // publish a note that a new person join in
    $words = $peoplename.' join in.';
    $time = time();
    $sql = "insert into talk (roomid, peopleid, words, state, phptime) values ($roomid,$peopleid,'$words',1,$time);";
    mysql_query($sql);

    mysql_close($con);
    header('Location: talk.php');
}
else {
    header('Location: index.php');
}

?>
