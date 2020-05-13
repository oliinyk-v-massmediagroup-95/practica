<?php
declare(strict_types=1);

namespace Tests\Feature\Api\Link;

use Tests\TestCase;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\Feature\Traits\FileDelete;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateLinkTest extends TestCase
{
    use DatabaseTransactions, FileDelete;

    public function test_create_multi_time_link()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson('/api/user/file/set', [
            'api_token' => $user->api_token,
            'file' => $file,
        ]);

        $fileModel = File::latest()->first();

        $response = $this->postJson('/api/user/link/create', [
            'api_token' => $user->api_token,
            'file_id' => $fileModel->id,
            'only_once' => 0,
        ]);

        $response->assertStatus(200);
        $url = json_decode($response->baseResponse->getContent());

        $response = $this->call('GET', $url->data->accessLink);
        $response->assertStatus(200);

        $response = $this->call('GET', $url->data->accessLink);
        $response->assertStatus(200);

        $this->assertFileExistAndDelete($fileModel);
    }

    public function test_create_one_time_link()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson('/api/user/file/set', [
            'api_token' => $user->api_token,
            'file' => $file,
        ]);

        $fileModel = File::latest()->first();
        $response = $this->postJson('/api/user/link/create', [
            'api_token' => $user->api_token,
            'file_id' => $fileModel->id,
            'only_once' => 1,
        ]);

        $response->assertStatus(200);
        $url = json_decode($response->baseResponse->getContent());

        $differentUser = factory(User::class)->create();

        $response = $this->actingAs($differentUser)->call('GET', $url->data->accessLink);
        $response->assertStatus(200);

        $response = $this->actingAs($differentUser)->call('GET', $url->data->accessLink);
        $response->assertStatus(404);

        $this->assertFileExistAndDelete($fileModel);
    }

    public function test_create_link_for_not_existing_file()
    {
        $user = factory(User::class)->create();
        $file = factory(File::class)->create(['user_id' => $user->id]);

        $response = $this->postJson('/api/user/link/create', [
            'api_token' => $user->api_token,
            'file_id' => 10000,
            'only_once' => 1,
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'File not found',
        ]);
    }

    public function test_create_link_for_other_user_file()
    {
        $user = factory(User::class)->create();
        $file = factory(File::class)->create(['user_id' => 100]);

        $response = $this->postJson('/api/user/link/create', [
            'api_token' => $user->api_token,
            'file_id' => $file->id,
            'only_once' => 1,
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'File not found',
        ]);
    }
}
