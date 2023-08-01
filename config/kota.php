<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Kota omat config 
    |--------------------------------------------------------------------------
    |
    |
    */

    'lippukunta' => 'Piikkiön Tammipartio',

    //Kulujen kaudet
    'seasons' => [
       'kevät' => ['start' => '1.1.', 'end' => '31.5.'],
       'syksy' => ['start' => '1.6.', 'end' => '31.12.']
    ],

    /**
     * Mitkä ominaisuudet ovat käytössä
     */
    'show' => [
        'loans' => true,
        'kitchen_booking' => true,
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
            'Seikkailijat, 1v',
            'Seikkailijat, 2v',
            'Tarpojat, 1v',
            'Tarpojat, 2v',
            'Tarpojat, 3v',
            'Samoajat, 1v',
            'Samoajat, 2v',
            'Vaeltajat, 1v',
            'Vaeltajat, 2v',
            'Vaeltajat, 3v',
            'Vaeltajat, 4v',
        ],
        'parentAgeGroups' => [
            'Sudenpennut' => [
                'Sudenpennut, 1v', 
                'Sudenpennut, 2v'
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
                'Samoajat, 1v', 
                'Samoajat, 2v'
            ],
            'Vaeltajat' => [
                'Vaeltajat, 1v', 
                'Vaeltajat, 2v', 
                'Vaeltajat, 3v', 
                'Vaeltajat, 4v'
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
            'delete_user',
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
        'delete_user',
        'assign_delete_user_role',
        'return_own_loan',
        'see_own_group_expenses',
        'add_own_group_expense',
        'delete_edit_own_group_expense',
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
        ]

];