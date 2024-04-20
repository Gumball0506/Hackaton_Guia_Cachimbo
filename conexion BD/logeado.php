<?php
session_start();
if (!isset($_SESSION['id']) and $_SESSION['id'] != 1) {
    header("location: ../login.html");
    exit;
}
