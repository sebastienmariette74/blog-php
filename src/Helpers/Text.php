<?php

namespace App\Helpers;

class Text 
{
    public static function excerpt(string $content, int $limit = 60)
    {
        if (mb_strlen($content) <= $limit){
            return $content;
        };   
        $lastSpace = mb_strpos($content, ' ', $limit); // place du prochain espace après la limite pour ne pas couper un mot    
        return mb_substr($content, 0 , $lastSpace) . '...';
    }
}