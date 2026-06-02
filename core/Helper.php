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

function verifyTurnstile($token, $secret) {
    $url = "https://challenges.cloudflare.com/turnstile/v0/siteverify";

    $data = [
        'secret' => $secret,
        'response' => $token,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return json_decode($result, true);
}