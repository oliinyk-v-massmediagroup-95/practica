<?php

namespace Tests\Feature\Api\Link;

use App\Models\File;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\Feature\Api\File\FileDelete;
use Tests\TestCase;

class CreateLinkTest extends TestCase
{
    use RefreshDatabase, FileDelete;

    public function testCreateMultiTimeLink()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/file/set'), [
            'api_token' => $user->api_token,
            'file' => $file
        ]);

        $fileModel = File::first();

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/link/create'), [
            'api_token' => $user->api_token,
            'file_id' => $fileModel->id,
            'only_once' => 0
        ]);

        $response->assertStatus(200);
        $url = json_decode($response->baseResponse->getContent());

        $response = $this->call('GET', $url);
        $response->assertStatus(200);

        $response = $this->call('GET', $url);
        $response->assertStatus(200);

        $this->assertFileExistAndDelete($fileModel);
    }

    public function testCreateOneTimeLink()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/file/set'), [
            'api_token' => $user->api_token,
            'file' => $file
        ]);

        $fileModel = File::first();
        $response = $this->postJson($this->prepareUrlForRequest('/api/user/link/create'), [
            'api_token' => $user->api_token,
            'file_id' => $fileModel->id,
            'only_once' => 1
        ]);

        $response->assertStatus(200);
        $url = json_decode($response->baseResponse->getContent());

        $response = $this->call('GET', $url);
        $response->assertStatus(200);

        $response = $this->call('GET', $url);
        $response->assertStatus(404);

        $this->assertFileExistAndDelete($fileModel);
    }

    public function testCreateLinkForNotExistingFile()
    {
        $user = factory(User::class)->create();
        $file = factory(File::class)->create(['user_id' => $user->id]);

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/link/create'), [
            'api_token' => $user->api_token,
            'file_id' => 10000,
            'only_once' => 1
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'File not found'
        ]);
    }

    public function testCreateLinkForOtherUserFile()
    {
        $user = factory(User::class)->create();
        $file = factory(File::class)->create(['user_id' => 100]);
        $response = $this->postJson($this->prepareUrlForRequest('/api/user/link/create'), [
            'api_token' => $user->api_token,
            'file_id' => $file->id,
            'only_once' => 1
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'File not found'
        ]);
    }
}
