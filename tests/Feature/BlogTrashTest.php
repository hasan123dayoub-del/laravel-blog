<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogTrashTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Blog $blog;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Laravel']);

        $this->actingAs($this->admin)->post(route('admin.blogs.store'), [
            'title' => 'First post',
            'content' => 'Hello',
            'image' => UploadedFile::fake()->create('cover.jpg', 100, 'image/jpeg'),
            'categories' => [$category->id],
        ])->assertRedirect(route('admin.blogs.index'));

        $this->blog = Blog::firstOrFail();
    }

    public function test_a_restored_post_keeps_its_image_and_categories(): void
    {
        $this->actingAs($this->admin)->delete(route('admin.blogs.destroy', $this->blog));
        $this->assertSoftDeleted($this->blog);

        $this->actingAs($this->admin)->post(route('admin.blogs.restore', $this->blog->id));

        $blog = $this->blog->fresh();
        $this->assertNull($blog->deleted_at);
        $this->assertCount(1, $blog->categories);
        Storage::disk('public')->assertExists('blogs/'.$blog->image);
    }

    public function test_force_delete_removes_the_post_and_its_image(): void
    {
        $this->actingAs($this->admin)->delete(route('admin.blogs.destroy', $this->blog));
        $this->actingAs($this->admin)->delete(route('admin.blogs.forceDelete', $this->blog->id));

        $this->assertDatabaseMissing('blogs', ['id' => $this->blog->id]);
        $this->assertDatabaseMissing('blog_category', ['blog_id' => $this->blog->id]);
        Storage::disk('public')->assertMissing('blogs/'.$this->blog->image);
    }

    public function test_only_the_author_can_delete_a_post(): void
    {
        $otherAdmin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($otherAdmin)->delete(route('admin.blogs.destroy', $this->blog));

        $this->assertNotSoftDeleted($this->blog);
    }
}
