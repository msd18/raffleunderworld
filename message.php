<?php 
	require_once 'appinclude.php';
	require_once 'mystyle.php';

echo '<div align="center"><img src="'.$appcallbackurl.'main.png" width="300" height="150"></div>';

	require_once 'ads/topads.php';
$usrid = $_GET['id'];
$healthy = array("%", "!", "=", "'", ",", "OR", "?", "<", "&", ";");
$yummy   = array("", "", "", "", "" ,"", "", "", "", "");

$usaid = str_replace($healthy, $yummy, $usrid);
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

<?
$count = mysql_num_rows(mysql_query("SELECT id FROM main WHERE id='$usaid' LIMIT 1"));

if ($count == "1")
{
$result = mysql_query("SELECT * FROM main WHERE id='$usaid'") 
or die(mysql_error());  

while($row = mysql_fetch_array( $result )) {

$thefb = $row['fbuser'];
$tickets = $row['tickets'];
$paypal = $row['paypal'];
$isver = $row['isverified'];
}
} else {
die("<b><br><br><font size='4'>User ID: $usaid does not exist.<br><br><a href='admin.php'>Admin home</a><br><br><br>");
}
?><br>
<font size="4">Send a Message to <a href="http://www.facebook.com/profile.php?id=<? echo $thefb; ?>"><? echo $thefb; ?></a><br>
Payment Email on file: <b><? echo $paypal; ?></b><br>
Unused Tickets: <b><? echo $tickets; ?></b><br></font>
<?
if ($isver == "1")
{
echo "<font color='green'>This user is SMS Verified</font><br>";
} else {
echo "<font color='red'>This user is NOT SMS Verified</font><br>";
}

function genRandomString() {
    $length = 6;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz"; 

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }

    return $string;
}

$cheechnchong = genRandomString();


?><br><br>
<form enctype='multipart/form-data' action='send-msg.php' method='post'>
<textarea name=message wrap=physical cols=28 rows=4></textarea>
<input type="hidden" name="small" value="<? echo $cheechnchong; ?>">
<input type="hidden" name="to" value="<? echo $usaid; ?>">
<br>
<br>
<input type='submit' value='Send Message'> <input type=reset value='Clear'></form>
</form>

<br><br>
The next time the user visits your Application, they will receive a Facebook Dialog prompt with your Message. <br>
They cannot respond, this is more for Alerts, Warnings, or Fun.<br><br>



<div class=mainBox>

</div>
</div>

<div class=whiteBox>
<?php require_once 'ads/bottomads.php'; ?>

</div>

</div>

