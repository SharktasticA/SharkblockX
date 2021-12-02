<?php

/*
    Helper function functions for use within SharkblockX and in general.
    SharktasticA 2021
*/

include($_SERVER["DOCUMENT_ROOT"]."/resources/applets/Globals.php");

/**
 * Adds an attribute to a given HTML attribute options
 * array, handling if an attribute has already been specified.
 * @param array $attribs    The attributes array itself (passed by reference)
 * @param string $index     Array key to store the attribute at (eg, an element attribute name)
 * @param string $val       The attribute's value
 * @param bool $add_space   Flags if a space should be used in concating existing attribute with new val
 * @return string
 */
function add_attrib(&$attribs, $index, $val, $add_space = true)
{
    if (!is_array($attribs)) return "";

    if (!array_key_exists($index, $attribs)) $attribs[$index] = $val;
    else
    {
        if ($add_space) $attribs[$index] .= " ".$val;
        else $attribs[$index] .= $val;
    }

    return $attribs;
}

/**
 * Checks if a string contains a word.
 * @param string $str   String to check
 * @param string $word  Substring to find
 * @return bool
 */
function contains_word($str, $word)
{
    if (strpos($str, $word) !== false) return true;
    else return false;
}

/**
 * Converts an HTML attribute options array into
 * a string that can be echoed inside an element declaration.
 * @param array $attribs    The attributes array itself
 * @param bool $sort        Flags if attributes array should be ksorted
 * @return string
 */
function parse_attribs($attribs, $sort = true)
{
    if (!is_array($attribs)) return "";

    if ($sort) ksort($attribs);

    $attribs_str = " ";
    $attrib_names = array_keys($attribs);

    for ($i = 0; $i < count($attribs); $i++)
    {
        if ($attribs[$attrib_names[$i]] != "")
        {
            if (strpos($attribs[$attrib_names[$i]], '"') !== false)
                $attribs_str .= $attrib_names[$i]."='".$attribs[$attrib_names[$i]]."' ";
            else
                $attribs_str .= $attrib_names[$i].'="'.$attribs[$attrib_names[$i]].'" ';
        }
    }

    return truncate_str($attribs_str);
}

/**
 * Checks if image exists within this site's files.
 * @param string $src   Image filepath to validate
 * @return string
 */
function validate_img($src)
{
    if (!file_exists($GLOBALS["SRV_ROOT"].$src)) return $GLOBALS["NO_IMG_PLACEHOLDER"];
    else return $src;
}

/**
 * Truncates a string by the desired amount (defaulted
 * to one character).
 * @param string $str   String to truncate
 * @param int $count    Amount of characters to remove
 * @return string
 */
function truncate_str($str, $count = 1)
{
    return substr_replace($str,"", -1 * abs($count));
}