<?
include "connect.php";

$result = mysql_query("SELECT * FROM raffle ORDER BY id DESC LIMIT 1") 
or die(mysql_error());  

while($row = mysql_fetch_array( $result )) {

$curcount = $row['thecount'];
$rafid = $row['id'];
}

if ($curcount == "75")
{
// declare random winner
// start new raffle at zero
$tesult = mysql_query("SELECT * FROM tickets WHERE raffle='$rafid' ORDER BY rand() LIMIT 1") 
or die(mysql_error());  

while($raw = mysql_fetch_array( $tesult )) {

$fbwinner = $raw['fbusa'];
}

$zesult = mysql_query("SELECT * FROM main WHERE fbuser='$fbwinner' LIMIT 1") 
or die(mysql_error());  

while($rzw = mysql_fetch_array( $zesult )) {

$ifver = $rzw['isverified'];
$thecar = $rzw['carr'];
$thenumb = $rzw['numba'];
}

if ($ifver == "1")
{
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
$hessage = "You won a raffle! Congrats! Make sure your Payment info is up to date!";
$message = $headeradvertisement.$hessage.$footeradvertisement;
mail ($to, $subject, $message, $headers);
} else {
// nothing
}



mysql_query("UPDATE raffle SET winner='$fbwinner' WHERE id='$rafid'") 
or die(mysql_error());  

mysql_query("UPDATE raffle SET done='1' WHERE id='$rafid'") 
or die(mysql_error());  
$thefin = date('l jS \of F Y h:i:s A');
mysql_query("UPDATE raffle SET fintime='$thefin' WHERE id='$rafid'") 
or die(mysql_error());  

mysql_query("INSERT INTO raffle (thecount) VALUES('0' ) ") 
or die(mysql_error());  
}

?>

