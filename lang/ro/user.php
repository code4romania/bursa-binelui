<?php

declare(strict_types=1);

return [
    'roles' => [
        'superadmin' => 'Administrator Bursa Binelui',
        'supermanager' => 'Manager Bursa Binelui',
        'admin' => 'Administrator ONG',
        'manager' => 'Manager ONG',
        'user' => 'Donator/Voluntar',
    ],

    'label' => [
        'singular' => 'Utilizator',
        'plural' => 'Utilizatori',
    ],
    'labels' => [
        'general_data' => 'Date generale',
        'volunteer_for_organization' => 'Voluntar in organizatie',
        'volunteer_for_project' => 'Proiect din organizatia: :organization',
        'organization' => 'Organizatie',
        'name' => 'Nume',
        'email' => 'Email',
        'role' => 'Rol',
        'status' => 'Status',
        'status_display' => [
            'verified' => 'Verificat',
            'unverified' => 'Ne verificat',
        ],
        'created_at' => 'Creat la',
        'newsletter_subscription' => 'Abonat la newsletter',
        'referrer' => 'De unde a auzit de Bursa Binelui',
        'donations_sum' => 'Suma donata',
        'donations_count' => 'Numarul de donatii',
        'id' => 'ID',
        'last_donation_date' => 'Data ultimei donatii',
        'badges_count' => 'Numar de badge-uri',
        'volunteer_count' => 'Numar inscrieri voluntariat',
    ],
    'relations' => [
        'donations' => 'Donatii',
        'volunteer' => 'Proiecte la care este voluntar',
        'badges' => 'Insigne',
        'projects' => 'Proiecte la care este administrator',
        'heading' => [
            'donations' => 'Numarul de dontatii :count ( :total RON)',
            'volunteers' => 'Numarul de  proiecte in care este volunar: :count',
            'badges' => 'Numarul de insigne: :count',
            'projects' => 'Proiecte la care este administrator: :count',
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
        'password_updated_successfully' => 'Parola a fost actualizată cu succes!',
    ],
    'filters' => [
        'type' => 'Tip',
        'placeholder' => 'Selectează tipul',
        'has_donations' => 'Are donații',
        'is_volunteer' => 'Este voluntar',
        'has_verified_email' => 'Are email verificat',
    ],

    'column' => [
        'name' => 'Nume',
        'email' => 'Email',
        'role' => 'Rol',
    ],

    'action' => [
        'attach' => 'Alocă utilizator',
        'detach' => 'Elimină',
        'toggle' => 'Schimbă statusul',
        'errorSubscribingToNewsletter' => 'Eroare la abonare',
    ],
    'header' => 'Utilizatori (:number)',
    'toggle_modal' => [
        'heading' => 'Schimba statusul utilizatorului :name',
        'subheading' => [
            'active' => 'Activează utilizatorul :name',
            'deactivate' => 'Dezactivează utilizatorul :name',
        ],
        'actions' => [
            'active' => 'Activează',
            'deactivate' => 'Dezactivează',
        ],
    ],
];
