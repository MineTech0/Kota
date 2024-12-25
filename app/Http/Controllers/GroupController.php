<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\GroupRequest;
use App\User;
use App\Utils\SeasonUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = Group::all();
        $groups->load('leaders');

        return view('group.index', ['groups' => $groups, 'canEdit' => $request->user()->hasPermissionTo('access_management'), 'ageGroups' => collect(config('kota.groups.ageGroups'))]);
    }

    public function edit(Group $group)
    {
        $group->load('leaders');

        return view('group.edit', [
            'group' => $group,
            'weekDays' => collect(config('kota.weekDays')),
            'ageGroups' => collect(config('kota.groups.ageGroups')),
            'users' => User::all()
        ]);
    }

    public function update(Group $group, GroupRequest $request)
    {
        $validated = $request->validated();

        try {
            // If the age group has been updated, create a new group with the updated age
            if ($validated['new_age']) {
                $this->handleNewAge($group, $validated);
                return response()->json(['message' => 'Ikäryhmä muutettu']);
            }

            $this->updateGroup($group, $validated);
            return response()->json(['message' => 'Ryhmä tallennettu']);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['message' => 'Ryhmän tallennus epäonnistui' ], 500);
        }
    }

    /**
     * Executes database transactions to replace an existing group with a newly created group
     * using updated age information, reassigning its leaders in the process.
     *
     * This method detaches all leaders from the old group, deletes it, then creates a new group
     * with the updated information before attaching the leaders to the new group.
     *
     * @param \App\Models\Group $group An existing group instance to be replaced.
     * @param array $validated Reference to the validated input data containing new group details.
     *
     * @return void
     *
     * @throws \Throwable If there is an error during the database transaction.
     */
    protected function handleNewAge($group, &$validated)
    {
        DB::transaction(function () use ($group, &$validated) {
            $group->leaders()->detach();
            $group->delete();

            $validated['age'] = $validated['new_age'];
            $newGroup = Group::create($validated);

            $newGroup->leaders()->attach(
                collect($validated['leaders'])->pluck('id')->toArray()
            );
        });
    }

    /**
     * Update the specified group with validated data and synchronize its leaders.
     *
     * The 'age' field is removed from the validated data before updating, and leaders are bound to the group 
     * based on the provided leader IDs. All changes are performed within a transactional context for consistency.
     *
     * @param  \App\Models\Group  $group     Instance of the group model to be updated
     * @param  array              $validated Reference to the validated data array
     * @return void
     */
    protected function updateGroup($group, &$validated)
    {
        unset($validated['age']);

        DB::transaction(function () use ($group, &$validated) {
            $group->update($validated);
            $group->leaders()->sync(
                collect($validated['leaders'])->pluck('id')->toArray()
            );
        });
    }

    public function destroy(Group $group)
    {
        try {
            DB::transaction(function () use ($group) {
                $group->leaders()->detach();
                $group->delete();
            });

            return response()->json([
                'message' => 'Ryhmä poistettu'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ryhmä poistaminen epäonnistui'
            ], 500);
        }
    }
    public function create()
    {
        return view('group.create', ['weekDays' => collect(config('kota.weekDays')), 'ageGroups' => collect(config('kota.groups.ageGroups')), 'users' => User::all()]);
    }
    public function store(GroupRequest $request)
    {
        $validated = $request->validated();

        $group = Group::create($validated);

        $group->leaders()->attach(collect($validated['leaders'])->map(function ($leader) {
            return $leader['id'];
        })->toArray());

        return response()->json([
            'message' => 'Uusi ryhmä luotu'
        ], 201);
    }
}
