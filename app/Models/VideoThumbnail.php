<?php

namespace App\Models;

use JsonSerializable;

class VideoThumbnail implements JsonSerializable
{
    protected $id;
    protected $filename;
    protected $width;
    protected $height;

    public function __construct($id, $filename, $width, $height)
    {
        $this->id = $id;
        $this->filename = $filename;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Returns the url for the thumbnail
     * @return string URL
     */
    public function url()
    {
        return 'https://i.ytimg.com/vi/' . $this->id . '/' . $this->filename . '.jpg';
    }

    /**
     * Returns the thumbnail width
     * @return int Thumbnail width
     */
    public function width()
    {
        return $this->width;
    }

    /**
     * Returns the thumbnail height
     * @return int Thumbnail height
     */
    public function height()
    {
        return $this->height;
    }

    /**
     * Returns a json serializable representation of the object
     * @return array Json serializable representation of object
     */
    public function jsonSerialize()
    {
        return [
            'url' => $this->url(),
            'width' => $this->width(),
            'height' => $this->height()
        ];
    }
}
