<?php
require_once(__DIR__ . '/config/config.php');
require_once(__DIR__ . '/helpers/Session.php');


function testLogin($username, $password) {
    $url = API_BASE_URL . '/usuario/validate';

    $data = [
        'username' => $username,
        'password' => $password
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    echo "HTTP Code: $http_code\n";
    if ($error) {
        echo "CURL Error: $error\n";
    }
    echo "Response:\n$response\n";
}

// Cambia estos valores por tu usuario real y contraseña
$username = 'edil';
$password = '123456';

testLogin($username, $password);
