<?php

namespace Tests\Feature\Api\File;

use App\User;
use Tests\TestCase;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Tests\Feature\Traits\FileDelete;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetFileTest extends TestCase
{
    use RefreshDatabase, FileDelete;

    public function testGetExistingFile()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/file/set'), [
            'api_token' => $user->api_token,
            'file' => $file,
        ]);

        $this->assertDatabaseHas('files', [
            'id' => 1,
        ]);

        $fileModel = File::first();

        $response = $this->get($this->prepareUrlForRequest(
            '/api/user/file/get/' . $fileModel->id . '?api_token=' . $user->api_token
        ));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/jpeg');

        $this->assertFileExistAndDelete($fileModel);
    }

    public function testGetNotExistingFile()
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get($this->prepareUrlForRequest(
            '/api/user/file/get/' . '4444444' . '?api_token=' . $user->api_token
        ));

        $response->assertStatus(404);
    }

    public function testNotExistingUserToken()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get($this->prepareUrlForRequest(
            '/api/user/file/get/' . '4444444' . '?api_token=test'
        ));

        $response->assertStatus(401);
    }
}
