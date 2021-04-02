<?php


namespace App\Services;


class Censurator
{
    const MOT_INVALID =["pute", "méchant", "voyou", "hugo"];

    public function purify(string $text): string {
        foreach (self::MOT_INVALID as $motInvalid) {
            $replacement = str_repeat("*", mb_strlen($motInvalid));
            $text = str_ireplace($motInvalid, $replacement, $text);
        }
        return $text;
    }

}