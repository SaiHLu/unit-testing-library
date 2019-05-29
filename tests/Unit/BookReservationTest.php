<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_added_to_the_library()
    {

        $this->withoutExceptionHandling();

        $response = $this->post('/books',
            [
                'title'=>'Cool Title',
                'author'=>'shl',
            ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());

    }

    /** @test */
    public function a_book_title_is_required()
    {
//        $this->withoutExceptionHandling();

        $response = $this->post('/books',
            [
                'title'=> '',
                'author'=>'shl'
            ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_book_author_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'Cool Title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->post('/books', [
            'title' => 'Cool Title',
            'author' => 'shl',
        ]);

        $book = Book::first();

        $response = $this->patch('/books/'.$book->id, [
           'title' => 'New Title',
           'author' => 'New Author'
        ]);

        $this->assertEquals("New Title", Book::first()->title);
        $this->assertEquals("New Author", Book::first()->author);
    }
}
