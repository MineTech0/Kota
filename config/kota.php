<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Kota omat config 
    |--------------------------------------------------------------------------
    |
    |
    */
    //Näkyy yläpalkissa Kota tekstin jälkeen
    'organization' => 'Piikkiön Tammipartio',
    'files' => [
        //Tiedostot välilehdellä olevien tiedostojen tyypit
        'categories' => array(
            'Ohje', 'Mallipohja', 'Asiakirja'
    )
    ],
    //Nettisivu julkaisujen tekemiseen
    'website' => [
        'url' => 'localhost:5000',
        'JwtToken' => ''
    ],

    //Tapahtumien ominaisuudet
    'events' => [
        'googleCalendarId' => 'Y2Q1ZWY1MTU0OTQwYWMyMDc1OTI1YjZjODE0MDNlMDczM2I2MjA0NzBhOWRhNmNhOGM2MDMzYWMyMjY3MDBiM0Bncm91cC5jYWxlbmRhci5nb29nbGUuY29t'
    ]

];
