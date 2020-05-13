<?php
declare(strict_types=1);

namespace Tests\Feature\Api\File;

use Tests\TestCase;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\Feature\Traits\FileDelete;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetFileTest extends TestCase
{
    use DatabaseTransactions, FileDelete;

    public function test_get_existing_file()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson('/api/user/file/set', [
            'api_token' => $user->api_token,
            'file' => $file,
        ]);

        $fileModel = File::latest()->first();

        $response = $this->get('/api/user/file/get/' . $fileModel->id . '?api_token=' . $user->api_token);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/jpeg');

        $this->assertFileExistAndDelete($fileModel);
    }

    public function test_get_not_existing_file()
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/user/file/get/' . '4444444' . '?api_token=' . $user->api_token);

        $response->assertStatus(404);
    }

    public function test_not_existing_user_token()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/user/file/get/' . '4444444' . '?api_token=test');

        $response->assertStatus(401);
    }
}
