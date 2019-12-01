<?php

//By Anvar Ashurov

require_once('../database_op/connect.php');

if(isset($_POST)) {
    $sql = "SELECT * FROM $hackathon";
    $result = $conn->query($sql);
    $json = array();
    while ($row = $result->fetch_assoc()) {
        $json[] = array(
            'name' => $row['hackName'],
            'description' => $row['hackDesc'],
            'prize' => $row['hackPrize'],
            'city' => $row['hackCity'],
            'state' => $row['hackState'],
            'startDate' => $row['hackStartDate'],
            'endDate' => $row['hackEndDate'],
            'hasTime' => $row['hackTime'],
            'info' => $row['hackInfo'],
            'link' => $row['hackLink'],
            'imageLink' => $row['hackImageURL'],
            'hackathonImage' => $row['hackImageBinary']);
    }
    echo(json_encode($json));
}
