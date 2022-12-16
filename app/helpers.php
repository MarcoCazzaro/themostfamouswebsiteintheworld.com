<?php
if (!function_exists('formatTagName')) {
    function formatTagName($tag_name) {
        return preg_replace("/[^A-Za-z0-9]/", '', $tag_name);
    }
}
if (!function_exists('humanNumber')) {
    function humanNumber($number) {
        $human_readable = new \NumberFormatter(
            'en_US',
            \NumberFormatter::PADDING_POSITION
        );
        return $human_readable->format($number);
    }
}
if (!function_exists('supportedSocialPlatforms')) {
    function supportedSocialPlatforms() {
        return ['youtube', 'twitter', 'facebook', 'instagram', 'tiktok', 'twitch', 'discord', 'pinterest', 'linkedin', 'reddit', 'stack-exchange'];
    }
}
if (!function_exists('getSocialNameFromLink')) {
    function getSocialNameFromLink($link) {
        $filtered = array_filter(supportedSocialPlatforms(), function($item) use ($link) {
            return (stripos($link, $item) !== false);
        });
        return array_pop($filtered);
    }
}

