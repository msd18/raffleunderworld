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
  <fb:tab-item href='<? echo $appCanvasUrl; ?>history.php' title='Raffle History' selected='true' />
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

<br>
<font size="5">Raffle History:<br><br></font>


<div align='center'>
<?
$result = mysql_query("SELECT * FROM raffle ORDER BY id DESC") 
or die(mysql_error());  

while($row = mysql_fetch_array( $result )) {

$winnaa = $row['winner'];
$finni = $row['fintime'];
$eyed = $row['id'];

if ($winnaa==$fbid){
$thetree = "<b>You Won!</b>";
} else {
$thetree = "<a href='http://www.facebook.com/profile.php?id=$winnaa'>Winner</a>";
}

$count = mysql_num_rows(mysql_query("SELECT id FROM tickets WHERE raffle='$eyed' AND fbusa='$fbid'"));

if ($winnaa==""){
echo "<font size='3'>Raffle #$eyed (Current Raffle! No winner yet!) - You have <b>$count</b> tickets in this Raffle!<br><b>Prize: <font color='green'>$25.00 </font></b><br><br></font>";
} else {
echo "<font size='3'>Raffle #$eyed ($thetree) - Winner selected on $finni<br>You had <b>$count</b> tickets in this Raffle! - <b> Prize: <font color='green'>$25.00 </font></b><br><br></font>";
}
}
?>
</font>
</div>

<div class=mainBox>

</div>
</div>

<div class=whiteBox>
<?php require_once 'ads/bottomads.php'; ?>

</div>

</div>


