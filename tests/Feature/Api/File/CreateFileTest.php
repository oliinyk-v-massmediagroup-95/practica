<?php

namespace Tests\Feature\Api\File;

use App\Models\File;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CreateFileTest extends TestCase
{
    use RefreshDatabase, FileDelete;

    public function testFileCreate()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/file/set'), [
            'api_token' => $user->api_token,
            'file' => $file
        ]);

        $response->assertJson([
            'id' => 1
        ]);

        $this->assertDatabaseHas('files', [
            'id' => 1,
        ]);

        $fileModel = File::first();

        $this->assertFileExistAndDelete($fileModel);
    }

    public function testCreateFileWithDeleteDate()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/file/set'), [
            'api_token' => $user->api_token,
            'file' => $file,
            'delete_date' => Carbon::now()->addDays(1)->format('m/d/Y'),
        ]);

        $response->assertJson([
            'id' => 1
        ]);

        $this->assertDatabaseHas('files', [
            'id' => 1,
        ]);

        $fileModel = File::first();
        $this->assertFileExistAndDelete($fileModel);
    }

    public function testCreateFileWithUserComment()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/file/set'), [
            'api_token' => $user->api_token,
            'file' => $file,
            'comment' => 'test'
        ]);

        $response->assertJson([
            'id' => 1
        ]);

        $this->assertDatabaseHas('files', [
            'id' => 1,
        ]);

        $fileModel = File::first();
        $this->assertFileExistAndDelete($fileModel);
    }

    public function testCreateFileWithUserCommentAndDeleteDate()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/file/set'), [
            'api_token' => $user->api_token,
            'file' => $file,
            'delete_date' => Carbon::now()->addDays(1)->format('m/d/Y'),
            'comment' => 'test'
        ]);

        $response->assertJson([
            'id' => 1
        ]);

        $this->assertDatabaseHas('files', [
            'id' => 1,
        ]);

        $fileModel = File::first();
        $this->assertFileExistAndDelete($fileModel);
    }

    public function testValidateFileSize()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg')->size(5200);

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/file/set'), [
            'api_token' => $user->api_token,
            'file' => $file
        ]);

        $response->assertStatus(422);
    }

    public function testValidateUserCommentLength()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/file/set'), [
            'api_token' => $user->api_token,
            'file' => $file,
            'comment' => str_repeat('t', 256),
        ]);

        $response->assertStatus(422);
    }

    public function testValidateDeleteDateFormat()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/file/set'), [
            'api_token' => $user->api_token,
            'file' => $file,
            'delete_date' => 'test'
        ]);

        $response->assertStatus(422);
    }

    public function testValidateDeleteDateBiggerThanNow()
    {
        $user = factory(User::class)->create();
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson($this->prepareUrlForRequest('/api/user/file/set'), [
            'api_token' => $user->api_token,
            'file' => $file,
            'delete_date' => Carbon::now()->format('m/d/Y')
        ]);

        $response->assertStatus(422);
    }
}
