<?php

namespace Tests\Unit;

use App\Services;
use App\Services\HaikuServiceBuilder;

class HaikuServiceBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException Exception
     */
    public function throws_an_exception_on_invalid_comment_service_type()
    {
        $service = new HaikuServiceBuilder('some_invalid_type');
        $this->expectException(Exception::class);
    }

    /** @test */
    public function instantiates_haiku_service_on_valid_comment_service_type()
    {
        $service = new HaikuServiceBuilder('youtube');
        $this->assertInstanceOf('App\Services\HaikuService', $service->haiku);
    }
}
