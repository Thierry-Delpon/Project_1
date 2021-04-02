<?php


namespace App\Services;


class TextUtils
{
    public function returnLineAfterDot($text) {
        return preg_replace('#\.\s#','.<br>', $text);
    }
}