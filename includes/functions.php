<?php

if (!function_exists('formatPrice')) {
    function formatPrice($price) {
        return "Rs. " . number_format($price);
    }
}



if (!function_exists('cleanInput')) {
    function cleanInput($conn, $data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return mysqli_real_escape_string($conn, $data);
    }
}


if (!function_exists('shortenText')) {
    function shortenText($text, $limit = 100) {
        if (strlen($text) > $limit) {
            return substr($text, 0, $limit) . "...";
        }
        return $text;
    }
}


if (!function_exists('redirect')) {
    function redirect($url) {
        echo "<script>window.location.href='$url';</script>";
        exit();
    }
}
?>