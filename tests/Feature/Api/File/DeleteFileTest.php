<?php
declare(strict_types=1);

namespace Tests\Feature\Api\File;

use Tests\TestCase;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeleteFileTest extends TestCase
{
    use DatabaseTransactions;

    public function test_file_delete()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->postJson('/api/user/file/set', [
            'api_token' => $user->api_token,
            'file' => $file,
        ]);

        $fileModel = File::query()->latest()->first();

        $response = $this->postJson('/api/user/file/delete/' . $fileModel->id, [
            'api_token' => $user->api_token,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'File with ID:' . $fileModel->id . ' deleted',
        ]);

        \Storage::disk('public')->assertMissing($fileModel->getUrlPath());
    }

    public function test_delete_not_existing_file()
    {
        $user = factory(User::class)->create(['id' => 5]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/user/file/delete/' . 333, [
            'api_token' => $user->api_token,
        ]);

        $response->assertStatus(404);
    }

    public function test_delete_file_without_user_token()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/user/file/delete/' . 333);

        $response->assertStatus(401);
    }
}
