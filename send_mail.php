<?php

require __DIR__ . '/vendor/autoload.php';
use \Mailjet\Resources;

$apikey = 'c6b4679aced0dbfb09bc8a1149a84985'; 
$apisecret = '22381a3e093b2109d725736d77847287'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['aname']) ? strip_tags(trim($_POST["aname"])) : '';
    $email = isset($_POST['aemail']) ? filter_var(trim($_POST["aemail"]), FILTER_SANITIZE_EMAIL) : '';
    $phone = isset($_POST['aphone']) ? strip_tags(trim($_POST["aphone"])) : '';
    $subject = isset($_POST['asubject']) ? strip_tags(trim($_POST["asubject"])) : '';
    $message = isset($_POST['rmessage']) ? strip_tags(trim($_POST["rmessage"])) : '';

    if (empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: kryptomining.html?success=-1");
        exit;
    }

    $mj = new \Mailjet\Client($apikey, $apisecret, true, ['version' => 'v3.1']);
    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "sogeking.ali@gmail.com",
                    'Name' => "Kryptomining"
                ],
                'To' => [
                    [
                        'Email' => "sogeking.ali@gmail.com",
                        'Name' => "Kryptomining"
                    ]
                ],
                'ReplyTo' => [
                    'Email' => $email,
                    'Name' => $name
                ],
                'Subject' => $subject,
                'HTMLPart' => "
<html>
<head>
<style>
body {
    font-family: 'Arial, sans-serif';
    color: #333333;
}
.table {
    width: 100%;
    max-width: 600px;
    margin: auto;
    border-collapse: collapse;
}
.table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
}
.table th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #f7921a;
    color: white;
}
.logo {
    display: block;
    margin: 0 auto 20px auto;
    text-align: center;
}
</style>
</head>
<body>

<table class='table'>
<tr>
    <th>Name</th>
    <td>{$name}</td>
</tr>
<tr>
    <th>Email</th>
    <td>{$email}</td>
</tr>
<tr>
    <th>Telefonnummer</th>
    <td>{$phone}</td>
</tr>
<tr>
    <th>Nachricht</th>
    <td>{$message}</td>
</tr>
</table>
</body>
</html>
"
            ]
        ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    file_put_contents('log.txt', print_r($response, true)); // Log the response here

    if ($response->success()) {
        header("Location: kryptomining.html?success=1");
    } else {
        header("Location: kryptomining.html?success=-1");
    }
    exit;
     // Ensure the script stops executing after the redirect.
} else {
    header("Location: kryptomining.html");
    exit; // Ensure the script stops executing after the redirect.
}
?>