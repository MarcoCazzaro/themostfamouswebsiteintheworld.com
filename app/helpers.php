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