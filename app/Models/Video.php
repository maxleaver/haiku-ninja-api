<?php

namespace App\Models;

use JsonSerializable;
use App\Models\VideoThumbnail;

class Video implements JsonSerializable
{
    protected $id;
    protected $title;
    protected $description;
    protected $thumbnails = [];

    public function __construct($id, $title, $description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;

        $this->setThumbnails();
    }

    /**
     * Returns the YouTube url for the video
     * @return string YouTube url
     */
    public function url()
    {
        return 'https://youtu.be/' . $this->id;
    }

    /**
     * Generates an array of YouTube thumbnails
     * @return array Array of VideoThumbnails
     */
    protected function setThumbnails()
    {
        $this->thumbnails = [
            'default' => new VideoThumbnail($this->id, 'default', 120, 90),
            'medium' => new VideoThumbnail($this->id, 'mqdefault', 320, 180),
            'high' => new VideoThumbnail($this->id, 'hqdefault', 480, 360)
        ];
    }

    /**
     * Returns an array of Video Thumbnails
     * @return array Array of Video Thumbnails
     */
    public function thumbnails()
    {
        return $this->thumbnails;
    }

    /**
     * Returns a json serializable representation of the object
     * @return array Json serializable representation of object
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url(),
            'thumbnails' => $this->thumbnails()
        ];
    }
}
