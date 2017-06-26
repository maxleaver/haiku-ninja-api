<?php

namespace Tests\Unit;

use App\Services\CommentServiceFactory;
use App\Services\ICommentService;

class CommentServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_throws_an_exception_if_no_source_type_is_provided()
    {
        $this->expectException('App\Exceptions\InvalidCommentServiceException');
        (new CommentServiceFactory())->setService();
    }

    /** @test */
    public function it_throws_an_exception_if_an_invalid_comment_service_is_provided()
    {
        $this->expectException('App\Exceptions\InvalidCommentServiceException');
		(new CommentServiceFactory())->setService('bad_class_name');
    }

    /** @test */
    public function it_returns_a_valid_comment_service()
    {
		$this->assertInstanceOf(ICommentService::class, (new CommentServiceFactory())->setService('youtube'));
    }
}
