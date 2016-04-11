<?php 
	require_once 'appinclude.php';
	require_once 'mystyle.php';

echo '<div align="center"><img src="'.$appcallbackurl.'main.png" width="300" height="150"></div>';

	require_once 'ads/topads.php';
?>

<fb:tabs>
  <fb:tab-item href='<? echo $appCanvasUrl; ?>' title='Raffle' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>earn.php' title='Get Tickets' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>payment.php' title='Payment Info' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>history.php' title='Raffle History' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>forum.php' title='Forum' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>invite.php' title='Invite Friends' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>admin.php' title='Admin' />
</fb:tabs>

<div align="center">
<?
$fbid = $facebook->require_login();
$theirip = $_SERVER['REMOTE_ADDR'];


if ($fbid == "")
{
?>
<fb:error message="We cannot determine your Facebook User ID. This is necessary for this app to function. Try refreshing this page. (it happens from time to time)" />
<?
die("&nbsp;");
} else {
// nothing
}

?>

<?
$count = mysql_num_rows(mysql_query("SELECT id FROM main WHERE fbuser='$fbid' LIMIT 1"));

if ($count == "1")
{
// user exists
} else {
// new user, welcome, insert
mysql_query("INSERT INTO main (fbuser, theip) VALUES ('$fbid', '$theirip')");
?>
<script type="text/javascript">
<!--

showDialog('Welcome to the Raffle! To enter the raffle (with REAL CASH PRIZES), you need tickets! Earn your tickets, then enter them in the raffles you choose! Good luck!');

function showDialog(dlgStr){
    var myDialog = new Dialog(Dialog.DIALOG_POP);
    myDialog.oncancel = handleCancel;
    myDialog.showMessage('Aloha!', dlgStr, button_confirm='Cancel');
    return false;
}


function handleCancel(evt){
    return true;
}

//-->
</script>
<br>
<fb:success message="You have successfully been registered with our network!" /><br>
<?
}
?>

<?
if ($fbid == $adminid)
{
// continue
} else {
die("<br><br><font size='4'>Access Denied<br><br><a href='index.php'>home</a></font><br><br><br>");
}
?>
<br>

<?php
include("global.inc.php");
$errors=0;
$error="The following errors occured while processing your form input.<ul>";
$message = $_POST['message'];
$small = $_POST['small'];
$to = $_POST['to'];
$healthy = array("%", "!", "=", "'", ",", "?", "<", "&", ";");
$yummy   = array("", "", "", "", "" ,"\?", "", "", "");

$Paypal = str_replace($healthy, $yummy, $message);
$checksent = str_replace($healthy, $yummy, $small);
$tooo = str_replace($healthy, $yummy, $to);


$dount = mysql_num_rows(mysql_query("SELECT id FROM main WHERE msgsmall='$checksent' AND id='$tooo' LIMIT 1"));

if ($dount == "1")
{
die("<br><br><font size='4'>Message already sent<br><br><a href='admin.php'>admin home</a><br><br><br></font>");
} else {
mysql_query("UPDATE main SET msgsmall='$checksent' WHERE id='$tooo'") 
or die(mysql_error());  
}



if($tooo=="" ){
die("<b><font size='4'><br><br>Invalid parameters<br><br><a href='admin.php'>Admin home</a></font></b><br>");
} else {
// continue
}
if($Paypal=="" ){
$errors=1;
$error.="<li>You did not enter a message. <a href='admin.php'>Admin Home</a><br><br>";
}
if($errors==1) echo $error;
else{
$where_form_is="http".($HTTP_SERVER_VARS["HTTPS"]=="on"?"s":"")."://".$SERVER_NAME.strrev(strstr(strrev($PHP_SELF),"/"));
$message="Paypal: ".$Paypal."
";

mysql_query("UPDATE main SET msgstat='1' WHERE id='$tooo'") 
or die(mysql_error());  

mysql_query("UPDATE main SET themsg='$Paypal' WHERE id='$tooo'") 
or die(mysql_error());  
?>
<br>
<fb:success message="Message Sent!" /><br><br>

<a href='admin.php'><font size='4'>Admin home</a></font>


<?php 
}
?>




<div class=mainBox>

</div>
</div>

<div class=whiteBox>
<?php require_once 'ads/bottomads.php'; ?>

</div>

</div>

