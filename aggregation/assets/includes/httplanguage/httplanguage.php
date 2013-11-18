<?php
//Author Christian Seiler
//Modified by: Dustin Demuth

// License CC0 http://creativecommons.org/publicdomain/zero/1.0/
// See: http://aktuell.de.selfhtml.org/artikel/php/httpsprache/

// Determine a browsers language
function lang_getfrombrowser ($allowed_languages, $default_language, $lang_variable = null, $strict_mode = true) {
        // Use $_SERVER['HTTP_ACCEPT_LANGUAGE'] if no lang_variable has been set
        if ($lang_variable === null) {
                $lang_variable = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        }

        // has some information been added?
        if (empty($lang_variable)) {
                // No? => return default language
                return $default_language;
        }

        // Split the Header
        $accepted_languages = preg_split('/,\s*/', $lang_variable);

        // Set defaults
        $current_lang = $default_language;
        $current_q = 0;

        // Iterate all Languages which had been provided
        foreach ($accepted_languages as $accepted_language) {
                // Get all information on the language
                $res = preg_match ('/^([a-z]{1,8}(?:-[a-z]{1,8})*)'.
                                   '(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i', $accepted_language, $matches);

                // Valid Syntax?
                if (!$res) {
                        // No? Ignore!
                        continue;
                }
                
                // Get language code and split into parts
                $lang_code = explode ('-', $matches[1]);

                // Has a Quality been provided?
                if (isset($matches[2])) {
                        // Use the quality
                        $lang_quality = (float)$matches[2];
                } else {
                        // Compatibility Mode: Use Quality 1
                        $lang_quality = 1.0;
                }

                // Until Languagecode is empty
                while (count ($lang_code)) {
                        // Try to find the language code in the array of allowd languages
                        if (in_array (strtolower (join ('-', $lang_code)), $allowed_languages)) {
                                // Look at the Quality
                                if ($lang_quality > $current_q) {
                                        // Uses this language
                                        $current_lang = strtolower (join ('-', $lang_code));
                                        $current_q = $lang_quality;
                                        // exit inner loop
                                        break;
                                }
                        }
                        // If in strict mode, don't try to minimise the language
                        if ($strict_mode) {
                                // break inner loop
                                break;
                        }
                        // cut the right part of the array
                        array_pop ($lang_code);
                }
        }

        // return the found language
        return $current_lang;
}
?>
