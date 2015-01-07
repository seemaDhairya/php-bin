<?php
/**
 * profile.php
 *
 * @package PHP-Bin
 * @author Jeremy Stevens
 * @copyright 2014-2015 Jeremy Stevens
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @version 1.0.8
*/
error_reporting(0);
// start session
session_start();

$proid = $_GET['usr'];

// edit profile
    $action = (isset($_GET['action'])) ? $_GET['action'] : "null";
if ($action == "edit") {

    // verify that the logged in user is the same as the profile user
    $verify = $_SESSION['verify'];
    if ($verify === $proid) {
        $dtest = "works";
        header("refresh:0; url=edit/$proid");
    }else {

        // if not verified redirect
        header("refresh:0; url=$proid");
    }
}


// include need files
include_once '../include/config.php';
include '../classes/profile.class.php';
// make connection to database
$connection = mysql_connect("$dbhost", "$dbusername", "$dbpasswd")
    or die ("Couldn't connect to server.");
$db = mysql_select_db("$database_name", $connection)
    or die("Couldn't select database.");

// new instance
$profile = new profile($proid);

// variables from class
$profieid = $profile->profileid;
$r2 = $profile->profileid;
$username = $profile->username;
$email = $profile->email;
$website = $profile->website;
$location = $profile->location;
$avatar = $profile->avatar;
$jdate = $profile->jdate;

// get the total hit count for the user
$connection = mysql_connect("$dbhost", "$dbusername", "$dbpasswd")
or die ("Couldn't connect to server.");
$db = mysql_select_db("$database_name", $connection)
or die("Couldn't select database.");
$result = mysql_query("SELECT SUM(post_hits) AS value_sum FROM userp_$profieid", $connection);
$row = mysql_fetch_assoc($result);
$sum = $row['value_sum'];
$thits = $sum;

// convert join date
$join_date = date('F j, Y', strtotime($jdate));

// if userid is not found do this
if (empty($profieid)) {
    include 'error.php';
    exit();
}
// dev test
$verify = $_SESSION['verify'];
if ($verify == $username) {
    $dev = true;
} else
    $dev = false;
if ($dev == 1) {
    $edit = "<a href='$proid&action=edit'>edit profile</a>";
}
// if location is null show N/A
if ($location == "") {
    $location = "N/A";
} else {
    $location = $location;
}
// if website is blank show N/A
if ($website == "") {
    $website = "N/A";
} else {

    $website = "<a href='$website'>$website</a>";
}

// if  total hit count is null then display 0
if (empty($thits)) {
    $thits = "0";
} else {
    $thits = $thits;
}

//test 2
$connection = mysql_connect("$dbhost", "$dbusername", "$dbpasswd")
    or die ("Couldn't connect to server.");
$db = mysql_select_db("$database_name", $connection)
    or die("Couldn't select database.");

$result = mysql_query("SELECT * FROM userp_$profieid", $connection);
$num_rows = mysql_num_rows($result);
include '../templates/profile.tpl.php';
?>