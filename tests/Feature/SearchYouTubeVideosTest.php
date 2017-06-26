<?php

namespace Tests\Feature;

use Tests\Bootstrap\LocalWebTestCase;

class SearchYouTubeVideosTest extends LocalWebTestCase
{
    /** @test */
    public function a_user_can_search_youtube_videos()
    {
        $response = $this->client->get('/videos', ['q' => 'test'], $this->headers());
        $result = json_decode($response, true);

        $this->assertEquals(200, $this->client->response->getStatusCode());
        $this->assertArrayHasKey('items', $result);
        $this->assertArrayHasKey('totalResults', $result);
        $this->assertArrayHasKey('resultsPerPage', $result);
        $this->assertArrayHasKey('nextPageToken', $result);

        $this->assertArrayHasKey('id', $result['items'][0]);
        $this->assertArrayHasKey('title', $result['items'][0]);
        $this->assertArrayHasKey('description', $result['items'][0]);
        $this->assertArrayHasKey('thumbnails', $result['items'][0]);
    }

    /** @test */
    public function a_request_requires_search_terms()
    {
        $response = $this->client->get('/videos', ['q' => ''], $this->headers());
        $this->assertEquals(422, $this->client->response->getStatusCode());
    }

    protected function headers($overrides = [])
    {
        return array_merge(['Accept' => 'application/json'], $overrides);
    }
}
