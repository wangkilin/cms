<?php
// $Id: detect_language.php,v 1.1 2004/08/30 21:40:52 bzechmann Exp $
/**
* @ Copyright (C) 2004 mic (www.egi.at)
* @ Autor : mic
* @ URL: www.egi.at
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.1 $
**/

//=====================================================================================
// Automatic language detection Module
// Created for Mambo 4.5.x by mic
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//=====================================================================================

//=====================================================================================
// About the 'language detection module':
//
// This feature is meant if you are using your site as 'multilinguale website' which means
// MOS will detect the language of your users browser as the user defined it at his first visit,
// as long as there is no cookie stored with the preferred user language.
//
// For usage and installation look into the enclosed readme.txt
//
// If your site is only in one language there is no need to use this feature
//
// Questions, bugreports, suggestions?
// Contact me at: mic@egi.at
//
// Usage of this module can be seen at: http://www.egi.at
//======================================================================================

if($mosConfig_lang == ''){
  $det_lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

  // translate language-code and assign mosConfig_locale & mosConfig_lang
  // 4-dimensionale variable (2 will be used now, 3. and 4. for later)
  $part_lang = substr($det_lang, 0, 2);
  if($part_lang == 'dk'){
    $tmp_lng[0] = 'Danish';
    $tmp_lng[1] = 'da_DK';
    $tmp_lng[2] = 'danish';
    $tmp_lng[3] = 'iso-8859-1';
  }elseif($part_lang == 'de'){
    $tmp_lng[0] = 'Deutsch';
    $tmp_lng[1] = 'de_DE';
    $tmp_lng[2] = 'germanf';
    $tmp_lng[3] = 'iso-8859-1';
  /*
    }elseif($part_lang == 'nl'){
        $tmp_lng[0] = 'Dutch';
        $tmp_lng[1] = 'nl_NL';
        $tmp_lng[2] = 'dutch';
        $tmp_lng[3] = 'iso-8859-1';
    */
  }elseif($part_lang == 'en'){
    $tmp_lng[0] = 'English';
    $tmp_lng[1] = 'en_GB';
    $tmp_lng[2] = 'english';
    $tmp_lng[3] = 'iso-8859-1';
  }elseif($part_lang == 'fr'){
    $tmp_lng[0] = 'French';
    $tmp_lng[1] = 'fr_FR';
    $tmp_lng[2] = 'french';
    $tmp_lng[3] = 'iso-8859-1';
  }elseif($part_lang == 'hu'){
    $tmp_lng[0] = 'Hungarian';
    $tmp_lng[1] = 'hu_HU';
    $tmp_lng[2] = 'hungarian';
    $tmp_lng[3] = 'iso-8859-2';
  }elseif($part_lang == 'it'){
    $tmp_lng[0] = 'Italian';
    $tmp_lng[1] = 'it_IT';
    $tmp_lng[2] = 'italian';
    $tmp_lng[3] = 'iso-8859-1';
  }elseif($part_lang == 'ro'){
    $tmp_lng[0] = 'Roman';
    $tmp_lng[1] = 'ro_RO';
    $tmp_lng[2] = 'romanian';
    $tmp_lng[3] = 'iso-8859-2';
  /*
  }elseif($part_lang == 'sp'){
    $tmp_lng[0] = 'Spainish';
    $tmp_lng[1] = 'es_ES';
    $tmp_lng[2] = 'spain';
  */
  }else{
    $tmp_lng[0] = 'English';
    $tmp_lng[1] = 'en_GB';
    $tmp_lng[2] = 'english';
  }
  $mosConfig_locale = $tmp_lng[1];
  $mosConfig_lang = $tmp_lng[2];
} // end language detection
else{
  if($mosConfig_lang == 'germanf' || $mosConfig_lang == 'germani'){
    $mosConfig_locale = 'de_DE';
  }elseif($mosConfig_lang == 'danish'){
    $mosConfig_locale = 'da_DK';
  }elseif($mosConfig_lang == 'english'){
    $mosConfig_locale = 'en_GB';
  }elseif($mosConfig_lang == 'french'){
    $mosConfig_locale = 'fr_FR';
  }elseif($mosConfig_lang == 'hungarian'){
    $mosConfig_locale = 'hu_HU';
  }elseif($mosConfig_lang == 'italian'){
    $mosConfig_locale = 'it_IT';
  }elseif($mosConfig_lang == 'romanian'){
    $mosConfig_locale = 'ro_RO';
  }else{
    $mosConfig_locale = 'en_GB';
    $mosConfig_lang = 'english';
  }
}
setlocale(LC_TIME, $mosConfig_locale);
global $mosConfig_lang, $mosConfig_locale;
?>
