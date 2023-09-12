<?php

declare(strict_types=1);

return [
    'roles' => [
        'donor' => 'Donator/Voluntar',
        'ngo-admin' => 'Administrator ONG',
        'bb-manager' => 'Manager Bursa Binelui',
        'bb-admin' => 'Administrator Bursa Binelui',
    ],
    'label' => [
        'singular' => 'Utilizator',
        'plural' => 'Utilizatori', ],
    'labels' => [
        'general_data' => 'Date generale',
        'volunteer_for_organization' => 'Voluntar in organizatie',
        'volunteer_for_project' => 'Proiect din organizatia: :organization',
    ],
    'relations' => [
        'donations' => 'Donatii',
        'volunteer' => 'Proiecte la care este voluntar',
        'badges' => 'Insigne',
    ],
    'name' => 'Nume',
    'email' => 'Email',
    'role' => 'Rol',
    'organization' => 'Organizație',
    'messages' => [
        'set_initial_password_success' => 'Parola a fost setată cu succes!',
    ],
    'filters' => [
        'type' => 'Tip',
        'placeholder' => 'Selectează tipul',
        'has_donations' => 'Are donații',
        'is_volunteer' => 'Este voluntar',
    ],
];
