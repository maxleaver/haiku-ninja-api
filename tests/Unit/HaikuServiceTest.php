<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Services\HaikuService;

class HaikuServiceTest extends \PHPUnit_Framework_TestCase
{
	protected $service;
    protected $stub;

    public function setUp()
    {
        $this->stub = $this
            ->getMockBuilder('App\Services\CommentService')
            ->disableOriginalConstructor()
            ->setMethods(['fetchComments', 'getComments', 'getNextPageToken', 'getCommentsSearched'])
            ->getMock();

        $this->service = new HaikuService($this->stub);
    }

    /** @test */
    public function instantiates_correctly_given_dependencies()
    {
        $this->assertInstanceOf('App\Services\HaikuService', $this->service);
    }

    /** @test */
    public function filters_only_comments_that_are_haiku()
    {
        $haiku = 'This is a sentence that is a valid haiku. Test it and find out.';
        $comment1 = new Comment('test comment', 'John Doe', 'http://www.example.com/image.jpg');
        $comment2 = new Comment($haiku, 'John Doe', 'http://www.example.com/image.jpg');

        $this->stub->method('fetchComments')
             ->willReturn(array($comment1, $comment2));

        $this->service->build('id', 'token');

        $this->assertEquals(array($comment2), $this->service->getHaiku());
    }
}