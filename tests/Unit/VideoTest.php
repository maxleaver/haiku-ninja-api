<?php

namespace Tests\Unit;

use App\Models\Video;

class VideoTest extends \PHPUnit_Framework_TestCase
{
    private $video;

    public function setUp()
    {
        $this->video = new Video('abc123', 'title', 'description');
    }

    /** @test */
    public function it_has_a_url()
    {
        $this->assertEquals('https://youtu.be/abc123', $this->video->url());
    }

    /** @test */
    public function it_has_thumbnails()
    {
        $this->assertArrayHasKey('default', $this->video->thumbnails());
        $this->assertArrayHasKey('medium', $this->video->thumbnails());
        $this->assertArrayHasKey('high', $this->video->thumbnails());
    }

    /** @test */
    public function it_is_json_serializable()
    {
        $expected = json_encode([
            'id' => 'abc123',
            'title' => 'title',
            'description' => 'description',
            'url' => 'https://youtu.be/abc123',
            'thumbnails' => [
                'default' => [
                    'url' => 'https://i.ytimg.com/vi/abc123/default.jpg',
                    'width' => 120,
                    'height' => 90
                ],
                'medium' => [
                    'url' => 'https://i.ytimg.com/vi/abc123/mqdefault.jpg',
                    'width' => 320,
                    'height' => 180
                ],
                'high' => [
                    'url' => 'https://i.ytimg.com/vi/abc123/hqdefault.jpg',
                    'width' => 480,
                    'height' => 360
                ]
            ]
        ]);

        $this->assertEquals($expected, json_encode($this->video));
    }
}
