<?php
App::uses('AppHelper', 'View/Helper');

class DisplayHelper extends AppHelper {
    public function shortenString($string, $max_length)
    {
        if (mb_strlen($string) > $max_length) {
            return mb_substr($string, 0, $max_length) . '...';
        } else {
            return $string;
        }
    }    
}