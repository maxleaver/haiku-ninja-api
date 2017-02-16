<?php

namespace Tests\Unit;

use App\Services\YoutubeCommentService;

class YoutubeCommentServiceTest extends \PHPUnit_Framework_TestCase
{
    protected $service;
    protected $stub;

    public function setUp()
    {
        $this->stub = $this
            ->getMockBuilder('App\Services\YoutubeClient')
            ->disableOriginalConstructor()
            ->setMethods(['comments'])
            ->getMock();

        $this->service = new YoutubeCommentService($this->stub);
    }

    /** @test */
    public function instantiates_correctly_given_dependencies()
    {
        $this->assertInstanceOf('App\Services\YoutubeCommentService', $this->service);
    }

    /** @test */
    public function sets_properties_when_given_a_typical_google_response()
    {
        $result = (object) array(
            'nextPageToken' => 'token_response',
            'items' => (object) array(
                (object) array(
                    'snippet' => (object) array(
                        'topLevelComment' => (object) array(
                            'snippet' => (object) array(
                                'textDisplay' => 'Test text',
                                'authorDisplayName' => 'John Doe',
                                'authorProfileImageUrl' => 'http://www.example.com/image.jpg'
                            )
                        )
                    )
                )
            )
        );

        $this->stub->method('comments')
             ->willReturn($result);

        $this->assertInstanceOf('App\Models\Comment', $this->service->fetchComments('id', 'token')[0]);
        $this->assertEquals('Test text', $this->service->getComments()[0]->getText());
        $this->assertEquals('John Doe', $this->service->getComments()[0]->getAuthor());
        $this->assertEquals('http://www.example.com/image.jpg', $this->service->getComments()[0]->getAuthorProfileImageUrl());
        $this->assertEquals('token_response', $this->service->getNextPageToken());
        $this->assertEquals(1, $this->service->getCommentsSearched());
    }

    /** @test */
    public function returns_empty_array_if_response_has_no_comments()
    {
        $result = array('test');

        $this->stub->method('comments')
             ->willReturn($result);

        $this->assertEquals(array(), $this->service->getComments('id', 'token'));
        $this->assertNull($this->service->getNextPageToken());
        $this->assertEquals(0, $this->service->getCommentsSearched());
    }
}
