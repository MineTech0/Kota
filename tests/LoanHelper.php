<?php

namespace Tests;

use App\Equipment;
use App\Loan;
use App\User;
use Carbon\Carbon;

use function PHPUnit\Framework\isNull;

class LoanHelper {

    public static function createLoan($user, bool $ownLoan) : Loan
    {
        $testEquipment  = Equipment::factory()->create();

        if(isNull($user))
        {
            $user = User::factory()->create();
        }

        return Loan::create([
          'user_id'=> $user->id,
          'desc'=> 'Desc',
          'reason'=> $ownLoan ? 'Omaan käyttöön' : 'Partio tapahtumaan',
          'loan_date'=> Carbon::today() ,
          'return_date'=>Carbon::today()->addDay(7) ,
          'quantity'=>$testEquipment->quantity ,
          'equipment_id'=> $testEquipment->id,
          'state'=> 1,
          ]);
    }
}
