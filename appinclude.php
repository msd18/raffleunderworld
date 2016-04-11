<?php

require_once 'facebook.php';

// your api key and application secret, received in part 2 of 3 of the installation process
$appapikey = '5af4cbba29e1950587365592bc87e125';
$appsecret = '9ee4168e38fe022d83782636b98fd99a';

$adminid = "100000913457410";
// your facebook profile id, admin access will be allowed to the above facebook id

$thename = "AutoLotto";
// ONE WORD! No special characters, this is mainly used for the FB Forum
include "connect.php";
?>
<style type="text/css">  input.search { background:white url(facebook.com/images/magglass.png) no-repeat scroll 3px 4px; padding-left:17px; } input, textarea, select { border:1px solid #BDC7D8; font-family:"lucida grande",tahoma,verdana,arial,sans-serif; font-size:11px; padding:3px; } input:focus, textarea:focus, select:focus {border-color:#687FB0} .field {border:1px solid #bdc7d8; padding:2px} .field:focus {border-color:#687FB0} textarea.field {width:98.5%;height:100px} button { padding:1px 3px 1px 4px; font-size:1em; cursor:pointer; background:#3b5998; color:#fff; border:1px solid #0e1f5b; border-left-color:#D9DFEA; border-top-color:#D9DFEA; } button.next, button.cancel { background:#ddd; color:#111; border:1px solid #666; border-left-color:#ddd; border-top-color:#ddd }</style> 
<?

$facebook = new Facebook($appapikey, $appsecret);
$user = $facebook->require_login();

$appcallbackurl = 'http://www.bookity.com/2/';
// where the script is installed

$appCanvasUrl = 'http://apps.facebook.com/autolotto/';
// your canvas page url, set up in part 2 of 3 of the installation process

    try {
        if (!$facebook->api_client->users_isAppAdded()) {
            $facebook->redirect($facebook->get_add_url());
        }
    }
    catch (Exception $excatch) {
        $facebook->set_user(null, null);
        $facebook->redirect($appcallbackurl);
    }



