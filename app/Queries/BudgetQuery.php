<?php

namespace App\Queries;

use App\ClubMoney;
use App\Group;

class BudgetQuery
{

    public static function getClubMoneyForOneSeasonByAgeGroup()
    {
        $ageGroupMemberCount = Group::all()
        ->groupBy(function ($group) {
            return $group->parent_age_group;
        })->map(function ($group) {
            return $group->reduce(function ($carry, $group) {
                return $carry + $group->member_count;
            }, 0);
        });

        return ClubMoney::all()
            ->map(function ($clubMoney) use ($ageGroupMemberCount) {
                if($ageGroupMemberCount->has($clubMoney->age_group))
                {
                    $memberCount = $ageGroupMemberCount[$clubMoney->age_group];
                    return [
                        'parentAgeGroup' => $clubMoney->age_group ,
                        'clubMoneyBudget' => round(($clubMoney->amount * $memberCount) / 2,2),
                    ];
                }
                else {
                    return [
                        'parentAgeGroup' => $clubMoney->age_group,
                        'clubMoneyBudget' => 0,
                    ];
                }
            })
            ->values();
    }
    /**
     * Return club money for current season
     */
    public static function getThisSeasonClubMoney() {
        $clubMoney = ClubMoney::all();
        // Divide club money by 2 because it is for 2 seasons
        $clubMoney->map(function ($clubMoney) {
            $clubMoney->amount = $clubMoney->amount / 2;
            return $clubMoney;
        });
        return $clubMoney;
    }
}
