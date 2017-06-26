<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Services\HaikuService;

class HaikuServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function converts_array_of_comments_to_haiku()
    {
        $comments = array(
            new Comment('this is not a haiku', 'John Doe', 'http://www.test.com'),
            new Comment(
                'This is a haiku. It should have five, seven, five syllables in it.',
                'John Doe',
                'http://www.test.com'
            )
        );

        $haiku = (new HaikuService())->getHaiku($comments);

        $this->assertEquals(1, count($haiku));
        $this->assertEquals('This is a haiku.', $haiku[0]->first);
        $this->assertEquals('It should have five, seven, five', $haiku[0]->second);
        $this->assertEquals('syllables in it.', $haiku[0]->third);
    }
}