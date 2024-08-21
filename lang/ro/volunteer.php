<?php

declare(strict_types=1);

return [

    'label' => [
        'singular' => 'Voluntar',
        'plural' => 'Voluntari',
    ],

    'column' => [
        'id' => 'ID',
        'name' => 'Nume',
        'phone' => 'Telefon',
        'email' => 'Email',
        'status' => 'Status',
        'project' => 'Proiect',
        'created_at' => 'Dată înscriere',
        'has_user' => 'Utilizator',
        'organization' => 'Organizație',
    ],

    'form' => [
        'name' => 'Nume',
        'phone' => 'Telefon',
        'email' => 'Email',
        'status' => 'Status',
        'project' => 'Proiect',
        'created_at' => 'Dată înscriere',
        'has_user' => 'Utilizator',
        'organization' => 'Organizație',
        'model_type' => 'Voluntar pe:',
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
    'filters' => [
        'status' => 'Status',
        'has_user' => 'Este utilizator inregistrat',
        'user' => 'Utilizator',

    ],

    'header' => 'Voluntari (:number)',
    'general_project' => 'Direct la ONG',
];
