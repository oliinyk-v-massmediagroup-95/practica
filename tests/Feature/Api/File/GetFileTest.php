<?php

namespace Tests\Feature\Api\File;

use App\Models\File;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class GetFileTest extends TestCase
{
    use RefreshDatabase;

    public function testGetExistingFile()
    {
        $user = factory(User::class)->create();

        $original_name = 'avatar.jpeg';
        $file = UploadedFile::fake()->image($original_name);
        $folder_on_disk = 'uploads/' . $user->id;
        $file_name = $file->hashName();

        \Storage::disk('public')->putFile($folder_on_disk, $file);

        $fileModel = factory(File::class)->create([
            'user_id' => $user->id,
            'ext' => 'jpeg',
            'original_name' => $original_name,
            'path' => $folder_on_disk . '/' . $file_name,
            'name' => $file_name
        ]);

        $response = $this->get($this->prepareUrlForRequest(
            '/api/user/file/get/' . $fileModel->id . "?api_token=" . $user->api_token
        ));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/jpeg');

        \Storage::disk('public')->delete($folder_on_disk . '/' . $file_name);
    }

    public function testGetNotExistingFile()
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get($this->prepareUrlForRequest(
            '/api/user/file/get/' . "4444444" . "?api_token=" . $user->api_token
        ));

        $response->assertStatus(404);
    }

    public function testNotExistingUserRequest()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get($this->prepareUrlForRequest(
            '/api/user/file/get/' . "4444444" . "?api_token=test"
        ));

        $response->assertStatus(401);
    }
}
