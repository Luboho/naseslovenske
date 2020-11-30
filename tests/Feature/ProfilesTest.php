<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Profile;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }


    /** @test */
    public function a_list_of_profiles_can_be_fetched_for_the_authenticated_user()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        
        $anotherUser = User::factory()->create();
        $anotherProfile = Profile::factory()->create(['user_id' => $anotherUser->id]);

        $response = $this->get('/api/profiles?api_token=' . $user->api_token);

        $response->assertJsonCount(1)
            ->assertJson([ 
                "data" => [ 
                    [
                        "data" => [
                            'profile_id' => $profile->id
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function an_unauthenticated_user_should_redirect_to_login() 
    {
       $response = $this->profile('/api/profiles', array_merge($this->data(), ['api_token' => '']));

       $response->assertRedirect('/login');
       $this->assertCount(0, Profile::all());

    }


    /** @test */
    public function an_authenticated_user_can_add_profile()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();

        $response = $this->profile('/api/profiles', $this->data());

        $profile = Profile::first();

        $this->assertEquals('Test Title', $profile->title);
        $this->assertEquals('Test text, Test text, Test text,', $profile->description);
        $this->assertEquals('storage/defaultPics/defaultArticle.jpg', $profile->image);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'profile_id' => $profile->id
            ],
            'links' => [
                'self' => $profile->path(),
            ]
        ]);
    }   

    /** @test */
    public function fields_are_required()
    {
        $this->withoutExceptionHandling();
        
        collect(['title', 'description', 'image'])
            ->each(function($field) {
                $response = $this->post('/api/profiles', array_merge($this->data(), [$field => '']));
                
                $response->assertSessionHasErrors($field);
                $this->assertCount(0, Profiles::all());
        });
    }

    /** @test */
    public function a_profile_can_be_retrieved()
    {
        $this->withoutExceptionHandling();
        $profile = Profile::factory()->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/profiles/' . $profile->id . '?api_token=' . $this->user->api_token);

        $response->assertJson([
            'data' => [
                'profile_id' => $profile->id,
                'title' => $profile->title,
                'description' => $profile->description,
                'image' => $profile->image,
                'last_updated' => $profile->updated_at->diffForHumans(), // Carbon instance method
            ]
        ]);
    }


    /** @test */
    public function only_the_users_profiles_can_be_retrieved()
    {
        $profile = Profile::factory()->create(['user_id' => $this->user->id]);

        $anotherUser = User::factory()->create();


        $response = $this->get('/api/profiles/' . $profile->id . '?api_token=' . $anotherUser->api_token);
        
        $response->assertStatus(403);
    }


    /** @test */
    public function a_profile_can_be_patched()
    {
        // $this->withoutExceptionHandling();

        $profile = Profile::factory()->create(['user_id' => $this->user->id]);

        $response = $this->patch('/api/profiles/' . $profile->id, $this->data());

        $profile = $profile->fresh();
        $this->assertEquals('Test Title', $profile->title);
        $this->assertEquals('Test text, Test text, Test text,', $profile->description);
        $this->assertEquals('storage/defaultPics/defaultArticle.jpeg', $profile->image);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'profile_id' => $profile->id,
            ],
            'links' => [
                'self' => $profile->path(),
            ]
        ]);
    }


    /** @test */
    public function only_the_owner_of_the_profile_can_patch_the_profile()
    {
        $profile = Profile::factory()->create();

        $anotherUser = User::factory()->create();


        $response = $this->patch('/api/profiles/' . $profile->id, array_merge($this->data(), ['api_token' => $anotherUser->api_token]));
        $response->assertStatus(403);
    }

    /** @test */
    public function a_profile_can_be_deleted()
    {
        $profile = Profile::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete('/api/profiles/' . $profile->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Profile::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        
    }

    /** @test */
    public function only_the_owner_can_delete_profile()
    {
        $profile = Profile::factory()->create();

        $anotherUser = User::factory()->create();

        $response = $this->delete('/api/profiles/' . $profile->id, ['api_token' => $this->user->api_token]);

        $response->assertStatus(403);
    }



    private function data()
    {
        return [
            'title' => 'Test Title',
            'description' => 'Test text, Test text, Test text,',
            'image' => 'storage/defaultPics/defaultArticle.jpeg',
            'api_token' => $this->user->api_token,
        ];
    }
}
