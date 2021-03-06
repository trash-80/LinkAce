<?php

namespace Tests\Controller\Guest;

use App\Models\Setting;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Setting::create([
            'key' => 'system_guest_access',
            'value' => '1',
        ]);
    }

    public function testValidTagDetailResponse(): void
    {
        factory(User::class)->create();

        $tag = factory(Tag::class)->create(['is_private' => false]);

        $response = $this->get('guest/tags/1');

        $response->assertOk()
            ->assertSee($tag->name);
    }

    public function testInvalidTagDetailResponse(): void
    {
        factory(User::class)->create();

        factory(Tag::class)->create(['is_private' => true]);

        $response = $this->get('guest/tags/1');

        $response->assertNotFound();
    }
}
