<?php

namespace Tests\Feature;

use App\Group;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\RefreshTable;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    public function groupFormData()
    {
        return [
            'group_name' => 'Testiryhmä',
            'meeting_day' => 'Ma',
            'meeting_start' => '19:00',
            'meeting_end' => '20:00',
            'repeat' => 'Viikoittain',
            'age' => 'Sudenpennut, 1v',
            'leader_list' => ['Johtaja1','Johtaja2']
        ];
    }

    public function test_group_create_form_with_invalid_name_return_error()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('access_management');

        $group = $this->groupFormData();
        $group['group_name'] = 6;
        $response = $this
                    ->actingAs($user)
                    ->call('POST', 
                    route('store.group'), $group);
        $response->assertSessionHasErrors(['group_name']);
        
    }

}
