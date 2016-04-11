<?php 
	require_once 'appinclude.php';
	require_once 'mystyle.php';


	echo '<div align="center"><img src="'.$appcallbackurl.'main.png" width="300" height="150"></div>';

	require_once 'ads/topads.php';
$theaction = $_GET['to'];
$healthy = array("%", "!", "=", "'", ",", "OR", "?", "<", "&", ";");
$yummy   = array("", "", "", "", "" ,"", "", "", "", "");

$whatt = str_replace($healthy, $yummy, $theaction);

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

if ($whatt == "sms")
{
// add guess for sms verified only, notify them
mysql_query("UPDATE main SET guessgame='0' WHERE isverified='1'") 
or die(mysql_error()); 


$zesult = mysql_query("SELECT * FROM main WHERE isverified='1'") 
or die(mysql_error());  

while($rzw = mysql_fetch_array( $zesult )) {

$thecar = $rzw['carr'];
$thenumb = $rzw['numba'];

$from = "postman@bookity.com";
$headerstouse = "MIME-Version: 1.0\r\n". //optional
   "Content-type: text/html; charset=iso-8859-1\r\n". //optional
   "From: \"".$from."\"\r\n". //required
   "To: \"Client\" <".$to.">\r\n".//required
   "Date: ".date("r")."\r\n".//optional
   "Subject: ".$subject."\r\n";//optional
   
$headeradvertisement = "(FB Raffle)"; // place a message to go before the sent message here
$footeradvertisement = ""; // place a message to go after the sent message here


$spl = "SELECT * FROM carriers WHERE id = '$thecar'";
$mesult = mysql_query($spl); 
$raw = mysql_fetch_array($mesult);
$email = $raw["email"];
$to = $thenumb . $email;
$headers = $headerstouse;
$subject = "";
$hessage = "All SMS Verified Users have another GUESS for the FB Raffle # Guessing Game!";
$message = $headeradvertisement.$hessage.$footeradvertisement;
mail ($to, $subject, $message, $headers);

}
?><br>
<fb:success message="All SMS Verified Users now have a Guess - They have also been notified via SMS" /><br><br>
<a href='admin.php'><font size='4'>Admin home</font></a><br>
<?
} else {
// add guess to all, notify sms verified users



mysql_query("UPDATE main SET guessgame='0'") 
or die(mysql_error()); 


$zesult = mysql_query("SELECT * FROM main WHERE isverified='1'") 
or die(mysql_error());  

while($rzw = mysql_fetch_array( $zesult )) {

$thecar = $rzw['carr'];
$thenumb = $rzw['numba'];

$from = "postman@yoursite.com";
$headerstouse = "MIME-Version: 1.0\r\n". //optional
   "Content-type: text/html; charset=iso-8859-1\r\n". //optional
   "From: \"".$from."\"\r\n". //required
   "To: \"Client\" <".$to.">\r\n".//required
   "Date: ".date("r")."\r\n".//optional
   "Subject: ".$subject."\r\n";//optional
   
$headeradvertisement = "(FB Raffle)"; // place a message to go before the sent message here
$footeradvertisement = ""; // place a message to go after the sent message here


$spl = "SELECT * FROM carriers WHERE id = '$thecar'";
$mesult = mysql_query($spl); 
$raw = mysql_fetch_array($mesult);
$email = $raw["email"];
$to = $thenumb . $email;
$headers = $headerstouse;
$subject = "";
$hessage = "You have another GUESS for the FB Raffle # Guessing Game! Good luck";
$message = $headeradvertisement.$hessage.$footeradvertisement;
mail ($to, $subject, $message, $headers);

}
?><br>
<fb:success message="All Users now have a Guess - SMS Verified users have been notified" /><br><br>
<a href='admin.php'><font size='4'>Admin home</font></a><br>
<?
}
?>







<div class=mainBox>

</div>
<br>
</div>

<div class=whiteBox>
<?php require_once 'ads/bottomads.php'; ?>

</div>

</div>

