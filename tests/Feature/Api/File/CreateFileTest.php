<?php
declare(strict_types=1);

namespace Tests\Feature\Api\File;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\Feature\Traits\FileDelete;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateFileTest extends TestCase
{
    use DatabaseTransactions, FileDelete;

    public function test_file_create()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson('/api/user/file/set', [
            'api_token' => $user->api_token,
            'file' => $file,
        ]);

        $fileModel = File::latest()->first();

        $response->assertJson([
            'id' => $fileModel->id,
        ]);

        $this->assertFileExistAndDelete($fileModel);
    }

    public function test_create_file_with_delete_date()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson('/api/user/file/set', [
            'api_token' => $user->api_token,
            'file' => $file,
            'delete_date' => Carbon::now()->addDays(1)->format('m/d/Y'),
        ]);

        $fileModel = File::latest()->first();

        $response->assertJson([
            'id' => $fileModel->id,
        ]);

        $this->assertFileExistAndDelete($fileModel);
    }

    public function test_create_file_with_user_comment()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson('/api/user/file/set', [
            'api_token' => $user->api_token,
            'file' => $file,
            'comment' => 'test',
        ]);

        $fileModel = File::latest()->first();

        $response->assertJson([
            'id' => $fileModel->id,
        ]);

        $this->assertFileExistAndDelete($fileModel);
    }

    public function test_create_file_with_user_comment_and_delete_date()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson('/api/user/file/set', [
            'api_token' => $user->api_token,
            'file' => $file,
            'delete_date' => Carbon::now()->addDays(1)->format('m/d/Y'),
            'comment' => 'test',
        ]);

        $fileModel = File::latest()->first();

        $response->assertJson([
            'id' => $fileModel->id,
        ]);

        $this->assertFileExistAndDelete($fileModel);
    }

    public function test_validate_file_size()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg')->size(5200);

        $response = $this->postJson('/api/user/file/set', [
            'api_token' => $user->api_token,
            'file' => $file,
        ]);

        $response->assertStatus(422);
    }

    public function test_validate_user_comment_length()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson('/api/user/file/set', [
            'api_token' => $user->api_token,
            'file' => $file,
            'comment' => str_repeat('t', 256),
        ]);

        $response->assertStatus(422);
    }

    public function test_validate_delete_date_format()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson('/api/user/file/set', [
            'api_token' => $user->api_token,
            'file' => $file,
            'delete_date' => 'test',
        ]);

        $response->assertStatus(422);
    }

    public function test_validate_delete_date_bigger_than_now()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson('/api/user/file/set', [
            'api_token' => $user->api_token,
            'file' => $file,
            'delete_date' => Carbon::now()->format('m/d/Y'),
        ]);

        $response->assertStatus(422);
    }
}
