<?php

/*
    Basic HTML wrapper functions for use within SharkblockX and in general.
    SharktasticA 2021
*/

include($_SERVER["DOCUMENT_ROOT"]."/resources/applets/Helpers.php");

/**
 * Outputs markup for an anchor/hyperlink element.
 * @param string $str       String to go inside this element
 * @param string $uri       Hyperlink or page anchor
 * @param string $attribs   Custom HTML attribute options array
 * @return string
 */
function a($str, $uri = "#", $attribs = array())
{
    add_attrib($attribs, "href", $uri);

    return "<a".parse_attribs($attribs).">".$str."</a>";
}

/**
 * Outputs markup for a line break element.
 * @return string
 */
function br()
{
    return "<br />"; 
}

/**
 * Outputs markup for an inline code element.
 * @param string $str   String to go inside this element
 * @return string
 */
function code($str)
{
    return "<code>".$str."</code>";
}

/**
 * Outputs markup for a division element.
 * @param string $contents  String to go inside this element
 * @param string $attribs   Custom HTML attribute options array
 * @return string
 */
function div($contents, $attribs = array())
{
    return "<div".parse_attribs($attribs).">".$contents."</div>";
}

/**
 * Outputs markup for an emphasised (italic) text element.
 * @param string $str   String to go inside this element
 * @return string
 */
function em($str)
{
    return "<em>".$str."</em>";
}

/**
 * Outputs markup for an image element.
 * @param string $src               Image filepath or URI
 * @param string $img_attribs       Custom HTML attribute options array for the image itself
 * @param string $container_attribs Custom HTML attribute options array for the div container
 * @return string
 */
function img($src, $img_attribs = array(), $container_attribs = array())
{
    add_attrib($img_attribs, "src", $src);

    return div("<img".parse_attribs($img_attribs)." /></div>", $container_attribs);
}

/**
 * Outputs markup for text with escaped quotes added around it.
 * @param string $str   String to go inside this element
 * @return string
 */
function quotes($str)
{
    return "\"".$str."\"";
}

/**
 * Outputs markup for a span element.
 * @param string $contents  String to go inside this element
 * @param string $attribs   Custom HTML attribute options array
 * @return string
 */
function span($contents, $attribs = array())
{
    return "<span".parse_attribs($attribs).">".$contents."</span>";
}

/**
 * Outputs markup for a strong (bold) text element.
 * @param string $str   String to go inside this element
 * @return string
 */
function strong($str)
{
    return "<strong>".$str."</strong>";
}

/**
 * Outputs markup for a subscript element.
 * @param string $str   String to go inside this element
 * @return string
 */
function sub($str)
{
    return "<sub>".$str."</sub>";
}

/**
 * Outputs markup for a superscript element.
 * @param string $str   String to go inside this element
 * @return string
 */
function sup($str)
{
    return "<sup>".$str."</sup>";
}