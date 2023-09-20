<?php

declare(strict_types=1);

return [
    'roles' => [
        'superadmin' => 'Administrator Bursa Binelui',
        'supermanager' => 'Manager Bursa Binelui',
        'admin' => 'Administrator ONG',
        'manager' => 'Manager ONG',

        'donor' => 'Donator/Voluntar',
    ],

    'label' => [
        'singular' => 'Utilizator',
        'plural' => 'Utilizatori',
    ],
    'labels' => [
        'general_data' => 'Date generale',
        'volunteer_for_organization' => 'Voluntar in organizatie',
        'volunteer_for_project' => 'Proiect din organizatia: :organization',
    ],
    'relations' => [
        'donations' => 'Donatii',
        'volunteer' => 'Proiecte la care este voluntar',
        'badges' => 'Insigne',
        'heading' => [
            'donations' => 'Numarul de dontatii :count ( :total RON)',
            'volunteers' => 'Numarul de  proiecte in care este volunar: :count',
            'badges' => 'Numarul de insigne: :count',
        ],
    ],
    'name' => 'Nume',
    'email' => 'Email',
    'role' => 'Rol',
    'organization' => 'Organizație',
    'messages' => [
        'created' => 'Utilizatorul a fost adăugat.',
        'deleted' => 'Utilizatorul a fost șters.',
        'set_initial_password_success' => 'Parola a fost setată cu succes!',
    ],
    'filters' => [
        'type' => 'Tip',
        'placeholder' => 'Selectează tipul',
        'has_donations' => 'Are donații',
        'is_volunteer' => 'Este voluntar',
    ],

    'column' => [
        'name' => 'Nume',
        'email' => 'Email',
        'role' => 'Rol',
    ],
];
