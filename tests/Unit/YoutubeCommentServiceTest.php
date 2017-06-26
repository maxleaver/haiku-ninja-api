<?php

namespace Tests\Unit;

use App\Services\YoutubeCommentService;

class YoutubeCommentServiceTest extends \PHPUnit_Framework_TestCase
{
    protected $service;
    protected $stub;

    public function setUp()
    {
        $this->stub = $this->createMock('Google_Service_YouTube');
        $this->stub->commentThreads = $this->createMock('Google_Service_YouTube_Resource_CommentThreads');

        $this->service = new YoutubeCommentService($this->stub);
    }

    /** @test */
    public function it_returns_an_empty_array_if_no_comments_found()
    {
        $results = $this->service->request('abc123');
        $this->assertInternalType('array', $results);
        $this->assertEmpty($results);
    }

    /** @test */
    public function it_returns_an_array_of_comments_when_given_a_typical_google_response()
    {
        $this->createMockResponse();

        $results = $this->service->request('abc123');

        $this->assertInstanceOf('App\Models\Comment', $results[0]);
        $this->assertEquals('Test text', $results[0]->getText());
        $this->assertEquals('John Doe', $results[0]->getAuthor());
        $this->assertEquals('http://www.example.com/image.jpg', $results[0]->getAuthorProfileImageUrl());
        $this->assertEquals('token_response', $this->service->getNextPageToken());
        $this->assertEquals(1, $this->service->getCommentsSearched());
    }

    /** @test */
    public function it_returns_a_next_page_token_after_a_request()
    {
        $this->createMockResponse();

        $results = $this->service->request('abc123');

        $this->assertEquals('token_response', $this->service->getNextPageToken());
    }

    /** @test */
    public function it_returns_a_count_of_comments_searches_after_a_request()
    {
        $this->createMockResponse();

        $results = $this->service->request('abc123');

        $this->assertEquals(1, $this->service->getCommentsSearched());
    }

    protected function createMockResponse()
    {
        $response = (object) array(
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

        $this->stub->commentThreads->expects($this->any())
            ->method('listCommentThreads')
            ->willReturn($response);
    }
}
