<?php

namespace App\Queries;

use App\Expense;
use App\Group;

class GroupExpenses
{
    public static function getAll()
    {
        return Group::with('expenses')->get();
    }

    /**
     * Return group with expenses between given dates
     */
    public static function getExpensesBetweenDates($startDate, $endDate)
    {

        return Expense::whereBetween('expense_date', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($expense) {
                // Map the parent age group to the corresponding key in the 'parentAgeGroups' array
                foreach (config('kota.groups.parentAgeGroups') as $key => $ageGroups) {
                    if (in_array($expense->original_age_group, $ageGroups)) {
                        return $key;
                    }
                }
                // If no matching parent age group is found, use a default key (e.g., 'Other')
                return 'Muut';
            })
            ->map(function ($expenses, $key) {
                $expenses = $expenses
                    ->groupBy(function ($expense) {
                        return $expense->original_group_name;
                    })
                    ->map(function ($expenses, $key) {
                        return [
                            'name' => $key,
                            'amount' => $expenses->reduce(function ($carry, $expense) {
                                return $carry + $expense->amount;
                            }, 0),
                            'expenses' => $expenses,
                        ];
                    })
                    ->sortBy('name')
                    ->values();
                return [
                    'age' => $key,
                    'expenses' => $expenses,
                    'amount' => round($expenses->reduce(function ($carry, $group) {
                        return $carry + $group['amount'];
                    }, 0),2),
                ];
            })
            ->sortBy('age')
            ->values();
    }
    /**
     * Return users groups with expenses between given dates
     * @param int $userId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * 
     */
    public static function getUserGroupsAndExpensesBetweenDates($userId, $startDate, $endDate)
    {
        return Group::whereHas('leaders', function ($query) use ($userId) {
            $query->where('user_id', $userId);
            })
            ->with(['expenses' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('expense_date', [$startDate, $endDate]);
            }])
            ->get();
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