<?php
/*
+------------------------------------------------
|    embeded_js.php
|   =============================================
|    by Nitestryker
|   (c) 2013 Nitestryker Software
|   http://nitestryker.net
|   =============================================
|   git: https://github.com/nitestryker/phpbin.git
|   Licence Info: GPL
+------------------------------------------------
*/
error_reporting(E_ALL);

$rid = $_GET['rid'];
if ($rid == "") {
    redirect();
}
$rid = htmlspecialchars($rid);
$rid = trim(htmlspecialchars($rid, ENT_QUOTES, "utf-8"));

// make connection to database
require '../include/config.php';
$database_name = $database_name;
$connection = mysql_connect("$dbhost", "$dbusername", "$dbpasswd")
    or die ("Couldn't connect to server.");
$db = mysql_select_db("$database_name", $connection)
    or die("Couldn't select database.");

$sql = "SELECT * FROM public_post WHERE postid = $rid";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
    $post_text = $row['post_text'];

}
if ($post_text == "") {
    echo "Sorry &nbsp;<b>$rid</b> was not found, Please try again";
    exit();
}
include_once '../include/geshi.php';
$syntax = "text";
$geshi = new GeSHi($post_text, $syntax);
$embed = $geshi->parse_code();
mysql_close($connection);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title></title>
  </head>
 <body>
<p id="output"></p>
  <script language="JavaScript"> 
 var myvar = <?php echo json_encode($embed); ?>;
document.getElementById("output").innerHTML = myvar
</script>
  </body>
</html>