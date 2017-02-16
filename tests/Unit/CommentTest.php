<?php

namespace Tests\Unit;

use App\Models\Comment;

class CommentTest extends \PHPUnit_Framework_TestCase
{
    private $comment;

    public function setUp()
    {
        $this->comment = new Comment('text', 'author', 'http://www.test.com/image.png');
    }

    /** @test */
    public function it_populates_fields_on_instantiation()
    {
        $this->assertEquals($this->comment->getText(), 'text');
        $this->assertEquals($this->comment->getAuthor(), 'author');
        $this->assertEquals($this->comment->getAuthorProfileImageUrl(), 'http://www.test.com/image.png');
        $this->assertFalse($this->comment->isHaiku());
    }

    /** @test */
    public function it_updates_text()
    {
        $this->comment->setText('something different');
        $this->assertEquals($this->comment->getText(), 'something different');
    }

    /** @test */
    public function gets_text()
    {
        $this->assertEquals($this->comment->getText(), 'text');
    }

    /** @test */
    public function it_updates_author()
    {
        $this->comment->setAuthor('John Doe');
        $this->assertEquals($this->comment->getAuthor(), 'John Doe');
    }

    /** @test */
    public function gets_author()
    {
        $this->assertEquals($this->comment->getAuthor(), 'author');
    }

    /** @test */
    public function it_updates_author_profile_image_url_if_given_a_valid_url()
    {
        $this->comment->setAuthorProfileImageUrl('http://www.example.com/image.jpg');
        $this->assertEquals($this->comment->getAuthorProfileImageUrl(), 'http://www.example.com/image.jpg');
    }

    /** @test */
    public function it_wont_update_author_profile_image_url_if_given_url_is_invalid()
    {
        $this->comment->setAuthorProfileImageUrl('bad url');
        $this->assertNull($this->comment->getAuthorProfileImageUrl());
    }

    /** @test */
    public function gets_author_profile_image_url()
    {
        $this->assertEquals($this->comment->getAuthorProfileImageUrl(), 'http://www.test.com/image.png');
    }

    /** @test */
    public function converts_text_to_haiku_if_possible()
    {
        $text = 'This is a comment with seventeen syllables that can be haiku.';
        $this->comment->setText($text);
        $this->assertTrue($this->comment->isHaiku());
        $this->assertEquals($this->comment->getFirstLine(), 'This is a comment');
        $this->assertEquals($this->comment->getSecondLine(), 'with seventeen syllables');
        $this->assertEquals($this->comment->getThirdLine(), 'that can be haiku.');
    }
}
