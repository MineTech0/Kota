<?php
namespace App\Queries;

use App\Group;

class GroupExpenses
{
    public static function getAll()
    {
       return Group::with('expenses')->get();
        
    }

    public static function getAllExpensesByAge()
    {
        return Group::with('expenses')
        ->get()
        ->groupBy(function ($group) {
            // Map the parent age group to the corresponding key in the 'parentAgeGroups' array
            foreach (config('kota.groups.parentAgeGroups') as $key => $ageGroups) {
                if (in_array($group->age, $ageGroups)) {
                    return $key;
                }
            }
            // If no matching parent age group is found, use a default key (e.g., 'Other')
            return 'Muut';
        })
        ->map(function ($group, $key) {
            $group = $group->map(function ($group) {
                return [
                    'id' => $group->id,
                    'name' => $group->name,
                    'amount' => $group->expenses->reduce(function ($carry, $expense) {
                        return $carry + $expense->amount;
                    }, 0),
                    'expenses' => $group->expenses,
                ];
            });
            return [
                'age' => $key,
                'expenses' => $group,
                'amount' => $group->reduce(function ($carry, $group) {
                    return $carry + $group['amount'];
                }, 0)
            ];
        })
        ->sortBy('age')
        ->values();
    
    }

}



// [
//     {
//         groupid,
//         groupName
//         expenses: [
//             {
//                 id
//                 amount,
//                 date,
//                 desc,

//             }
//         ]
//     }
// ]