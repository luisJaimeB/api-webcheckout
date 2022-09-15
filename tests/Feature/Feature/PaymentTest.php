<?php

namespace Tests\Feature\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function authorized_user_can_access_to_transaction_send()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->enabled()->create();

        $response = $this->actingAs($user)->get(route('payments.create'));

        $response->assertOk();
    }
}
