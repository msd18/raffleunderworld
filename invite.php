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
  <fb:tab-item href='<? echo $appCanvasUrl; ?>invite.php' title='Invite Friends' selected='true' />
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

$ppal = $tow['paypal'];
$isverr = $tow['isverified'];
$idyy = $tow['id'];
}

?>
<fb:dialog id="my_dialog" cancel_button=1>  <fb:dialog-title>Referred Friends</fb:dialog-title> <fb:dialog-content><form id="my_form">
<?
$desult = mysql_query("SELECT * FROM main WHERE theref='$idyy'") 
or die(mysql_error());  

while($tdw = mysql_fetch_array( $desult )) {

$thafbee = $tdw['fbuser'];
$thaact = $tdw['activerefs'];
$thacompo = $tdw['compoffers'];

if ($thaact == "1")
{
$iliketurtles = "<font color='green'>ACTIVE</font>";
} else {
$iliketurtles = "<font color='red'>NOT YET ACTIVE</font>";
}
?>

<fb:name uid="<? echo $thafbee; ?>" /> (<a href="http://www.facebook.com/profile.php?id=<? echo $thafbee; ?>"><? echo $thafbee; ?></a>) - <? echo $iliketurtles; ?><br>
<?
}
?>
</form></fb:dialog-content></fb:dialog> 
<?
$xount = mysql_num_rows(mysql_query("SELECT id FROM main WHERE theref='$idyy'"));
$xxount = mysql_num_rows(mysql_query("SELECT id FROM main WHERE theref='$idyy' AND activerefs='1'"));

echo "<br><font size='4'>Refer Friends to the Raffle!</font><br>
For every 5 friends you refer, <b>you get 1 free raffle ticket</b>!*<br><br><br>
<font size='4'>Your Referral URL:</font><br>
<a href='$appCanvasUrl$idyy'><font size='3'>$appCanvasUrl$idyy</font></a><br><br><font size='5'>You have referred <b><a href='#' clicktoshowdialog='my_dialog'>$xount</a></b> friends, <b>$xxount</b> of which are active users!</font><br><br><br>* = an Active referral is someone who adds our application from your Referral URL, and completes atleast 1 offer to earn tickets. You get 0.2 tickets per active referral (1 ticket for every 5 active referrals!)<br><hr><br><br>";
?>
<font size="4">Let us help!</font><br>
Simply click on any online friend below to send them a pre-made message with your referral URL (feel free to edit it)!<br><br>
<fb:chat-invite msg="check out the Facebook Raffle (current prize: $25, free to join) <? echo $appCanvasUrl; ?><? echo $idyy; ?>" condensed="false" /><br><br>
</div>

<div class=whiteBox>
<?php require_once 'ads/bottomads.php'; ?>

</div>

</div>

