<?php

class Yzy_help
{
    public function mydir()
    {
        $str = '';
        $arry = explode("/", $_SERVER['SCRIPT_FILENAME']);
        for ($i = 0; $i < count($arry) - 1; $i++)
            $str = $str . $arry[$i] . '/';
        return $str;
    }
    public function check($str)
    {
        return $str;
    }

    function md5pasd($str)
    {
        return substr(hash('sha512', $str . 'fsdjio@&/%$fsdf657t3'), 0, 10);
    }

}