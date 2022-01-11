<?php

/*
    SharkblockX Globals
    SharktasticA 2021-2022
*/

/**
 * The server's document root.
 */
$SRV_ROOT = $_SERVER["DOCUMENT_ROOT"]."/";

/**
 * The directory containing this application's CSS files.
 */
$CSS_ROOT = "resources/styles/";

/**
 * The directory containing this application's JavaScript
 * files.
 */
$JS_ROOT = "resources/scripts/";

/**
 * The placeholder image filepath used when a non-existent
 * image is found.
 */
$NO_IMG_PLACEHOLDER = "resources/images/misc/null.png";

/*------------------------------------------------------------------------------------------------*/

/*
    Enumerations to use throughout SharkblockX.
    SharktasticA 2021-2022
*/

/**
 * Enumeration of possible HTML document types to select.
 */
abstract class DocType
{
    const HTML401Strict = 0;
    const HTML401Transitional = 1;
    const HTML5 = 2;
}

/**
 * Enumeration of SbXBlock derivatives that exist within the system.
 */
abstract class SbXBlockType
{
    const Normal = 0;
    const Links = 1;
    const List = 2;
    const Table = 3;
    const Start = 4;
    const Footer = 5;
    const Form = 7;
    const NumList = 8;
    const Gallery = 9;
    const Buttons = 10;
    const Selection = 11;
    const InfoWall = 12;
}

/**
 * Enumeration of errors that can be thrown within the system.
 */
abstract class SbXErrorType
{
    /**
     * Flags that an array is being accessed with an index value
     * that is outside of a range of 0 to n.
     */
    const OutOfBounds = 0;

    /**
     * Flags that an array is being accessed when it is completely
     * empty.
     */
    const ArrayEmpty = 1;

    /**
     * Flags that a specific SbXBlock derivative's method is being called
     * whilst accessing a block of a different derivative.
     */
    const WrongBlockType = 2;
}

/**
 * Enumeration of possible alignment strategies used by some functions including figure and embed.
 */
abstract class SbXAlign
{
    const Left = 0;
    const Right = 1;
    const Center = 2;
}

/*------------------------------------------------------------------------------------------------*/

/*
    Helper function functions for use within SharkblockX and in general.
    SharktasticA 2021-2022
*/

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

/*------------------------------------------------------------------------------------------------*/

/*
    SharkblockX simple HTML wraps.
    SharktasticA 2021-2022
*/

/**
 * Outputs markup for an anchor/hyperlink element.
 * @param string $str       String to go inside this element
 * @param string $uri       Hyperlink or page anchor
 * @param array $attribs   Custom HTML attribute options array
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
 * @param bool $no_snippet  Flags if div should be wrapped in a data-nosnippet span
 * @param array $attribs   Custom HTML attribute options array
 * @return string
 */
function div($contents, $no_snippet = false, $attribs = array())
{
    if ($nosnippet) return "<span data-nosnippet><div".parse_attribs($attribs).">".$contents."</div></span>";
    else return "<div".parse_attribs($attribs).">".$contents."</div>";
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
 * @param array $img_attribs       Custom HTML attribute options array for the image itself
 * @param array $container_attribs Custom HTML attribute options array for the div container
 * @return string
 */
function img($src, $img_attribs = array(), $container_attribs = array())
{
    add_attrib($img_attribs, "src", $src);

    return div("<img".parse_attribs($img_attribs)." /></div>", $container_attribs);
}

/**
 * Outputs markup for an OpenSearch feature such as a search engine
 * spec for browsers to find.
 * @param string $title     Title for OpenSearch spec
 * @param string $href      Hyperlink for OpenSearch spec
 * @param array $attribs    Custom HTML attribute options array
 * @return string
 */
function opensearch_desc($title, $href, $attribs = array())
{
    add_attrib($attribs, "title", $title);
    add_attrib($attribs, "href", $href);
    add_attrib($attribs, "data-react-helmet", "true");
    add_attrib($attribs, "rel", "search");
    add_attrib($attribs, "type", "application/opensearchdescription+xml");

    return "<link".parse_attribs($attribs).">";
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
 * @param array $attribs   Custom HTML attribute options array
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

/*------------------------------------------------------------------------------------------------*/

/*
    SharkblockX complex HTML wraps.
    SharktasticA 2021-2022
*/

/**
 * Declares the opening document tags (DOCTYPE and html tags).
 * @param string $contents  String to go inside this element
 * @param DocType $doctype  Doctype version to use
 * @param array $attribs    Custom HTML attribute options array
 * @return string
 */
function document($contents, $doctype = DocType::HTML5, $attribs = array())
{
    $doct = "<!DOCTYPE HTML>";
    if ($doctype == DocType::HTML401Strict) $doct = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
    else if ($doctype == DocType::HTML401Transitional) $doct = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';

    return $doct."<html".parse_attribs($attribs).">".$contents."</html>";
}

/**
 * Declares an external (to HTML/PHP page) JavaScript embed
 * @param string $src       JS filepath or URI
 * @param array $attribs    Custom HTML attribute options array
 * @return string
 */
function page_ext_script($src, $attribs = array())
{
    add_attrib($attribs, "src", $src);
    add_attrib($attribs, "type", "text/javascript");

    return "<script".parse_attribs($attribs)."></script>";
}

/**
 * Declares an external (to HTML/PHP page) CSS embed
 * @param string $src       CSS filepath or URI
 * @param bool $is_print    Flags if CSS should be a print stylesheet
 * @param array $attribs    Custom HTML attribute options array
 * @return string
 */
function page_ext_stylesheet($src, $is_print = false, $attribs = array())
{
    add_attrib($attribs, "src", $src);
    add_attrib($attribs, "type", "text/css");
    add_attrib($attribs, "rel", "stylesheet");
    if ($is_print) add_attrib($attribs, "media", "print");

    return "<link".parse_attribs($attribs)." />";
}

/**
 * Declares an internal stylesheet embed
 * @param string $contents  String to go inside this element
 * @param array $attribs    Custom HTML attribute options array
 * @return string
 */
function page_int_script($contents, $attribs = array())
{
    add_attrib($attribs, "type", "text/javascript");

    return "<script".parse_attribs($attribs).">".$contents."</script>";
}

/**
 * Declares an internal JavaScript embed
 * @param string $contents  String to go inside this element
 * @param array $attribs    Custom HTML attribute options array
 * @return string
 */
function page_int_styles($contents, $attribs = array())
{
    return "<style".parse_attribs($attribs).">".$contents."</style>"; 
}

/*------------------------------------------------------------------------------------------------*/

/*
    SharkblockX classes.
    SharktasticA 2021-2022
*/

/**
 * Base class for other block types that are enumerated in SbXBlockTypes.
 * These blocks contain the 'goodness' that can exist within a page.
 */
class SbXBlock
{
    /**
     * Parent block processor.
     * @var SbXProcessor
     */
    protected $parent;

    /**
     * Enumerated block type.
     * @var SbXBlockType
     */
    protected $type;

    /**
     * Characterised block type.
     * @var string
     */
    protected $type_str;

    /**
     * Flags whether this block is the terminus (last in parent SbXProcessor).
     * @var bool
     */
    protected $is_end;

    /**
     * Block's declaration markup.
     * @var string
     */
    protected $opening;

    /**
     * Block's termination markup.
     * @var string
     */
    protected $ending;

    /**
     * Block's 'goodness' markup.
     * @var string
     */
    protected $content;

    public function __construct($parent, $type)
    {
        $this->parent = $parent;
        $this->type = $type;

        // Always set this as false on creating - it should be changed
        // elsewhere!
        $this->is_end = false;

        // Completes the string version of the SbXBlockTypes enum
        if ($type == SbXBlockType::Normal)
            $this->type_str = "SbXNormalBlock";
        else if ($type == SbXBlockType::Links)
            $this->type_str = "SbXLinksBlock";
        else if ($type == SbXBlockType::List)
            $this->type_str = "SbXListBlock";
        else if ($type == SbXBlockType::Table)
            $this->type_str = "SbXTableBlock";
        else if ($type == SbXBlockType::Start)
            $this->type_str = "SbXStartBlock";
        else if ($type == SbXBlockType::Footer)
            $this->type_str = "SbXFooterBlock";
        else if ($type == SbXBlockType::Form)
            $this->type_str = "SbXFormBlock";
        else if ($type == SbXBlockType::NumList)
            $this->type_str = "SbXNumListBlock";
        else if ($type == SbXBlockType::Gallery)
            $this->type_str = "SbXGalleryBlock";
        else if ($type == SbXBlockType::Buttons)
            $this->type_str = "SbXButtonsBlock";
        else if ($type == SbXBlockType::Selection)
            $this->type_str = "SbXSelectionBlock";
        else if ($type == SbXBlockType::InfoWall)
            $this->type_str = "SbXInfoWallBlock";
    }

    /**
     * Allows the content assembly of this block to
     * be modified in derivatives.
     * @return string
     */
    protected function build_customisation()
    {
        return $this->content;
    }

    /**
     * Concats and returns complete markup for
     * this block.
     * @return string
     */
    public function build()
    {
        $cust = $this->build_customisation();
        if ($cust == "") return "";

        $markup = "";
        $markup.= $this->opening;
        $markup.= $cust;
        $markup.= $this->ending;
        $markup = str_replace(' & ', ' &amp; ', $markup);
        return $markup;
    }

    /**
     * Returns block's type as enumeration.
     * @return SbXBlockType
     */
    public function get_type()
    {
        return $this->type;
    }

    /**
     * Returns block's type as string.
     * @return string
     */
    public function get_type_str()
    {
        return $this->type_str;
    }

    /**
     * Adds some custom HTML markup to block's content.
     * For: all SbXBlock derivatives
     * @param string $markup    Code to add to block's content
     * @param bool $del_ws      Removes whitespace from the given markup
     */
    public function custom_markup($markup, $del_ws = false)
    {
        if ($del_ws) $this->content.= str_replace(array("\r", "\n", "  "), "", $markup);
        else $this->content.= $markup;
    }
}