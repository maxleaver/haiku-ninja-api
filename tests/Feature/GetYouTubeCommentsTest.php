<?php

namespace Tests\Feature;

use Tests\Bootstrap\LocalWebTestCase;

class GetYouTubeCommentsTest extends LocalWebTestCase
{
    /** @test */
    public function a_user_can_request_youtube_video_comments()
    {
        $response = $this->client->get('/comments', $this->params(), $this->headers());
        $comments = json_decode($response, true);

        $this->assertEquals(200, $this->client->response->getStatusCode());
        $this->assertArrayHasKey('comments', $comments);
        $this->assertArrayHasKey('haiku', $comments);
        $this->assertArrayHasKey('nextPageToken', $comments);
        $this->assertArrayHasKey('commentsSearched', $comments);
    }

    /** @test */
    public function a_request_requires_an_id()
    {
        $this->client->get('/comments', $this->params(['id' => '']), $this->headers());
        $this->assertEquals(422, $this->client->response->getStatusCode());
    }

    /** @test */
    public function a_request_requires_a_type()
    {
        $this->client->get('/comments', $this->params(['type' => '']), $this->headers());
        $this->assertEquals(422, $this->client->response->getStatusCode());
    }

    protected function params($overrides = [])
    {
        return [
            'id' => isset($overrides['id']) ? $overrides['id'] : 'dQw4w9WgXcQ',
            'nextPageToken' => isset($overrides['nextPageToken']) ? $overrides['nextPageToken'] : null,
            'type' => isset($overrides['type']) ? $overrides['type'] : 'youtube'
        ];
    }

    protected function headers($overrides = [])
    {
        return array_merge(['Accept' => 'application/json'], $overrides);
    }
}
