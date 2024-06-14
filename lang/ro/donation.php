<?php

declare(strict_types=1);

return [

    'label' => [
        'singular' => 'Donație',
        'plural' => 'Donații',
    ],

    'column' => [
        'created_at' => 'Data',
        'donor' => 'Donator',
        'project' => 'Proiect',
        'amount' => 'Sumă',
        'status' => 'Status',
    ],

    'labels' => [
        'id' => 'ID',
        'amount' => 'Suma donată',
        'project' => 'Proiect',
        'organization' => 'Organizație',
        'status' => 'Status',
        'created_at' => 'Data donației',
        'approved_at' => 'Data aprobării',
        'charged_date' => 'Data încasării',
        'in_championship' => 'Este înscrisă în Campionat',
        'has_user' => 'Este utilizator inregistrat',
        'full_name' => 'Donator',
        'email' => 'Email',
        'charge_date' => 'Data încasării',
        'count' => 'Numar donatii',
        'count_with_amount' => 'Numarul de dontatii :count ( :total RON)',
        'donors' => 'Donatori',
        'status_updated_at' => 'Data actualizării statusului',
    ],

    'statuses' => [
        'initialize' => 'Inițializată',
        'authorized' => 'Autorizată',
        'unauthorized' => 'Neautorizată',
        'canceled' => 'Anulată',
        'aborted' => 'Abandonată',
        'payment_declined' => 'Plata refuzată',
        'possible_fraud' => 'Posibil fraudulos',
        'charged' => 'Încasată',
    ],

    'header' => 'Donatii (:number)',

    'stats' => [
        'charged' => 'Donații încasate',
        'charged_amount' => 'Sumă încasată',
        'pending' => 'Donații în așteptare',
        'failed' => 'Donații eșuate',
    ],
];
