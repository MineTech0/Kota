<?php

namespace Tests\Feature;

use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupExpenseTest extends TestCase
{
    use RefreshDatabase;

    public $date;

    public function __construct()
    {
        parent::__construct();
        $this->date = now()->getTimestampMs();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_add_own_group_expense()
    {
        $leader = User::factory()->create();
        $leader->givePermissionTo('add_own_group_expense');
        $group = Group::factory()->create();
        $group->leaders()->attach($leader);

        $response = $this->actingAs($leader)
            ->post(route('group.expenses.store'), [
                'groupId' => $group->id,
                'amount' => 100,
                'description' => 'test',
                'expense_date' => $this->date
            ]);
        
        $response->assertSuccessful();
    }
    public function test_cannot_add_expense_without_permission()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('group.expenses.store'), [
                'groupId' => $group->id,
                'amount' => 100,
                'description' => 'test',
                'expense_date' => $this->date
            ]);
        
        $response->assertForbidden();
    }

    public function test_with_add_group_expense_permission_can_add_expense_to_any_group()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('add_group_expense');
        $group = Group::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('group.expenses.store'), [
                'groupId' => $group->id,
                'amount' => 100,
                'description' => 'test',
                'expense_date' => $this->date
            ]);
        
        $response->assertSuccessful();
    }

}
