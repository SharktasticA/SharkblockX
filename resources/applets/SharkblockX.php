<?php

/*
    SharkblockX classes file.
    SharktasticA 2021
*/

/**
 * Enumation of SbXBlock derivatives that exist within the system.
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
abstract class SbXErrorTypes
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