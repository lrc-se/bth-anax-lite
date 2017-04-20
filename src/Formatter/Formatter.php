<?php

namespace LRC\Formatter;

/**
 * Text formatter.
 */
class Formatter
{
    private $formatters = ['nl2br', 'link', 'strip', 'esc', 'slug', 'bbcode', 'markdown'];
    
    /**
     * Changes newlines to HTML line break tags.
     *
     * @param   string  $text   Input text.
     * @return  string          Formatted text.
     */
    public function nl2br($text)
    {
        return nl2br($text, false);
    }
    
    /**
     * Changes URLs to HTML anchor tags.
     *
     * @param   string  $text   Input text.
     * @return  string          Formatted text.
     */
    public function link($text)
    {
        return preg_replace('/\b((?<![href|src]=[\'"])https?:\/\/[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|\/)))/', '<a href="$1">$1</a>', $text);
    }
    
    /**
     * Strips HTML/XML tags.
     *
     * @param   string  $text   Input text.
     * @return  string          Formatted text.
     */
    public function strip($text)
    {
        return strip_tags($text);
    }
    
    /**
     * Escapes reserved HTML characters.
     *
     * @param   string  $text   Input text.
     * @return  string          Formatted text.
     */
    public function esc($text)
    {
        return htmlspecialchars($text);
    }
    
    /**
     * Slugifies text.
     *
     * @param   string  $text   Input text.
     * @return  string          Formatted text.
     */
    public function slug($text)
    {
        $text = strtr(mb_strtolower(trim($text)), ['å' => 'a', 'ä' => 'a', 'ö' => 'o']);
        return trim(preg_replace('/-+/', '-', preg_replace('/[^a-z0-9]+/', '-', $text)), '-');
    }
    
    /**
     * Renders a BBCode subset.
     *
     * @param   string  $text   Input text.
     * @return  string          Formatted text.
     */
    public function bbcode($text)
    {
        $search = [
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
            '/\[u\](.*?)\[\/u\]/is',
            '/\[img\](https?.+?)\[\/img\]/is',
            '/\[url\](https?.+?)\[\/url\]/is',
            '/\[url=(https?.+?)\](.+?)\[\/url\]/is'
        ];
        $replace = [
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<u>$1</u>',
            '<img src="$1" alt="">',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>'
        ];
        return preg_replace($search, $replace, $text);
    }
    
    /**
     * Renders Markdown.
     *
     * @param   string  $text   Input text.
     * @return  string          Formatted text.
     */
    public function markdown($text)
    {
        return \Michelf\Markdown::defaultTransform($text);
    }
    
    /**
     * Applies a list of registered formatting functions in order.
     *
     * @param   string          $text           Input text.
     * @param   string[]|string $formatters     An array or comma-separated string of formatting function names (nonexistent ones are skipped).
     * @return  string                          Formatted text.
     */
    public function apply($text, $formatters)
    {
        if (!is_array($formatters)) {
            $formatters = explode(',', $formatters);
        }
        foreach ($formatters as $formatter) {
            $formatter = trim($formatter);
            if (in_array($formatter, $this->formatters)) {
                $text = $this->{$formatter}($text);
            }
        }
        return $text;
    }
}
