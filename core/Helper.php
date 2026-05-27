<?php

function timeAgo($datetime) {
    $time = time() - strtotime($datetime);

    if ($time < 60) {
        return "a few moments ago";
    }

    if ($time < 3600) {
        return floor($time / 60) . " min ago";
    }

    if ($time < 86400) {
        return floor($time / 3600) . " hours ago";
    }

    if ($time < 604800) {
        return floor($time / 86400) . " days ago";
    }

    return date("M j, Y", strtotime($datetime));
}