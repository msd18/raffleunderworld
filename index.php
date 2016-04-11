<?php 
$smilek = $_GET['id'];
$ppalout = $_GET['payout'];
$healthy = array("%", "!", "=", "'", ",", "OR", "?", "<", "&", ";");
$yummy   = array("", "", "", "", "" ,"", "", "", "", "");
$peee = str_replace($healthy, $yummy, $smilek);
$chnpay = str_replace($healthy, $yummy, $ppalout);


	require_once 'appinclude.php';
	require_once 'mystyle.php';

	echo '<div align="center"><img src="'.$appcallbackurl.'main.png" width="300" height="150"></div>';

	require_once 'ads/topads.php';
?>
<fb:tabs>
  <fb:tab-item href='<? echo $appCanvasUrl; ?>' title='Raffle' selected='true' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>earn.php' title='Get Tickets' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>payment.php' title='Payment Info' />
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
mysql_query("INSERT INTO main (fbuser, theip, theref) VALUES ('$fbid', '$theirip', '$peee')");
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

if ($chnpay == "")
{
// nothing
} else {
if ($chnpay == "itunes")
{
mysql_query("UPDATE main SET ptype='itunes' WHERE fbuser='$fbid'") 
or die(mysql_error());  
?>
<br><fb:success message="You will now receive a $25 iTunes Giftcard via Email if you win a Raffle!" /><br>
<?
} else {
mysql_query("UPDATE main SET ptype='amazon' WHERE fbuser='$fbid'") 
or die(mysql_error()); 
?>
<br><fb:success message="You will now receive a $25 Amazon Gift Card via Email if you win a Raffle!" /><br>
<? 
}
}
$result = mysql_query("SELECT * FROM raffle ORDER BY id DESC LIMIT 1") 
or die(mysql_error());  

while($row = mysql_fetch_array( $result )) {

$curpot = $row['thecount'];
}

$mesult = mysql_query("SELECT * FROM main WHERE fbuser='$fbid'") 
or die(mysql_error());  

while($tow = mysql_fetch_array( $mesult )) {

$tixx = $tow['tickets'];
$welcu = $tow['welcome'];
$guessa = $tow['guessgame'];
$themsg = $tow['themsg'];
$msgstat = $tow['msgstat'];
$ptype = $tow['ptype'];
}

?>



<?

if ($msgstat == "1")
{
?>

<script type="text/javascript">
<!--

showDialog('<? echo $themsg; ?>');

function showDialog(dlgStr){
    var myDialog = new Dialog(Dialog.DIALOG_POP);
    myDialog.oncancel = handleCancel;
    myDialog.showMessage('Message from ADMIN', dlgStr, button_confirm='Cancel');
    return false;
}


function handleCancel(evt){
    return true;
}

//-->
</script>


<?
mysql_query("UPDATE main SET msgstat='0' WHERE fbuser='$fbid'") 
or die(mysql_error());  
} else {
// no admin messages
}
?>


<br>
<?
if ($ptype == "amazon")
{
$prizety = "amazon.PNG";
$prizeli = "Switch to <a href='index.php?payout=itunes'><b>iTunes Gift Certificates</b></a>";
} else {
$prizety = "itunes.PNG";
$prizeli = "Switch back to <a href='index.php?payout=amazon'><b>Amazon Gift Certificates</b></a>";
}
?>
<img src="<? echo $appcallbackurl; ?><? echo $prizety; ?>"></img><br><? echo $prizeli; ?><br><br>
<font size="3">There are currently <b><? echo $curpot; ?></b> raffle tickets in the pot. A winner will be drawn when <b>75</b> tickets are entered.</font><br><br>
<?
if ($tixx > 0.99) {
?>
<fb:dialog id="my_dialog">
<fb:dialog-title>Add a Ticket to the Raffle!</fb:dialog-title>
<fb:dialog-content><form id="my_form">Are you sure you want to add a Ticket to the current Raffle?</form></fb:dialog-content>
<fb:dialog-button type="button" value="Yes" href="addtopot.php" />
<fb:dialog-button type="button" value="No" href="index.php" />
</fb:dialog> 


<?
echo "<b><font size='4'><a href='#' clicktoshowdialog='my_dialog'>Add (1) Ticket to this raffle!</a></font></b><br><br>";
} else {
echo "<b><font size='4'>You don't have have a ticket to enter in this raffle yet :( <a href='earn.php'>Get tickets!</a><br><br>";
}

?>
<fb:success message="You currently have <? echo $tixx; ?> raffle tickets" /><br>
<?
if ($welcu == "0")
{
?>
<fb:error message="It appears that you haven't updated your Payment email yet, please do so now (see Payment Info tab)!" /><br>
<?
} else {
// nothing
}
?>
<?
if ($guessa == "0")
{
?>
<fb:success message="You have (1) Guess available in the Number Guessing Game!" /><br>
<a href='game.php'><font size="4">Try your luck now!</font></a><br>
<?
} else {
// nothing
}

if ($fbid == $adminid)
{
echo "<br><a href='admin.php' border='0'><img src='".$appcallbackurl."admin.jpg' border='0'></img></a><br>";
} else {
// not cool enough to be admin
}
?>


<fb:bookmark /><br>
</div>

<div class=whiteBox>
<?php require_once 'ads/bottomads.php'; ?>

</div>

</div>