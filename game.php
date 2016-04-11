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

$guesser = $tow['guessgame'];
}

?>
<br><br><font size="4">
<b>Guess the Random Number between 1 and 10 and get <u>1 free raffle ticket!</u><br><br><br></font>

<?
if ($guesser == "1")
{
echo "<b><font size='4' color='red'>You have no more guesses left :( check back later!<br><br><a href='index.php'>home</a><br><br><br>";
} else {
?>
<form action='guess.php' method='post'>

<select name="guess">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select>

<br><br><br>
<input type='submit' value='Submit Guess!'></form>
<br><br><br><br>
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

