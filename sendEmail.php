<?php

require 'C:\Users\elect\OneDrive\Desktop\CryptoMining Auftrag\vendor\autoload.php';
use \Mailjet\Resources;

$apikey = 'c6b4679aced0dbfb09bc8a1149a84985'; 
$apisecret = '22381a3e093b2109d725736d77847287'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form fields
    $email = $_POST["email"];
    $phoneNumber = $_POST["phoneNumber"];
    $betreff = $_POST["betreff"];
    $nachricht = $_POST["nachricht"];
    
    // Build the email content
    $htmlContent = "
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
</style>
</head>
<body>
<table class='table'>
<tr>
    <th>Email</th>
    <td>{$email}</td>
</tr>
<tr>
    <th>Telefonnummer</th>
    <td>{$phoneNumber}</td>
</tr>
<tr>
    <th>Nachricht</th>
    <td>{$nachricht}</td>
</tr>
</table>
</body>
</html>
";

    $mj = new \Mailjet\Client($apikey, $apisecret, true, ['version' => 'v3.1']);
    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "sogeking.ali@gmail.com",
                    'Name' => "Website"
                ],
                'To' => [
                    [
                        'Email' => "sogeking.ali@gmail.com",
                        'Name' => "Recipient Name"
                    ]
                ],
                'ReplyTo' => [
                    'Email' => $email,
                    'Name' => "Website User"
                ],
                'Subject' => $betreff,
                'HTMLPart' => $htmlContent
            ]
        ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);

    // Send a JSON response back to the client
    if ($response->success()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}