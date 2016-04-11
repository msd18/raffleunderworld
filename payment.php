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

$ppal = $tow['paypal'];
$isverr = $tow['isverified'];
$peetype = $tow['ptype'];
}

?>
<br><br><font size="4">
If you win a raffle, we can't pay you unless your Email is correct below! Please make sure it is up to date.<br></font>
<?
if ($peetype == "amazon")
{
echo "You will receive a $25 Amazon Gift card if you win a Raffle to this email!)<br>";
} else {
echo "You will receive a $25 iTunes Gift card to the email below, make sure it's correct!<br>";
}
?><br><br>

<form action='update.php' method='post'>

<input type=email name='Paypal' value='<? echo $ppal; ?>'><br><br><br>
<input type='submit' value='Update Payment Email'></form>
<br>
We respect your email confidentiality.<br>
<hr>
<fb:dialog id="my_dialog">
<fb:dialog-title>Remove your Cellphone #?</fb:dialog-title>
<fb:dialog-content><form id="my_form">Are you sure you want to remove your Cellphone # from our app?</form></fb:dialog-content>
<fb:dialog-button type="button" value="Yes" href="remove-yes.php" />
<fb:dialog-button type="button" value="No" href="payment.php" />
</fb:dialog> 

<br><font size='4'>SMS Notify Settings</font><br><br>
Automatically get texted when you win a Raffle, Get another GUESS for the Number Guessing game, and more! (SMS Verified users get more Guesses for the # guessing game!) <b>Completely free, you can remove your cell # at ANY time <a href='#' clicktoshowdialog='my_dialog'>here</a>.<br><br>




<?
if ($isverr == "1")
{
echo '<fb:success message="Your cellphone number is verified!" /><br>';
} else {
?>
<form enctype='multipart/form-data' action='verify.php' method='post'>
<font size='4'>Select your Carrier:</font><br>
 <select name="Carrier">
                              <option value="" selected>-- Carriers --</option>
                              <?
$sql = "SELECT * FROM carriers";
$result = mysql_query($sql); 
while($row = mysql_fetch_array($result)) {
?>
                              <option value="<? echo $row["id"]; ?>"><? echo $row["name"]; ?></option>
                              <?
}
?></select><br><br>

<?
function genRandomString() {
    $length = 5;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz"; 

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }

    return $string;
}

$cheese = genRandomString();

?>
<font size='4'>Your Cellphone Number:</font> <br>
<input type=text name='CellphoneNumber'></input>
<input type=hidden name='small' value='<? echo $cheese; ?>'></input>
<br><br>
<input type='submit' value='Verify my #'> <input type=reset value='Reset'></form><br>
<?
}
?>
<div class=mainBox>

</div>
</div>

<div class=whiteBox>
<?php require_once 'ads/bottomads.php'; ?>

</div>

</div>

