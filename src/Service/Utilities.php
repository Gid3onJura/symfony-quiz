<?php

namespace App\Service;

class Utilities
{
    /**
     * generate a random string
     * 
     * @param integer $iLength
     * 
     * @return string
     */
    public function generateRandomCode($iLength = 6): string {
        $sCharacters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $sCode = '';
    
        for ($i = 0; $i < $iLength; $i++) {
            $sCode .= $sCharacters[rand(0, strlen($sCharacters) - 1)];
        }
    
        return $sCode;
    }

}
