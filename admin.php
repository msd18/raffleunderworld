<?php 
	require_once 'appinclude.php';
	require_once 'mystyle.php';

	echo '<div align="center"><img src="'.$appcallbackurl.'main.png" width="320" height="166"></div>';

	require_once 'ads/topads.php';
?>

<fb:tabs>
  <fb:tab-item href='<? echo $appCanvasUrl; ?>' title='Raffle' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>earn.php' title='Get Tickets' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>payment.php' title='Payment Info' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>history.php' title='Raffle History' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>forum.php' title='Forum' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>invite.php' title='Invite Friends' />
  <fb:tab-item href='<? echo $appCanvasUrl; ?>admin.php' title='Admin' selected='true' />
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
if ($adminid==$fbid){
// continue
} else {
die("<font size='4'><b><br><br>Access Denied - <a href='index.php'>home</a></b></font><br>");
}

$llount = mysql_num_rows(mysql_query("SELECT id FROM main"));
$lkount = mysql_num_rows(mysql_query("SELECT id FROM main WHERE isverified='1'"));
?>

<fb:dialog id="my_dialog" cancel_button=1>  <fb:dialog-title>All Users (Newest 50)</fb:dialog-title> <fb:dialog-content>
<form id="my_form">
<?
$qqesult = mysql_query("SELECT * FROM main ORDER BY id DESC LIMIT 50") 
or die(mysql_error());  

while($qow = mysql_fetch_array( $qqesult )) {

$fbues = $qow['fbuser'];
$compton = $qow['compoffers'];
$compid = $qow['id'];
$tixets = $qow['tickets'];
echo "<a href='http://www.facebook.com/profile.php?id=$fbues'>$fbues</a> - Completed Offers: <b>$compton</b> - <a href='message.php?id=$compid'>Msg/Alert user</a> - <b>$tixets</b> unused tickets<br>";
}
?>
</form>
</fb:dialog-content>  </fb:dialog> 


<fb:dialog id="hi_dialog" cancel_button=1>  <fb:dialog-title>SMS Verified Users (Newest 50)</fb:dialog-title> <fb:dialog-content>
<form id="hi_form">
<?
$qqesult = mysql_query("SELECT * FROM main WHERE isverified='1' ORDER BY id DESC LIMIT 50") 
or die(mysql_error());  

while($qow = mysql_fetch_array( $qqesult )) {

$fbues = $qow['fbuser'];
$compton = $qow['compoffers'];
$compid = $qow['id'];
echo "<a href='http://www.facebook.com/profile.php?id=$fbues'>$fbues</a> - Completed Offers: <b>$compton</b> - <a href='message.php?id=$compid'>Msg/Alert user</a><br>";
}
?>
</form>
</fb:dialog-content>  </fb:dialog> 

<?
echo "<br><font size='3'><b><a href='#' clicktoshowdialog='my_dialog'>$llount</a></b> people have added your app, <b><a href='#' clicktoshowdialog='hi_dialog'>$lkount</a></b> of them are SMS Verified.</font><br><br>";
?>
<br>
<font size="4">Number Game:<br><br>
<a href='addguess.php'>Give <b>Everyone</b> a "Guess" for the # Game</a><br><br>
<a href='addguess.php?to=sms'>Give <b>SMS Verified Users</b> a "Guess" for the # Game</a><br><hr>
Raffle Winners:<br><br></font>
<?

$count = mysql_num_rows(mysql_query("SELECT id FROM raffle WHERE done='1'"));

if ($count > 0) {
{
$result = mysql_query("SELECT * FROM raffle WHERE done='1'") 
or die(mysql_error());  

while($row = mysql_fetch_array( $result )) {

$winner = $row['winner'];
$finished = $row['fintime'];
$eyedee = $row['id'];
$ispaid = $row['ispaid'];

$hesult = mysql_query("SELECT * FROM main WHERE fbuser='$winner'") 
or die(mysql_error());  

while($raw = mysql_fetch_array( $hesult )) {
$paypal = $raw['paypal'];
$thewinna = $raw['id'];
$ptype = $raw['ptype'];
}
if ($ispaid == "1")
{
$paystat = "<font color='green'><b>Paid</b></font>";
} else {
$paystat = "<b><a href='paid.php?id=$eyedee'><font color='red'>Mark PAID</font></a></b>";
}

if ($ptype == "ppal")
{
$pchose = "Paypal";
} else {
$pchose = "<a href='http://www.amazon.com/gp/redirect.html?ie=UTF8&location=http%3A%2F%2Fwww.amazon.com%2Fgp%2Fgc&tag=buyalacom-20&linkCode=ur2&camp=1789&creative=390957' target='_blank'>Amazon Giftcard</a>";
}

echo "<a href='#' title='Ended: $finished'>Raffle #$eyedee</a> - Winner: <b>$winner</b> (<a href='message.php?id=$thewinna'>message winner</a>) $paystat<br> Payment Info: $paypal (User would like to be paid out via <b>$pchose</b>) <br><br>";
}
}
} else {
echo "<br><br><b>No raffles have been won yet - check back later!</b><br>";
}
?>

</font>


</div>

<div class=whiteBox>
<?php require_once 'ads/bottomads.php'; ?>

</div>

</div>


