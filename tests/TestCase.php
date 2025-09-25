<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use refreshDatabase;

    public User $user;

    public function loginAsUser(): User
    {
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        return $this->user;
    }
}
