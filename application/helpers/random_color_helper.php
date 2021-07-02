<?php
function generateRandomColor(){
    $color = '#';
    $colorHexLighter = array("9","a","b","c","d","e","f" );
    for($i = 0; $i < 6; $i++):
        $color .= $colorHexLighter[array_rand($colorHexLighter, 1)]  ;
    endfor;
    return substr($color, 0, 7);
}