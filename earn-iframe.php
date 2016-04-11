<?
$face = $_GET['id'];
$healthy = array("%", "!", "=", "'", ",", "OR", "?", "<", "&", ";");
$yummy   = array("", "", "", "", "" ,"", "", "", "", "");

$id = str_replace($healthy, $yummy, $face);
include "connect.php";
?>
<head>
<script type="text/javascript" src="<? echo $gatewayurl; ?>&subid=<? echo $id; ?>"></script>
</head>