<?php 
	require_once 'appinclude.php';
	require_once 'mystyle.php';
$usrid = $_GET['id'];
$healthy = array("%", "!", "=", "'", ",", "OR", "?", "<", "&", ";");
$yummy   = array("", "", "", "", "" ,"", "", "", "", "");

$usaid = str_replace($healthy, $yummy, $usrid);

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
?>
<br>

<?

$count = mysql_num_rows(mysql_query("SELECT id FROM raffle WHERE id='$usaid'"));

if ($count == "1")
{
?>
<br><fb:success message="Raffle #<? echo $usaid; ?> has been marked as paid!" /><br><br><br><a href='admin.php'><font size='4'>Admin home</font></a><br><br>

<?
mysql_query("UPDATE raffle SET ispaid='1' WHERE id='$usaid'") or die(mysql_error());  
} else {
?>
<br><fb:error message="Raffle #<? echo $usaid; ?> does not exist :(" /><br><br><br><a href='admin.php'><font size='4'>Admin home</font></a><br><br>
<?
}

?></font>


</div>

<div class=whiteBox>
<?php require_once 'ads/bottomads.php'; ?>

</div>

</div>

