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
  <fb:tab-item href='<? echo $appCanvasUrl; ?>forum.php' title='Forum' selected='true' />
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
<?
if ($fbid == $adminid)
{
$forumv = "true";
} else {
$forumv = "false";
}
?>
<fb:board xid="<? echo $thename; ?>" canpost="true" candelete="<? echo $forumv; ?>" canmark="false" cancreatetopic="true" numtopics="5" returnurl="<? echo $appCanvasUrl; ?>">  <fb:title><? echo $thename; ?> Forum</fb:title> </fb:board>

<div class=mainBox>

</div>
</div>

<div class=whiteBox>
<?php require_once 'ads/bottomads.php'; ?>

</div>

</div>

