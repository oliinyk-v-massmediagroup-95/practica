<?php

namespace Tests\Feature\Api\File;

use App\User;
use Tests\TestCase;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteFileTest extends TestCase
{
    use RefreshDatabase;

    public function testFileDelete()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/file/set'), [
            'api_token' => $user->api_token,
            'file' => $file,
        ]);

        $this->assertDatabaseHas('files', [
            'deleted_at' => null,
        ]);

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/file/delete/1'), [
            'api_token' => $user->api_token,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'File with ID:' . 1 . ' deleted',
        ]);

        $fileModel = File::onlyTrashed()->first();
        $this->assertDatabaseMissing('files', [
            'deleted_at' => null,
        ]);

        $this->assertTrue(! is_file($fileModel->getFilePath()));
    }

    public function testDeleteNotExistingFile()
    {
        $user = factory(User::class)->create(['id' => 5]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post($this->prepareUrlForRequest('/api/user/file/delete/' . 333), [
            'api_token' => $user->api_token,
        ]);

        $response->assertStatus(404);
    }

    public function testDeleteFileWithoutUserToken()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post($this->prepareUrlForRequest('/api/user/file/delete/' . 333));

        $response->assertStatus(401);
    }
}
