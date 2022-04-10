<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Article;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test create a new article.
     *
     * @return void
     */
    public function test_create_a_new_article()
    {
        //  Arrange
        $this->actingAs($user = User::factory()->create());

        //  Act
        $response = $this->post('/articles', [
            'title' => 'Test Article',
            'body' => 'This is a test article.',
        ]);

        //  Assert
        $this->assertTrue(Article::count() === 1);

        $article = Article::first();

        $this->assertEquals('Test Article', $article->title);
        $this->assertEquals('This is a test article.', $article->body);
    }

    /**
     * Test create a new article with random content.
     *
     * @return void
     */
    public function test_create_a_new_article_with_random_content()
    {
        $this->actingAs($user = User::factory()->create());

        $randomTitle = $this->faker->sentence;
        $randomBody = $this->faker->paragraph;

        $response = $this->post('/articles', [
            'title' => $randomTitle,
            'body' => $randomBody,
        ]);

        $this->assertTrue(Article::count() === 1);

        $article = Article::first();

        $this->assertEquals($randomTitle, $article->title);
        $this->assertEquals($randomBody, $article->body);
    }

    /**
     * Test article cannot be created without a title.
     *
     * @return void
     */
    public function test_article_cannot_be_created_without_a_title()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->post('/articles', [
            'body' => 'This is a test article.',
        ]);

        $this->assertTrue(Article::count() === 0);

        $response->assertSessionHasErrors('title');
    }

    /**
     * Test article cannot be created without a body.
     *
     * @return void
     */
    public function test_article_cannot_be_created_without_a_body()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->post('/articles', [
            'title' => 'This is a test article title.',
        ]);

        $this->assertTrue(Article::count() === 0);

        $response->assertSessionHasErrors('body');
    }

    /**
     * Test article cannot be created without a title.
     *
     * @return void
     */
    public function test_article_cannot_be_created_with_a_title_more_than_255_chars()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->post('/articles', [
            'title' => str_repeat('a', 256),
            'body' => 'This is a test article.',
        ]);

        $this->assertTrue(Article::count() === 0);

        $response->assertSessionHasErrors('title');
    }

    /**
     * Test article cannot be created with a title less than 3 chars.
     *
     * @return void
     */
    public function test_article_cannot_be_created_with_a_title_less_than_3_chars()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->post('/articles', [
            'title' => 'ab',
            'body' => 'This is a test article.',
        ]);

        $this->assertTrue(Article::count() === 0);

        $response->assertSessionHasErrors('title');
    }
}
