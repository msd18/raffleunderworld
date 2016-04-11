<?php 
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

$tixx = $tow['tickets'];
}

$result = mysql_query("SELECT * FROM raffle ORDER BY id DESC LIMIT 1") 
or die(mysql_error());  

while($row = mysql_fetch_array( $result )) {

$rafid = $row['id'];
$thea = $row['thecount'];
}

if ($thea == "75")
{
die("<font size='4'><br><br><br>This raffle is full! A winner will be chosen with 60 seconds and a new Raffle will be started. <br><br> <a href='index.php'>Home</a></font><br>");
} else {
// not full quite yet
}
?>
<br>

<br>
<?
$mehh = date('l jS \of F Y h:i:s A');
if ($tixx > 0.99) {

mysql_query("INSERT INTO tickets (raffle, fbusa, thetime) VALUES ('$rafid', '$fbid', '$mehh')");

mysql_query("UPDATE main SET tickets = tickets -1 WHERE fbuser='$fbid'") 
or die(mysql_error());  

mysql_query("UPDATE raffle SET thecount = thecount +1 WHERE id='$rafid'") 
or die(mysql_error());  
?>
<br>
<fb:success message="You have added (1) raffle ticket to Raffle #<? echo $rafid; ?>!" /><br>
<?
echo "<br><br><font size='3'>The more tickets you have in a raffle, the better chance you have at winning!<br><br><a href='index.php'>Home</a></font></b><br><br>";
} else {
echo "<b><font size='4'>You don't have have a ticket to enter in this raffle yet :( <a href='earn.php'>Get tickets!</a><br><br>";
}

?>


<div class=mainBox>

</div>
</div>

<div class=whiteBox>
<?php require_once 'ads/bottomads.php'; ?>

</div>

</div>

