<?php

namespace Tests\Unit;

use App\Models\VideoThumbnail;

class VideoThumbnailTest extends \PHPUnit_Framework_TestCase
{
    private $thumbnail;

    public function setUp()
    {
        $this->thumbnail = new VideoThumbnail('abc123', 'filename', 100, 50);
    }

    /** @test */
    public function it_has_a_url()
    {
        $this->assertEquals('https://i.ytimg.com/vi/abc123/filename.jpg', $this->thumbnail->url());
    }

    /** @test */
    public function it_has_a_width()
    {
        $this->assertEquals(100, $this->thumbnail->width());
    }

    /** @test */
    public function it_has_a_height()
    {
        $this->assertEquals(50, $this->thumbnail->height());
    }

    /** @test */
    public function it_is_json_serializable()
    {
        $expected = json_encode([
            'url' => 'https://i.ytimg.com/vi/abc123/filename.jpg',
            'width' => 100,
            'height' => 50
        ]);

        $this->assertEquals($expected, json_encode($this->thumbnail));
    }
}
