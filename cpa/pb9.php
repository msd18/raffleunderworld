<?
// your postback password, entered when setting up the cpalead widget
$YOURPASSWORD   = "password";

$mysql_where    = "localhost";
$mysql_username = "DBUSERNAME";
$mysql_password = "DBPASS";
$mysql_database = "DBNAME";

$password = $_REQUEST['password'];
if ($password != $YOURPASSWORD) {
    echo "Access Denied";
    exit;
}

mysql_connect($mysql_where, $mysql_username, $mysql_password);
mysql_select_db($mysql_database);

$subid   = $_REQUEST['subid'];
$survey  = $_REQUEST['survey'];
$earn    = $_REQUEST['earn'];
$pdtshow = $_REQUEST['pdtshow'];

mysql_query("UPDATE main SET tickets = tickets +$pdtshow WHERE fbuser='$subid'") 
or die(mysql_error()); 

mysql_query("UPDATE main SET compoffers = compoffers +1 WHERE fbuser='$subid'") 
or die(mysql_error()); 






$tesult = mysql_query("SELECT * FROM main WHERE fbuser='$subid'") 

or die(mysql_error());  



while($rww = mysql_fetch_array( $tesult )) {



$tharef = $rww['theref'];
$thacomp = $rww['compoffers'];
}



if ($tharef == "")

{
// no ref, do nothing here
} else {
// referred user, credit referrer
if ($thacomp == "1")
{
mysql_query("UPDATE main SET activerefs='1' WHERE fbuser='$subid'") or die(mysql_error());  

mysql_query("UPDATE main SET tickets = tickets +.2 WHERE id='$tharef'") 
or die(mysql_error()); 

} else {
// referrer already set active and credited for referral
}
}




echo "Success: ".$subid." earned ".$pdtshow." points\n"; 

?>
