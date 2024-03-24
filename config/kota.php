<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Kota omat config 
    |--------------------------------------------------------------------------
    |
    |
    */

    'lippukunta' => env('KOTA_LIPPUKUNTA', ''),

    //Kulujen kaudet
    'seasons' => [
       'kevät' => ['start' => '1.1.', 'end' => '31.7.'],
       'syksy' => ['start' => '1.8.', 'end' => '31.12.']
    ],

    /**
     * Mitkä ominaisuudet ovat käytössä
     */
    'show' => [
        'loans' => env('SHOW_LOANS', false),
        'kitchen_booking' => env('SHOW_KITCHEN_BOOKING', false),
    ],

    'files' => [
        'categories' => array(
            'Ohje', 'Mallipohja', 'Asiakirja'
        )
    ],

    'weekDays' => ['Ma', 'Ti', 'Ke', 'To', 'Pe', 'La', 'Su'],

    'groups' => [
        'ageGroups' => [
            'Sudenpennut, 1v',
            'Sudenpennut, 2v',
            'Sudenpennut, 3v',
            'Seikkailijat, 1v',
            'Seikkailijat, 2v',
            'Tarpojat, 1v',
            'Tarpojat, 2v',
            'Tarpojat, 3v',
            'Samoajat',
            'Samoajat, 1v',
            'Samoajat, 2v',
            'Vaeltajat',
            'Vaeltajat, 1v',
            'Vaeltajat, 2v',
            'Vaeltajat, 3v',
            'Vaeltajat, 4v',
            'Aikuiset',
            'Perhepartio'
        ],
        'parentAgeGroups' => [
            'Sudenpennut' => [
                'Sudenpennut, 1v', 
                'Sudenpennut, 2v',
                'Sudenpennut, 3v',
            ],
            'Seikkailijat' => [
                'Seikkailijat, 1v', 
                'Seikkailijat, 2v'
            ],
            'Tarpojat' => [
                'Tarpojat, 1v', 
                'Tarpojat, 2v', 
                'Tarpojat, 3v'
            ],
            'Samoajat' => [
                'Samoajat', 
                'Samoajat, 1v', 
                'Samoajat, 2v'
            ],
            'Vaeltajat' => [
                'Vaeltajat', 
                'Vaeltajat, 1v', 
                'Vaeltajat, 2v', 
                'Vaeltajat, 3v', 
                'Vaeltajat, 4v'
            ],
            'Aikuiset' => [
                'Aikuiset'
            ],
            'Perhepartio' => [
                'Perhepartio'
            ],
        ],
    ],
    'expenses' => [
        'infos' => [
            'group' => [
                'Kulun päivämäärä pitää olla tämän vuoden puolella, vaikka kulu olisi viime vuodelta',
                'Pienin mahdollinen kulu on 0.10€',
            ]
        ]
    ],
    //All roles
    'roles' => [
        'management' => [
            'access_management',
            'see_equipment',
            'accept_loan',
            'return_loan',
            'add_edit_delete_equipment',
            'see_group_expenses',
            'add_group_expense',
            'delete_edit_group_expense',
            'edit_delete_user',
            'assign_delete_user_role',
            'see_budget',
            'edit_budget',
        ],
        'signatory' => [],
        'leader' => [
            'return_own_loan',
            'see_own_group_expenses',
            'add_own_group_expense',
            'delete_edit_own_group_expense',
        ],
        'logistics' => [
            'return_loan',
            'accept_loan',
            'add_edit_delete_equipment',
            'see_equipment',
        ],
    ],
    //All permissions
    'permissions' => [
        'access_management',
        'see_equipment',
        'accept_loan',
        'return_loan',
        'add_edit_delete_equipment',
        'see_group_expenses',
        'add_group_expense',
        'delete_edit_group_expense',
        'edit_delete_user',
        'assign_delete_user_role',
        'return_own_loan',
        'see_own_group_expenses',
        'add_own_group_expense',
        'delete_edit_own_group_expense',
        'see_budget',
        'edit_budget',
    ],

    'equipment' => [
        'formOptions' => [
            'Uusi',
            'Hyvä',
            'Kulunut',
            'Huono',
            'Rikki',
        ]
    ],
    'telescope_users' => [
        'niilo.kurki@hotmail.fi',
    ],
    'budget' => [
        'clubMoney' => [
            'categories' => [
                'Sudenpennut',
                'Seikkailijat',
                'Tarpojat',
                'Samoajat',
                'Vaeltajat',
                'Aikuiset',
                'Perhepartio',
            ]
        ]
    ]
    

];