<?php

namespace Tests\Unit;

use App\Services\YoutubeVideoService;

class YoutubeVideoServiceTest extends \PHPUnit_Framework_TestCase
{
    protected $stub;

    public function setUp()
    {
        $this->stub = $this->createMock('Google_Service_YouTube');
        $this->stub->search = $this->createMock('Google_Service_YouTube_Resource_Search');

        $this->stub->search->expects($this->any())
            ->method('listSearch')
            ->willReturn($this->mockResponse());
    }

    /** @test */
    public function it_can_perform_a_search()
    {
        $service = new YoutubeVideoService($this->stub);
        $results = $service->search('test');
        $this->assertEquals(2, count($results));
    }

    /** @test */
    public function a_search_requires_a_search_phrase()
    {
        $this->expectException('Exception');
        $this->makeService();
    }

    /** @test */
    public function it_has_video_search_results()
    {
        $service = $this->makeService('test');
        $this->assertEquals(2, count($service->getVideos()));
    }

    /** @test */
    public function it_has_a_count_of_total_search_results()
    {
        $service = $this->makeService('test');
        $this->assertEquals(100, $service->getTotalResults());
    }

    /** @test */
    public function it_has_a_count_of_results_per_page()
    {
        $service = $this->makeService('test');
        $this->assertEquals(25, $service->getResultsPerPage());
    }

    /** @test */
    public function it_has_a_next_page_token()
    {
        $service = $this->makeService('test');
        $this->assertEquals('CBkQAA', $service->getNextPageToken());
    }

    protected function makeService($phrase = null)
    {
        $service = new YoutubeVideoService($this->stub);
        $service->search($phrase);
        return $service;
    }

    protected function mockResponse()
    {
        return (object) array(
            "kind" => "youtube#searchListResponse",
            "etag" => "\"m2yskBQFythfE4irbTIeOgYYfBU/hwWtoBJVtEnD0eOLaC8lkC4Ptho\"",
            "nextPageToken" => "CBkQAA",
            "regionCode" => "US",
            "pageInfo" => (object) array(
                "totalResults" => 100,
                "resultsPerPage" => 25
            ),
            "items" => array(
                $this->mockVideo(),
                $this->mockVideo()
            )
        );
    }

    protected function mockVideo()
    {
        return (object) [
            "kind" => "youtube#searchResult",
            "etag" => "\"m2yskBQFythfE4irbTIeOgYYfBU/wTrwHzyOOdhChMNAMPPBqeheolM\"",
            "id" => (object) [
                "kind" => "youtube#video",
                "videoId" => "vk0F8dHo3wU"
            ],
            "snippet" => (object) [
                "publishedAt" => "2015-10-14T13:45:47.000Z",
                "channelId" => "UC-Zt7GPzlrPPQexkG9-shPg",
                "title" => "\"Pacific Dreams\" A California Surfing Film",
                "description" => "\"Pacific Dreams\" is a surfing movie featuring my 2015 footage shot around the beautiful state of California. Filmed & Edited by Jeff Chavolla ( http://www.",
                "thumbnails" => (object) [
                    "default" => (object) [
                        "url" => "https://i.ytimg.com/vi/vk0F8dHo3wU/default.jpg",
                        "width" => 120,
                        "height" => 90
                    ],
                    "medium" => (object) [
                        "url" => "https://i.ytimg.com/vi/vk0F8dHo3wU/mqdefault.jpg",
                        "width" => 320,
                        "height" => 180
                    ],
                    "high" => (object) [
                        "url" => "https://i.ytimg.com/vi/vk0F8dHo3wU/hqdefault.jpg",
                        "width" => 480,
                        "height" => 360
                    ]
                ],
                "channelTitle" => "Jeff Chavolla",
                "liveBroadcastContent" => "none"
            ]
        ];
    }
}
