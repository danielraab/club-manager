<?php

namespace Feature\Sponsoring;

use App\Livewire\Members\MemberCreate;
use App\Livewire\Sponsoring\PeriodCreate;
use App\Models\Member;
use App\Models\Sponsoring\Period;
use Database\Seeders\Minimal\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PeriodTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_sponsoring_pages(): void
    {
        $this->userSeedAndLogin();

        $response = $this->get('/sponsoring');
        $response->assertStatus(200);
        $response->assertSeeText('no periods');

        $response = $this->get('/sponsoring/backer');
        $response->assertStatus(200);
        $response->assertSeeText('no backers');

        $response = $this->get('/sponsoring/adOption');
        $response->assertStatus(200);
        $response->assertSeeText('no ad options');

        $response = $this->get('/sponsoring/package');
        $response->assertStatus(200);
        $response->assertSeeText('no packages');
    }

    public function test_only_period_exists(): void
    {
        $this->userSeedAndLogin();

        Livewire::test(PeriodCreate::class)
            ->set('periodForm.title', 'this year')
            ->set('periodForm.start', now()->startOfYear())
            ->set('periodForm.end', now()->endOfYear())
            ->call('savePeriod');

        $this->assertEquals(1, Period::query()->count());

        $response = $this->get('/sponsoring');
        $response->assertStatus(200);

        $response = $this->get('/sponsoring/period/adOption/1');
        $response->assertStatus(200);
        $response->assertSeeText('no ad options');

        $response = $this->get('/sponsoring/period/backer/1');
        $response->assertStatus(200);
        $response->assertSeeText('no backers');

        $response = $this->get('/sponsoring/period/1/memberAssignment');
        $response->assertStatus(200);
        $response->assertSeeText('no members');

        Livewire::test(MemberCreate::class)
            ->set('memberForm.firstname', 'Max')
            ->set('memberForm.lastname', 'Mustermannm')
            ->set('memberForm.entrance_date', now()->startOfYear())
            ->call('saveMember');

        $this->assertEquals(1, Member::query()->count());

        $response = $this->get('/sponsoring/period/1/memberAssignment');
        $response->assertStatus(200);
    }

    private function userSeedAndLogin(): void
    {
        $this->seed(UserSeeder::class);

        $response = $this->post('/login', [
            'email' => UserSeeder::ADMIN_MAIL,
            'password' => UserSeeder::ADMIN_PASSWORD,
        ]);

        $this->assertAuthenticated();
    }
}
