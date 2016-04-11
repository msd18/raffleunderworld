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
  <fb:tab-item href='<? echo $appCanvasUrl; ?>game.php' title='Guessing Game' selected='true' />
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

$thagame = $tow['guessgame'];
$isvery = $tow['isverified'];
}
if ($thagame == "1")
{
echo '<br><br><fb:error message="Error: You have no guesses left!" /><br><br><br><font size="4"><a href="index.php">home</a></font><br><br><br>';
die("&nbsp;");
} else {
// nothing
}
?>
<br>

<?php
include("global.inc.php");
$errors=0;
$error="The following errors occured while processing your form input.<ul>";
$guess = $_POST['guess'];
$healthy = array("%", "!", "=", "'", ",", " ", "?", "<", "&", ";");
$yummy   = array("", "", "", "", "" ,"", "", "", "", "");

$guess = str_replace($healthy, $yummy, $guess);

if($guess=="" ){
$errors=1;
$error.="<li>You did not enter a guess. <a href='index.php'>Back</a><br><br><br>";
}
if($errors==1) echo $error;
else{
$where_form_is="http".($HTTP_SERVER_VARS["HTTPS"]=="on"?"s":"")."://".$SERVER_NAME.strrev(strstr(strrev($PHP_SELF),"/"));
$message="guess: ".$guess."
";
$superman = rand(1, 10);

if($guess==$superman ){
echo '<br><br><fb:success message="Congratulations! Your guess was Correct! You have earned 1 ticket!" /><br><br><br><font size="4"><a href="index.php">home</a></font><br><br><br>';

mysql_query("UPDATE main SET tickets = tickets +1 WHERE fbuser='$fbid'") 
or die(mysql_error());  

mysql_query("UPDATE main SET guessgame='1' WHERE fbuser='$fbid'") 
or die(mysql_error());  
} else {

echo '<br><br><fb:error message="Sorry :( Your guess was not the correct answer. Better luck next time!" /><br><br><br><font size="4"><a href="index.php">home</a></font><br><br><br>';

mysql_query("UPDATE main SET guessgame='1' WHERE fbuser='$fbid'") 
or die(mysql_error());  
}
?>




<?php 
}

if ($isvery == "1")
{
// nothing 
} else {
?>
</div>
<fb:explanation>
<fb:message>Want more Guesses?</fb:message>
Become <a href="payment.php">SMS Verified!</a> (it's free!) While we give guesses to everyone as often as we feel, SMS Verified users receive even more guesses, more often!
</fb:explanation>
<div align="center">
<?
}
?>

</div>

<div class=whiteBox>
<?php require_once 'ads/bottomads.php'; ?>

</div>

</div>

