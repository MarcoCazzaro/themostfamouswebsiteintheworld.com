<?php

if (! function_exists('formatTagName')) {
    function formatTagName($tag_name)
    {
        return preg_replace('/[^A-Za-z0-9]/', '', $tag_name);
    }
}
if (! function_exists('humanNumber')) {
    //https://www.amitmerchant.com/human-readable-number-formatting-in-php/
    function humanNumber($number)
    {
        $human_readable = new \NumberFormatter(
            'en_US',
            \NumberFormatter::PADDING_POSITION,
            '#.0'
        );
        if ($number > 1000) {
            $human_readable->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, 2);
        }
        $human_readable->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 2);

        return $human_readable->format($number);
    }
}
if (! function_exists('supportedSocialPlatforms')) {
    function supportedSocialPlatforms()
    {
        return ['youtube', 'x-twitter', 'facebook', 'instagram', 'tiktok', 'twitch', 'discord', 'pinterest', 'linkedin', 'reddit', 'stack-exchange'];
    }
}
if (! function_exists('getSocialNameFromLink')) {
    function getSocialNameFromLink($link)
    {
        $filtered = array_filter(supportedSocialPlatforms(), function ($item) use ($link) {
            return stripos($link, $item) !== false;
        });

        return array_pop($filtered);
    }
}
if (! function_exists('getUserOption')) {
    function getUserOption($name)
    {
        $result = null;
        $option = auth()->user()->options()->where('name', $name)->first();
        if ($option) {
            $result = $option->value;
        }

        return $result;
    }
}
if (! function_exists('setUserOption')) {
    function setUserOption($name, $value)
    {
        auth()->user()->options()->updateOrCreate(
            ['name' => $name],
            ['value' => $value]
        );

        return true;
    }
}
