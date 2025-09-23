<?php
$env = parse_ini_file(__DIR__ . '/../.env');

$DB_HOST = $env['DB_HOST'];
$DB_USER = $env['DB_USER'];
$DB_PASS = $env['DB_PASS'];
$DB_NAME = $env['DB_NAME'];

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>