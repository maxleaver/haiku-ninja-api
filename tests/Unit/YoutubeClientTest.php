<?php

namespace Tests\Unit;

use App\Services\YoutubeClient;

class YoutubeClientTest extends \PHPUnit_Framework_TestCase
{
    protected $obj;

    public function setUp()
    {
        $this->obj = new YoutubeClient();
    }

    /** @test */
    public function instantiates_correctly_given_dependencies()
    {
        $this->assertInstanceOf('Google_Service_YouTube', $this->obj->service);
    }
}
