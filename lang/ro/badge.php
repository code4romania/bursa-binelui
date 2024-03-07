<?php

declare(strict_types=1);

return [

    'title' => 'Titlu badge',
    'description' => 'Descriere badge',
    'image' => 'Imagine badge',
    'users_count' => 'Număr de utilizatori cu accest badge',
    'type' => 'Tip de badge',

    'donor_count' => ':count donatori cu accest badge',

    'action' => [
        'attach' => 'Alocă badge',
        'detach' => 'Elimină',
    ],

    'category' => [
        'title' => 'Categorie',
        'badges_count' => 'Număr de badge-uri',
        'labels' => [
            'singular' => 'Categorie de badge',
            'plural' => 'Categorii de badge',
        ],
    ],
    'filters' => [
        'has_badges' => 'Are badge-uri',
        'category' => 'Categorie',
        'has_users' => 'Are utilizatori alocati',
    ],

    'labels' => [
        'singular' => 'Badge',
        'plural' => 'Badge-uri',
    ],
    'types' => [
        'automated' => 'Automat',
        'manual' => 'Manual',
    ],

    'header' => [
        'badge' => 'Badge-uri (:number)',
        'category_badge' => 'Categorii de badge (:number)',
    ],

    'categories' => ['donations' => 'Donatiii',
        'volunteers' => 'Voluntariat',
        'sharing' => 'Sharing',
        'projects_ong' => 'Proiect ONG',
        'month_activity' => 'Activitate lunara',
    ],
];
