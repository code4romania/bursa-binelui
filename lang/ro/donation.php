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
    ],

    'statuses' => [
        'initialize' => 'Inițializata',
        'authorized' => 'Autorizata',
        'unauthorized' => 'Neautorizata',
        'canceled' => 'Anulata',
        'aborted' => 'Abandonata',
        'payment_declined' => 'Plata refuzata',
        'possible_fraud' => 'Posibil fraudulos',
        'charged' => 'Incasata',
    ],

    'header' => 'Donatii (:number)',
];
