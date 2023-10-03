<?php

declare(strict_types=1);

return [

    'label' => [
        'singular' => 'Voluntar',
        'plural' => 'Voluntarii',
    ],

    'column' => [
        'name' => 'Nume',
        'phone' => 'Telefon',
        'project' => 'Proiect',
        'created_at' => 'Dată înscriere',
        'has_user' => 'Utilizator',
    ],

    'statuses' => [
        'pending' => 'În așteptare',
        'approved' => 'Aprobat',
        'rejected' => 'Respins',
    ],

    'model' => 'Proiect',

    'messages' => [
        'approved' => 'Voluntarul a fost aprobat.',
        'rejected' => 'Voluntarul a fost respins.',
        'deleted' => 'Voluntarul a fost șters.',
    ],
];
