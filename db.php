<?php
$conn = new PDO('mysql:host=mysqlstudenti.litv.sssvt.cz;dbname=4b2_adamsimon_db1', 'adamsimon', '123456', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
$conn->query('SET NAMES utf8');
