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
        return Group::with('expenses')->get()->groupBy('age')->map(function ($group, $key) {
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
        })->values()->sortBy('age');
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