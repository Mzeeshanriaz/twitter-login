<?php
define('Consumer_Key', 'aLwr4XvxTXu51KqqDzEPUxTGX');

define("Consumer_Secret", '9oolqywzakJnEUeHk67S115Pv5jLQeIuqyYYUJ30YKOZIhD7Tk');

define("Callback_URL", "http://localhost:8080/twitter-login/t-file.php");

require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;


$connection = new TwitterOAuth(Consumer_Key, Consumer_Secret);

$request_token = $connection->oauth("oauth/request_token", array("oauth_callback" => Callback_URL));


$_SESSION['oauth_token'] = $request_token['oauth_token'];

$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

$url = $connection->url("oauth/authorize", array("oauth_token" => $request_token['oauth_token']));
if(!$_GET['oauth_token'] && !$_GET['oauth_verifier'])
{
header('Location: ' . $url);
} else {
    $access_token = $connection->oauth('oauth/access_token', array('oauth_verifier' => $_REQUEST['oauth_verifier'], 'oauth_token'=> $_GET['oauth_token']));
	$connection = new TwitterOAuth(Consumer_Key, Consumer_Secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);

    $user_info = $connection->get('account/verify_credentials');
    print_r($user_info);
}
?>