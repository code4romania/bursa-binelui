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
        'created_between' => 'Creată între',
        'status_updated_between' => 'Status actualizat între',
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
        'rejected' => 'Proiecte respinse (:number)',
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
        'changes_count' => 'Număr modificări în așteptare',
        'latest_updated_at' => 'Data ultimei modificări',
        'pending' => 'Proiecte in curs de aprobare',
        'approved' => 'Proiecte aprobate',
        'rejected' => 'Proiecte respinse',
        'all_projects' => 'Toate proiectele',
        'cif' => 'CUI/CIF',

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

    'ticket_rejected' => [
        'subject' => 'Ne pare rău, modificarea făcută a fost respinsă de către un administrator Bursa Binelui.',
    ],

    'approve_modal' => [
        'heading' => 'Aprobă proiectul',
        'subheading' => 'Sunteți sigur că doriți să aprobați proiectul ":name"?',
    ],

    'reject_modal' => [
        'heading' => 'Respinge proiectul',
        'subheading' => 'Sunteți sigur că doriți să respingeți proiectul ":name"?',
        'reason' => 'Motiv respingere',
    ],

    'deactivate_modal' => [
        'heading' => 'Dezactivează proiectul',
        'subheading' => 'Sunteți sigur că doriți să dezactivați proiectul ":name"?',
        'reason' => 'Motiv respingere',
    ],

    'reactivate_modal' => [
        'heading' => 'Reactivează proiectul',
        'subheading' => 'Sunteți sigur că doriți să reactivați proiectul ":name"?',
    ],

    'project_status_changed' => 'Proiectul a fost trimis pentru aprobare către administratorul platformei. Mulțumim!',
    'project_updated' => 'Datele proiectului au fost schimbate.',
];
