<?php

namespace Tests\Unit;

class CommentProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_has_an_id()
    {
        $provider = $this->makeProvider();
        $this->assertEquals('abc123', $provider->getId());
    }

    /** @test */
    public function it_has_a_next_page_token()
    {
        $provider = $this->makeProvider();
        $this->assertEquals('test_token', $provider->getNextPageToken());
    }

    /** @test */
    public function it_has_a_comments_searched_count()
    {
        $provider = $this->makeProvider();
        $this->assertEquals(5, $provider->getCommentsSearched());
    }

    /** @test */
    public function it_has_comments()
    {
        $provider = $this->makeProvider();
        $this->assertEquals(['one', 'two'], $provider->getComments());
    }

    protected function makeProvider($overrides = NULL)
    {
        $service = isset($overrides['service']) ? $overrides['service'] : $this->mockService();
        $id = isset($overrides['id']) ? $overrides['id'] : 'abc123';
        $type = isset($overrides['type']) ? $overrides['type'] : 'youtube';
        $nextPageToken = isset($overrides['nextPageToken']) ? $overrides['nextPageToken'] : NULL;

        return new \App\Models\CommentProvider($service, $id, $type, $nextPageToken);
    }

    protected function mockService()
    {
        $service = $this->createMock('\App\Services\YoutubeCommentService');

        $service->expects($this->any())
            ->method('request')
            ->willReturn([]);

        $service->expects($this->any())
            ->method('getComments')
            ->willReturn(['one', 'two']);

        $service->expects($this->any())
            ->method('getCommentsSearched')
            ->willReturn(5);

        $service->expects($this->any())
            ->method('getNextPageToken')
            ->willReturn('test_token');

        return $service;
    }
}
