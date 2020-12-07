<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostsTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }


        /** @test */
        public function a_list_of_posts_can_be_retrieved() 
        {
            $post = Post::factory()->create();

            $response = $this->get('/api/');

            $response->assertJsonCount(1)
                ->assertJson([
                    'data' => [
                        [
                            "data" => [
                                'post_id' => $post->id
                            ]
                        ]
                    ]
                ]);
            
        }

        /** @test */
        public function an_unauthenticated_user_should_be_redirected_to_login()
        {
            $response = $this->post('/api/posts', array_merge($this->data(), ['api_token' => '']));

            $response->assertRedirect('/login');
            $this->assertCount(0, Post::all());
        }

        /** @test */
        public function an_authenticated_user_can_add_a_post()
        {
            // $this->withoutExceptionHandling();
            
            $response = $this->post('/api/posts', $this->data());

            $post = Post::first();

            $this->assertEquals('Test title', $post->title);
            $this->assertEquals('Test description', $post->description);
            $this->assertEquals('storage/defaultPics/defaultArticle.jpeg', $post->image);
            $response->assertStatus(Response::HTTP_CREATED);
            $response->assertJson([
                'data' => [
                    'post_id' => $post->id,
                ],
                'links' => [
                    'self' => $post->path(),// Post Model Fn.
                ]
            ]);
        }


        /** @test */
        public function fields_are_required()
        {
            collect(['title', 'description', 'image'])
                ->each(function($field) {
                    $response = $this->post('/api/posts',
                        array_merge($this->data(), [$field => '']));

                    $response->assertSessionHasErrors($field);
                    $this->assertCount(0, Post::all());
                });
        }

        /** @test */
        public function a_post_can_be_retrieved() // guest
        {

            $post = Post::factory()->create();

            $response = $this->get('/api/posts/' . $post->id);

            $response->assertJson([
                'data' => [
                    'post_id' => $post->id,
                    'title' => $post->title,
                    'description' => $post->description,
                    'image' => $post->image,
                    'last_updated' => $post->updated_at->diffForHumans()
                ]
            ]);
        }


        /** @test */
        public function a_post_can_be_patched()
        {
            $post = Post::factory()->create(['user_id' => $this->user->id]);

            $response = $this->patch('/api/posts/' . $post->id, $this->data());
            
            $post = $post->fresh();

            $this->assertEquals('Test title', $post->title);
            $this->assertEquals('Test description', $post->description);
            $this->assertEquals('storage/defaultPics/defaultArticle.jpeg', $post->image);
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJson([
                'data' => [
                    'post_id' => $post->id
                ],
                'links' => [
                    'self' => $post->path(),
                ]
            ]);
        }


        /** @test */
        public function only_the_owner_of_the_post_can_patch_the_post()
        {
            $post = Post::factory()->create(['user_id' => $this->user->id]);

            $anotherUser = User::factory()->create();

            $response = $this->patch('/api/posts/' . $post->id, array_merge($this->data(), ['api_token' => $anotherUser->api_token]));

            $response->assertStatus(403);
        }


        /** @test */
        public function a_post_can_be_deleted()
        {
            // $this->withoutExceptionHandling();

            $post = Post::factory()->create(['user_id' => $this->user->id]);

            $response = $this->delete('/api/posts/' . $post->id, ['api_token' => $this->user->api_token]);

            $this->assertCount(0, Post::all());
            $response->assertStatus(Response::HTTP_NO_CONTENT);
        }

        /** @test */
        public function only_the_owner_can_delete_the_post()
        {
            $post = Post::factory()->create(['user_id' => $this->user->id]);

            $anotherUser = User::factory()->create();

            $response = $this->delete('/api/posts/' . $post->id, ['api_token' => $anotherUser->api_token]);

            $this->assertCount(1, Post::all());
            $response->assertStatus(Response::HTTP_FORBIDDEN);
        }



        private function data()
        {
            return [
                'title' => 'Test title',
                'description' => 'Test description',
                'image' => 'storage/defaultPics/defaultArticle.jpeg',
                'api_token' => $this->user->api_token,
            ];
        }
    
}
