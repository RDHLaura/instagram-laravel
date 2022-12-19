<?php
use function Pest\Laravel\{actingAs, get};
use App\Models\{Image, User, Comment};
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);



beforeEach(function() {
    $user = User::factory()->create();
    $image = Image::factory()->create();
});

it('has author')->assertDatabaseHas('users', [
    'id' => 1,
]);


it('user logged can edit comment', function ()
{
  $user = User::first();
  $image = Image::first();
  $comment = Image::factory()->create();

  actingAs($user)
    ->put("/comment/{$comment->id}", [
      'content' => 'Comment content updated',
    ])
    ->assertSessionHasNoErrors();
});

it('user logged can delete comment', function ()
{
  $user = User::first();
  $image = Image::first();
  $comment = $user->comments()->create([
    
    'image_id' => $image->id,
    'content' => "Nuevo comentario",         
  ]);

  actingAs($user)
    ->delete("/comment/{$image->id}")
    ->assertSessionHasNoErrors();
});