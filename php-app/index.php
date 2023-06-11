<?php

$token = 'f420103a-e656-33f2-6834-0dd2d4cd4f35';
$endpoint = 'http://vault:8200';

// Path to the database credentials in Vault
$dbPath = 'database/creds/vault-mysql-role';

// Set cURL options
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $endpoint.'/v1/'.$dbPath);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Vault-Token: '.$token));

// Execute the cURL request
$response = curl_exec($ch);
echo "$response";
curl_close($ch);

// Process the response
$data = json_decode($response, true);
if (isset($data['data'])) {

    $dbCredentials = $data['data'];
    $host = 'mysql-server';
    $database = 'dbwebappdb';
    $username = $dbCredentials['username'];
    $password = $dbCredentials['password'];

    $mysqli = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    } else {
        echo "\n Connection successfull";
        $mysqli->close();
    }
    
} else {
    
}

?>
