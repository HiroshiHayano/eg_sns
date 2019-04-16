<?php
App::uses('AppHelper', 'View/Helper');

class DisplayHelper extends AppHelper {

    public function shortenString($string, $length){
        return mb_ereg_replace(mb_substr($string, $length), '...', $string);
    }
}