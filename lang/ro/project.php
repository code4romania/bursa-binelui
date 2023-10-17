<?php

declare(strict_types=1);

return [
    'filters' => [
        'status' => 'Status',
        'organization' => 'Organizație',
        'category' => 'Categorie',
        'counties' => 'Județe',
        'created_from' => 'Creată de la',
        'status_updated_at_from' => 'Status schimbat  de la',
        'created_until' => 'Creată până la',
        'status_updated_at_until' => 'Status schimbat pana la',
    ],
    'status_arr' => [
        'draft' => 'Draft',
        'pending' => 'În așteptare',
        'approved' => 'Aprobat',
        'rejected' => 'Dezactivat',
    ],
    'actions' => [
        'view' => 'Vezi',
        'edit' => 'Editează',
        'approve' => 'Aprobă',
        'reject' => 'Respinge',
    ],
    'categories' => [
        'education' => 'Educație',
        'health' => 'Sănătate',
        'social' => 'Social',
        'culture' => 'Cultură',
        'sports' => 'Sport',
        'environment' => 'Mediu',
        'infrastructure' => 'Infrastructură',
        'other' => 'Altele',
    ],
    'heading' => [
        'pending' => 'Proiecte in curs de aprobare (:number)',
        'pending_changes' => 'Proiecte cu modificări (:number)',
        'approved' => 'Proiecte aprobate (:number)',
        'rejected' => 'Proiecte refuzate (:number)',
    ],
    'label' => [
        'singular' => 'Proiect',
        'plural' => 'Proiecte',
    ],

    'labels' => [
        'id' => 'ID',
        'project' => 'Proiect',
        'category' => 'Categorie',
        'national' => 'Național',
        'target_budget' => 'Target',
        'created_at' => 'Data creării',
        'organization' => 'Organizație',
        'is_national' => 'Național',
        'counties' => 'Județe',
        'status' => 'Status',
        'start' => 'Data de începere donatii',
        'end' => 'Data de încheiere donatii',
        'name' => 'Nume',
        'description' => 'Descriere',
        'scope' => 'Scop',
        'beneficiaries' => 'Beneficiari',
        'reason_to_donate' => 'Motivul donației',
        'accepting_volunteers' => 'Acceptă voluntari',
        'accepting_comments' => 'Acceptă comentarii',
        'videos' => 'Video-uri',
        'external_links' => 'Link-uri externe',
        'status_updated_at' => 'Status schimbat la data',
        'preview_image' => 'Imagine de prezentare',
        'gallery' => 'Galerie',
        'visible_status' => 'Status in platforma public',

    ],
    'visible_status' => [
        'published' => 'Publicat',
        'archived' => 'Arhivat',
        'open' => 'Deschis',
        'close' => 'Închis',
        'starting_soon' => 'Începe în curând',
    ],
    'errors' => [
        'start_date_in_past' => 'Data de începere nu poate fi în trecut',
    ],

];
