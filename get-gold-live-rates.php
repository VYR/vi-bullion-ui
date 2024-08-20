<?php 


    $ch = curl_init();
    $url="http://13.235.208.189/lmxtrade/goldapi";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close($ch);
    $data_record= json_decode($server_output, true);
    header('Content-Type: application/json');
    echo json_encode($data_record, JSON_PRETTY_PRINT);