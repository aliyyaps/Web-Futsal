<?php

namespace Tests\Unit;

use App\Models\Arena;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Support\Str;

class ArenaTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    //  READ
    public function test_show_index_page()
    {
        // setup
        Session::start();
        $user = User::find(1);

        // do something
        $this->be($user);
        $response = $this->get('/admin/arena');

        // assert
        $response->assertStatus(200); // Halaman berhasil di load
        $response->assertSeeText('Arena');
        $response->assertSeeText('No');
        $response->assertSeeText('Jenis Lapangan');
        $response->assertSeeText('Gambar');
        $response->assertSeeText('Harga');
        $response->assertSeeText('Action');
        $response->assertSeeText('New Arena');
    }

    public function test_show_create_page()
    {
        // setup
        Session::start();
        $user = User::find(1);

        // do something
        $this->be($user);
        $response = $this->get('/admin/arena/create');

        // assert
        $response->assertStatus(200); // Halaman berhasil di load
        $response->assertSeeText('create arena');
        $response->assertSeeText('Nama');
        $response->assertSeeText('Jenis Arena');
        $response->assertSeeText('Harga');
        $response->assertSeeText('Gambar');
        $response->assertSeeText('Submit');
        $response->assertSeeText('Go Back');
    }

    // CREATE
    public function test_create_new_arena()
    {
        // setup
        Session::start();
        $user = User::find(1);

        // do something
        $this->be($user);

        Storage::fake('arena');

        $file = UploadedFile::fake()->image('3.jpg');
        $response = $this->post('/admin/arena', [
            'nama' => 'Create Arena Name',
            'jenis_id' => 1,
            'price' => 65000,
            'image' => $file,
            '_token' => csrf_token(),
        ]);

        // assert
        $response->assertSessionHas('success', 'Arena Berhasil Ditambahkan');

        $response->assertRedirect('/admin/arena');
        $response->assertStatus(302);
    }

    public function test_show_edit_page()
    {
        // setup
        Session::start();
        $user = User::find(1);
        $arena = Arena::first();

        // do something
        $this->be($user);
        $response = $this->get('/admin/arena/' . $arena->id . '/edit');

        // assert
        $response->assertStatus(200); // Halaman berhasil di load
        $response->assertSeeText('create arena');
        $response->assertSeeText('Nama');
        $response->assertSeeText('Jenis Arena');
        $response->assertSeeText('Harga');
        $response->assertSeeText('Gambar');
        $response->assertSeeText('Save');
        $response->assertSeeText('Go Back');
    }

    public function test_name_required()
    {
        // setup
        Session::start();
        $user = User::find(1);

        // do something
        $this->be($user);

        Storage::fake('arena');

        $file = UploadedFile::fake()->image('5.jpg');
        $response = $this->post('/admin/arena', [
            'nama' => null,
            'jenis_id' => 2,
            'price' => 900000,
            'image' => $file,
            '_token' => csrf_token(),
        ]);

        // assert
        $response->assertSessionHasErrors(['nama']);
        $response->assertStatus(302);
    }

    public function test_jenis_required()
    {
        // setup
        Session::start();
        $user = User::find(1);

        // do something
        $this->be($user);

        Storage::fake('arena');

        $file = UploadedFile::fake()->image('4.jpg');
        $response = $this->post('/admin/arena', [
            'nama' => 'Testing Jenis Arena',
            'jenis_id' => null,
            'price' => 900000,
            'image' => $file,
            '_token' => csrf_token(),
        ]);

        // assert
        $response->assertSessionHasErrors(['jenis_id']);
        $response->assertStatus(302);
    }

    public function test_price_required()
    {
        // setup
        Session::start();
        $user = User::find(1);

        // do something
        $this->be($user);

        Storage::fake('arena');

        $file = UploadedFile::fake()->image('2.jpg');
        $response = $this->post('/admin/arena', [
            'nama' => 'Testing Arena Price',
            'jenis_id' => 2,
            'price' => null,
            'image' => $file,
            '_token' => csrf_token(),
        ]);

        // assert
        $response->assertSessionHasErrors(['price' => 'The price field is required.']);
        $response->assertStatus(302);
    }

    public function test_price_numeric()
    {
        // setup
        Session::start();
        $user = User::find(1);

        // do something
        $this->be($user);

        Storage::fake('arena');

        $file = UploadedFile::fake()->image('3.jpg');
        $response = $this->post('/admin/arena', [
            'nama' => 'Testing Arena Price Numeric',
            'jenis_id' => 2,
            'price' => 'ini harga',
            'image' => $file,
            '_token' => csrf_token(),
        ]);

        // assert
        $response->assertSessionHasErrors(['price' => 'The price must be a number.']);
        $response->assertStatus(302);
    }

    public function test_image_required()
    {
        // setup
        Session::start();
        $user = User::find(1);

        // do something
        $this->be($user);

        Storage::fake('arena');

        $response = $this->post('/admin/arena', [
            'nama' => 'Testing Arena Name',
            'jenis_id' => 2,
            'price' => 900000,
            'image' => null,
            '_token' => csrf_token(),
        ]);

        // assert
        $response->assertSessionHasErrors(['image']);
        $response->assertStatus(302);
    }

    public function test_image_file()
    {
        // setup
        Session::start();
        $user = User::find(1);

        // do something
        $this->be($user);

        Storage::fake('arena');

        $response = $this->post('/admin/arena', [
            'nama' => 'Testing Arena Name',
            'jenis_id' => 2,
            'price' => 900000,
            'image' => 12345,
            '_token' => csrf_token(),
        ]);

        // assert
        $response->assertSessionHasErrors(['image' => 'The image must be a file.']);
        $response->assertStatus(302);
    }

    // EDIT
    public function test_edit_new_arena()
    {
        // setup
        Session::start();
        $user = User::find(1);
        $arena = Arena::first();

        // do something
        $this->be($user);

        Storage::fake('arena');

        $file = UploadedFile::fake()->image('3.jpg');
        $response = $this->put('/admin/arena/' . $arena->id, [
            'nama' => 'Edited Arena',
            'jenis_id' => 1,
            'price' => 91291928,
            'image' => $file,
            '_token' => csrf_token(),
        ]);

        // assert
        $response->assertSessionHas('success', 'Arena Berhasil Diperbarui');

        $response->assertRedirect('/admin/arena');
        $response->assertStatus(302);
    }

    public function test_edit_name_required()
    {
        // setup
        Session::start();
        $user = User::find(1);
        $arena = Arena::first();

        // do something
        $this->be($user);

        Storage::fake('arena');

        $file = UploadedFile::fake()->image('2.jpg');
        $response = $this->put('/admin/arena/' . $arena->id, [
            'nama' => null,
            'jenis_id' => 1,
            'price' => 70000,
            'image' => $file,
            '_token' => csrf_token(),
        ]);

        // assert
        $response->assertSessionHasErrors(['nama']);
        $response->assertStatus(302);
    }

    public function test_edit_jenis_required()
    {
        // setup
        Session::start();
        $user = User::find(1);
        $arena = Arena::first();

        // do something
        $this->be($user);

        Storage::fake('arena');

        $file = UploadedFile::fake()->image('4.jpg');
        $response = $this->put('/admin/arena/' . $arena->id, [
            'nama' => 'Edited Jenis Arena',
            'jenis_id' => null,
            'price' => 70000,
            'image' => $file,
            '_token' => csrf_token(),
        ]);

        // assert
        $response->assertSessionHasErrors(['jenis_id']);
        $response->assertStatus(302);
    }

    public function test_edit_price_required()
    {
        // setup
        Session::start();
        $user = User::find(1);
        $arena = Arena::first();

        // do something
        $this->be($user);

        Storage::fake('arena');

        $file = UploadedFile::fake()->image('5.jpg');
        $response = $this->put('/admin/arena/' . $arena->id, [
            'nama' => 'Edited Arena Price',
            'jenis_id' => 1,
            'price' => null,
            'image' => $file,
            '_token' => csrf_token(),
        ]);

        // assert
        $response->assertSessionHasErrors(['price' => 'The price field is required.']);
        $response->assertStatus(302);
    }

    public function test_edit_price_numeric()
    {
        // setup
        Session::start();
        $user = User::find(1);
        $arena = Arena::first();

        // do something
        $this->be($user);

        Storage::fake('arena');

        $file = UploadedFile::fake()->image('1.jpg');
        $response = $this->put('/admin/arena/' . $arena->id, [
            'nama' => 'Edited Arena Name',
            'jenis_id' => 1,
            'price' => 'ini harga',
            'image' => $file,
            '_token' => csrf_token(),
        ]);

        // assert
        $response->assertSessionHasErrors(['price' => 'The price must be a number.']);
        $response->assertStatus(302);
    }

    public function test_edit_image_required()
    {
        // setup
        Session::start();
        $user = User::find(1);
        $arena = Arena::first();

        // do something
        $this->be($user);

        Storage::fake('arena');

        $file = UploadedFile::fake()->image('1.jpg');
        $response = $this->put('/admin/arena/' . $arena->id, [
            'nama' => 'Edited Arena Name',
            'jenis_id' => 1,
            'price' => 70000,
            'image' => null,
            '_token' => csrf_token(),
        ]);

        // assert
        $response->assertSessionHasErrors(['image']);
        $response->assertStatus(302);
    }

    public function test_delete_arena()
    {
        // setup
        Session::start();
        $user = User::find(1);
        $arena = Arena::first();

        // do something
        $this->be($user);

        $response = $this->delete('/admin/arena/' . $arena->id, [
            '_token' => csrf_token(),
        ]);

        // assert
        $response->assertRedirect('/admin/arena');
        $response->assertStatus(302);
    }
}
