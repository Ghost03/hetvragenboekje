<?php

function index_by($array, $idx, $value) {
    $result = array();
    foreach($array as $item)
        $result[$item[$idx]] = $item[$value];
    return $result;
}

/**
 * Reverse a mysql date for display
 * @param mysql date $date
 * @return string
 */
function date_reverse($date) {
    $date = explode('-',$date);
    return join('-',array_reverse($date));
}

/**
 * Debug a value using <pre>
 * @param type $v the value you want to debug
 * @param type $e exit after print
 * 
 */
function pr($v,$e = false){
    echo '<pre>';
    print_r($v);
    echo '</pre>';
    if($e) exit;
}

function index_by_full($array, $idx) {
    $result = array();
    foreach($array as $item)
        $result[$item[$idx]] = $item;
    return $result;
}

function group_by($array, $idx) {
    $result = array();
    foreach($array as $item) {
        if(!isset($result[$item[$idx]]))
            $result[$item[$idx]] = array();
            
        $result[$item[$idx]][] = $item;
    }
    
    return $result;
}

function generate_pagination($page, $count, $perPage) {
    if($count < $perPage)
        return array();
    
    $pages = ceil($count / $perPage);
    $displayPages = min($pages, 5);
    $startIndex = min(max($page - floor($displayPages / 2) , 1), max($pages - floor($displayPages / 2) * 2, 1));
    
    $result = array();
    if($page != 1) {
        $result[] = array('label' => 'first', 'page' => 1);
        $result[] = array('label' => 'prev', 'page' => $page - 1);
    }
    for($i = $startIndex; $i <= $startIndex + $displayPages - 1 ;$i++) {
        $item = array('label' => $i, 'page' => $i);
        if($i == $page)
            $item['active'] = true;
        $result[] = $item;
    }
    if($page != $pages) {
        $result[] = array('label' => 'next', 'page' => $page + 1);
        $result[] = array('label' => 'last', 'page' => $pages);
    }
    
    return $result;
}

function sanitize($title, $separator = '-') {

    // Transliterate non-ASCII characters
    $title = transliterate_to_ascii($title);

    // Remove all characters that are not the separator, a-z, 0-9, or whitespace
    $title = preg_replace('![^' . preg_quote($separator) . 'a-z0-9\s]+!', '', strtolower($title));
    
    // Replace all separator characters and whitespace by a single separator
    $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);

    // Trim separators from the beginning and end
    return trim($title, $separator);
}

function transliterate_to_ascii($str, $case = 0) {
    static $utf8_lower_accents = NULL;
    static $utf8_upper_accents = NULL;

    if ($case <= 0) {
        if ($utf8_lower_accents === NULL) {
            $utf8_lower_accents = array(
                '√†' => 'a', '√¥' => 'o', 'ƒè' => 'd', '·∏ü' => 'f', '√´' => 'e', '≈°' => 's', '∆°' => 'o',
                '√ü' => 'ss', 'ƒÉ' => 'a', '≈ô' => 'r', '»õ' => 't', '≈à' => 'n', 'ƒÅ' => 'a', 'ƒ∑' => 'k',
                '≈ù' => 's', '·ª≥' => 'y', '≈Ü' => 'n', 'ƒ∫' => 'l', 'ƒß' => 'h', '·πó' => 'p', '√≥' => 'o',
                '√∫' => 'u', 'ƒõ' => 'e', '√©' => 'e', '√ß' => 'c', '·∫Å' => 'w', 'ƒã' => 'c', '√µ' => 'o',
                '·π°' => 's', '√∏' => 'o', 'ƒ£' => 'g', '≈ß' => 't', '»ô' => 's', 'ƒó' => 'e', 'ƒâ' => 'c',
                '≈õ' => 's', '√Æ' => 'i', '≈±' => 'u', 'ƒá' => 'c', 'ƒô' => 'e', '≈µ' => 'w', '·π´' => 't',
                '≈´' => 'u', 'ƒç' => 'c', '√∂' => 'o', '√®' => 'e', '≈∑' => 'y', 'ƒÖ' => 'a', '≈Ç' => 'l',
                '≈≥' => 'u', '≈Ø' => 'u', '≈ü' => 's', 'ƒü' => 'g', 'ƒº' => 'l', '∆í' => 'f', '≈æ' => 'z',
                '·∫É' => 'w', '·∏É' => 'b', '√•' => 'a', '√¨' => 'i', '√Ø' => 'i', '·∏ã' => 'd', '≈•' => 't',
                '≈ó' => 'r', '√§' => 'a', '√≠' => 'i', '≈ï' => 'r', '√™' => 'e', '√º' => 'u', '√≤' => 'o',
                'ƒì' => 'e', '√±' => 'n', '≈Ñ' => 'n', 'ƒ•' => 'h', 'ƒù' => 'g', 'ƒë' => 'd', 'ƒµ' => 'j',
                '√ø' => 'y', '≈©' => 'u', '≈≠' => 'u', '∆∞' => 'u', '≈£' => 't', '√Ω' => 'y', '≈ë' => 'o',
                '√¢' => 'a', 'ƒæ' => 'l', '·∫Ö' => 'w', '≈º' => 'z', 'ƒ´' => 'i', '√£' => 'a', 'ƒ°' => 'g',
                '·πÅ' => 'm', '≈ç' => 'o', 'ƒ©' => 'i', '√π' => 'u', 'ƒØ' => 'i', '≈∫' => 'z', '√°' => 'a',
                '√ª' => 'u', '√æ' => 'th', '√∞' => 'dh', '√¶' => 'ae', '¬µ' => 'u', 'ƒï' => 'e', 'ƒ±' => 'i',
            );
        }

        $str = str_replace(
                array_keys($utf8_lower_accents), array_values($utf8_lower_accents), $str
        );
    }

    if ($case >= 0) {
        if ($utf8_upper_accents === NULL) {
            $utf8_upper_accents = array(
                '√Ä' => 'A', '√î' => 'O', 'ƒé' => 'D', '·∏û' => 'F', '√ã' => 'E', '≈†' => 'S', '∆†' => 'O',
                'ƒÇ' => 'A', '≈ò' => 'R', '»ö' => 'T', '≈á' => 'N', 'ƒÄ' => 'A', 'ƒ∂' => 'K', 'ƒî' => 'E',
                '≈ú' => 'S', '·ª≤' => 'Y', '≈Ö' => 'N', 'ƒπ' => 'L', 'ƒ¶' => 'H', '·πñ' => 'P', '√ì' => 'O',
                '√ö' => 'U', 'ƒö' => 'E', '√â' => 'E', '√á' => 'C', '·∫Ä' => 'W', 'ƒä' => 'C', '√ï' => 'O',
                '·π†' => 'S', '√ò' => 'O', 'ƒ¢' => 'G', '≈¶' => 'T', '»ò' => 'S', 'ƒñ' => 'E', 'ƒà' => 'C',
                '≈ö' => 'S', '√é' => 'I', '≈∞' => 'U', 'ƒÜ' => 'C', 'ƒò' => 'E', '≈¥' => 'W', '·π™' => 'T',
                '≈™' => 'U', 'ƒå' => 'C', '√ñ' => 'O', '√à' => 'E', '≈∂' => 'Y', 'ƒÑ' => 'A', '≈Å' => 'L',
                '≈≤' => 'U', '≈Æ' => 'U', '≈û' => 'S', 'ƒû' => 'G', 'ƒª' => 'L', '∆ë' => 'F', '≈Ω' => 'Z',
                '·∫Ç' => 'W', '·∏Ç' => 'B', '√Ö' => 'A', '√å' => 'I', '√è' => 'I', '·∏ä' => 'D', '≈§' => 'T',
                '≈ñ' => 'R', '√Ñ' => 'A', '√ç' => 'I', '≈î' => 'R', '√ä' => 'E', '√ú' => 'U', '√í' => 'O',
                'ƒí' => 'E', '√ë' => 'N', '≈É' => 'N', 'ƒ§' => 'H', 'ƒú' => 'G', 'ƒê' => 'D', 'ƒ¥' => 'J',
                '≈∏' => 'Y', '≈®' => 'U', '≈¨' => 'U', '∆Ø' => 'U', '≈¢' => 'T', '√ù' => 'Y', '≈ê' => 'O',
                '√Ç' => 'A', 'ƒΩ' => 'L', '·∫Ñ' => 'W', '≈ª' => 'Z', 'ƒ™' => 'I', '√É' => 'A', 'ƒ†' => 'G',
                '·πÄ' => 'M', '≈å' => 'O', 'ƒ®' => 'I', '√ô' => 'U', 'ƒÆ' => 'I', '≈π' => 'Z', '√Å' => 'A',
                '√õ' => 'U', '√û' => 'Th', '√ê' => 'Dh', '√Ü' => 'Ae', 'ƒ∞' => 'I',
            );
        }

        $str = str_replace(
                array_keys($utf8_upper_accents), array_values($utf8_upper_accents), $str
        );
    }

    return $str;
}

function pycopy($src, $dest) {
        
    $ch = curl_init(); 

    curl_setopt($ch, CURLOPT_URL, $src); 
    curl_setopt($ch, CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

    set_time_limit(300); # 5 minutes for PHP 
    curl_setopt($ch, CURLOPT_TIMEOUT, 300); # and also for CURL 

    $outfile = fopen($dest, 'w'); 
    curl_setopt($ch, CURLOPT_FILE, $outfile); 
    curl_exec($ch); 
    fclose($outfile); 

    curl_close($ch);
}