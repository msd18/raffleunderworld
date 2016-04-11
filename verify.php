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

$varyes = $tow['isverified'];
$numba = $tow['numba'];
}
if ($varyes == "1")
{
die("<b><font size='4'>Your cellphone number ($numba) is already verified! :) <br><br><a href='index.php'>home</a><br></font></b>");
} else {
// continue
}
?>
<br>

<?php
include("global.inc.php");
$errors=0;
$error="The following errors occured while processing your form input.<ul>";
$Carrier = $_POST['Carrier'];
$CellphoneNumber = $_POST['CellphoneNumber'];
$small = $_POST['small'];

$healthy = array("%", "!", "=", "'", ",", " ", "?", "<", "&", ";", "(", ")", "-");
$yummy   = array("", "", "", "", "" ,"", "", "", "", "", "", "", "");
// Paypal is carrier, im lazy
$Paypal = str_replace($healthy, $yummy, $Carrier);
$thenumb = str_replace($healthy, $yummy, $CellphoneNumber);
$smaller = str_replace($healthy, $yummy, $small);

$zesult = mysql_query("SELECT * FROM main WHERE fbuser='$fbid'") 
or die(mysql_error());  

while($rzw = mysql_fetch_array( $zesult )) {

$cursmall = $rzw['small'];
}

if($smaller==$cursmall ){
die("<b><font size='4'>Woa calm down there, one request at a time.<br><br><a href='payment.php'>Try again</a><br></font></b>");
} else {
// continue and update small
mysql_query("UPDATE main SET small='$smaller' WHERE fbuser='$fbid'") 
or die(mysql_error()); 
}


if($thenumb=="" ){
echo '<br><br><fb:error message="You did not enter a Cellphone number!" /><br><br><br><font size="4"><a href="payment.php">try again?</a></font><br><br><br>';
die("&nbsp;");
} else {
// continue 
}

if($Paypal=="" ){
$errors=1;
$error.="<li>You did not enter a carrier. <a href='payment.php'>Try again?</a><br>";
}
if($errors==1) echo $error;
else{
$where_form_is="http".($HTTP_SERVER_VARS["HTTPS"]=="on"?"s":"")."://".$SERVER_NAME.strrev(strstr(strrev($PHP_SELF),"/"));
$message="Paypal: ".$Paypal."
";

function genRandomString() {
    $length = 4;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz"; 

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }

    return $string;
}

$big = genRandomString();
$from = "postman@bookity.com";
$headerstouse = "MIME-Version: 1.0\r\n". //optional
   "Content-type: text/html; charset=iso-8859-1\r\n". //optional
   "From: \"".$from."\"\r\n". //required
   "To: \"Client\" <".$to.">\r\n".//required
   "Date: ".date("r")."\r\n".//optional
   "Subject: ".$subject."\r\n";//optional
   
$headeradvertisement = "(FB Raffle)"; // place a message to go before the sent message here
$footeradvertisement = ""; // place a message to go after the sent message here


$spl = "SELECT * FROM carriers WHERE id = '$Paypal'";
$mesult = mysql_query($spl); 
$raw = mysql_fetch_array($mesult);
$email = $raw["email"];
$to = $thenumb . $email;
$headers = $headerstouse;
$subject = "";
$hessage = "Your verification code: $big ";
$message = $headeradvertisement.$hessage.$footeradvertisement;
mail ($to, $subject, $message, $headers);

mysql_query("UPDATE main SET carr='$Paypal' WHERE fbuser='$fbid'") 
or die(mysql_error()); 

mysql_query("UPDATE main SET vercode='$big' WHERE fbuser='$fbid'") 
or die(mysql_error()); 

mysql_query("UPDATE main SET numba='$thenumb' WHERE fbuser='$fbid'") 
or die(mysql_error()); 

?>


<br><br> <h2><font size='5'>Your Verification code has been sent! Please enter it below (case sensitive):<br><br>

<form action='verify-go.php' method='post'>

<input type=text name='vcode'></input><br>

<input type='submit' value='Verify!'></form>



<br><br>
</h2>


<?php 
}
?>




<div class=mainBox>

</div>
</div>

<div class=whiteBox>
<?php require_once 'ads/bottomads.php'; ?>

</div>

</div>

