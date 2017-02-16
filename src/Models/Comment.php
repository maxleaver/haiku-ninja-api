<?php

namespace App\Models;

use PhpHaiku\Haiku;

class Comment
{
    public $text;
    public $author;
    public $authorProfileImageUrl;
    protected $isHaiku = false;
    public $first;
    public $second;
    public $third;

    public function __construct($text, $author, $authorProfileImageUrl)
    {
        $this->setText($text);
        $this->setAuthor($author);
        $this->setAuthorProfileImageUrl($authorProfileImageUrl);
    }

    /**
     * Sets text property and triggers building of haiku-related properties
     * @param string $text Any text string
     */
    public function setText($text)
    {
        $this->text = $text;
        $this->buildHaiku();
    }

    /**
     * Returns original text
     * @return str Original text
     */
    public function getText() {
        return $this->text;
    }

    /**
     * Sets comment author name
     * @param string $author Author name
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * Returns author name
     * @return str Name of comment author
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Sets the URL for the comment authors profile image
     * @param str $url Author profile image URL
     */
    public function setAuthorProfileImageUrl($url)
    {

        $this->authorProfileImageUrl = filter_var($url, FILTER_VALIDATE_URL) ? $url : null;
    }

    /**
     * Returns URL for comment authors profile image
     * @return str Author profile image URL
     */
    public function getAuthorProfileImageUrl() {
        return $this->authorProfileImageUrl;
    }

    /**
     * Sets TRUE/FALSE value if comment is haiku
     * @param boolean $isHaiku Is comment a haiku?
     */
    protected function setIsHaiku($isHaiku)
    {
        $this->isHaiku = $isHaiku;
    }

    /**
     * Is the comment a haiku?
     * @return boolean Is comment a haiku?
     */
    public function isHaiku()
    {
        return $this->isHaiku;
    }

    /**
     * Set the first line of haiku (if comment can be haiku)
     * @param string $text First line of haiku
     */
    protected function setFirstLine($text)
    {
        $this->first = $text;
    }

    /**
     * Returns the first line of the haiku
     * @return string First line of haiku
     */
    public function getFirstLine()
    {
        return $this->first;
    }

    /**
     * Set the second line of haiku (if comment can be haiku)
     * @param string $text Second line of haiku
     */
    protected function setSecondLine($text)
    {
        $this->second = $text;
    }

    /**
     * Returns the second line of the haiku
     * @return string Second line of haiku
     */
    public function getSecondLine()
    {
        return $this->second;
    }

    /**
     * Set the third line of haiku (if comment can be haiku)
     * @param string $text Third line of haiku
     */
    protected function setThirdLine($text)
    {
        $this->third = $text;
    }

    /**
     * Returns the third line of the haiku
     * @return string Third line of haiku
     */
    public function getThirdLine()
    {
        return $this->third;
    }

    /**
     * Converts comment text to a haiku if possible
     */
    protected function buildHaiku()
    {
        $haiku = new Haiku();
        $haiku->setText($this->text);

        $this->setIsHaiku($haiku->isHaiku());

        if ($this->isHaiku()) {
            $this->setFirstLine($haiku->first);
            $this->setSecondLine($haiku->second);
            $this->setThirdLine($haiku->third);
        }
    }
}
