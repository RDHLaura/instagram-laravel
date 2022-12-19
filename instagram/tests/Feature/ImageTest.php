<?php
use function Pest\Laravel\{actingAs, get};
use App\Models\{Image, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);



beforeEach(function() {
    $user = User::factory()->create();
});

it('has author')->assertDatabaseHas('users', [
    'id' => 1,
]);

it('user not logged cannot access to images page', function ()
{
  get('/images')
    ->assertRedirect('/login');
});

it('user logged can access to images page', function ()
{
  actingAs(User::first())
    ->get('/images')
    ->assertStatus(200);
});

it('user logged can access to create image page', function ()
{
  actingAs(User::first())
    ->get('/images/create')
    ->assertStatus(200);
});

it('user logged can edit article', function ()
{
  $user = User::first();
  $image = Image::factory()->create();

  actingAs($user)
    ->put("/images/{$image->id}", [
      'description' => 'Images title updated',
    ])
    ->assertSessionHasNoErrors();
});


it('user logged can delete image', function ()
{
  $user = User::first();
  $image = $user->images()->create([
    'image_path' => Image::factory()->create()->image_path,
    'description' => "Nueva imagen",         
  ]);

  actingAs($user)
    ->delete("/images/{$image->id}")
    ->assertSessionHasNoErrors();
});