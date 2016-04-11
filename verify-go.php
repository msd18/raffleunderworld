<?php 
	require_once 'appinclude.php';
	require_once 'mystyle.php';

echo '<div align="center"><img src="'.$appcallbackurl.'main.png" width="300" height="150"></div>';

	require_once 'ads/topads.php';
?>

<fb:tabs>
  <fb:tab-item href='<? echo $appCanvasUrl; ?>' title='Raffle' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>earn.php' title='Get Tickets' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>payment.php' title='Payment Info' selected='true' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>history.php' title='Raffle History' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>forum.php' title='Forum' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>invite.php' title='Invite Friends' />
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

$mesult = mysql_query("SELECT * FROM main WHERE fbuser='$fbid'") 
or die(mysql_error());  

while($tow = mysql_fetch_array( $mesult )) {

$vercode = $tow['vercode'];
$isverr = $tow['isverified'];
}
if ($isverr == "1")
{
die("<b><font size='4'>Your number has already been verified! :)<br><br><a href='index.php'>home</a><br></b></font>");
} else {
// continue
}
?>
<br>

<?php
include("global.inc.php");
$errors=0;
$error="<br><br><font size='4' color='red'>ERROR</font><br><ul>";
$vcode = $_POST['vcode'];
$healthy = array("%", "!", "=", "'", ",", " ", "?", "<", "&", ";");
$yummy   = array("", "", "", "", "" ,"", "", "", "", "");

$Paypal = str_replace($healthy, $yummy, $vcode);

if($Paypal=="" ){
$errors=1;
$error.="<li>You did not enter a Verification Code. <a href='payment.php'>Try again?</a><br>";
}
if($errors==1) echo $error;
else{
$where_form_is="http".($HTTP_SERVER_VARS["HTTPS"]=="on"?"s":"")."://".$SERVER_NAME.strrev(strstr(strrev($PHP_SELF),"/"));
$message="Paypal: ".$Paypal."
";


if($Paypal==$vercode ){
mysql_query("UPDATE main SET isverified='1' WHERE fbuser='$fbid'") 
or die(mysql_error());  
echo "<b><font size='4' color='green'><br><br>Your Cellphone number has been verified!</font><br><br>
You will now receive automatic updates if you win a Raffle, receive a new 'Guess' for the Number guessing game, and more. <br><br><br><font size='5'><a href='index.php'>home</a></b><br><br>";
} else {
echo "<b><font size='4' color='red'><br><br>Your Verification Code was invalid :( <br><br><a href='payment.php'>Try again?</a><br></font></b>";
}

?>




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

