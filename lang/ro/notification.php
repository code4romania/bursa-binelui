<?php

declare(strict_types=1);

return[

    'export' => [
        'success' => [
            'title' => 'Exportul a fost adaugat în coadă',
            'body' => ' Procesul de export a fost adaugat in coada de procesare. Te vom anunta cand va fi gata.',
        ],
        'error' => [
            'title' => 'Exportul nu a putut fi adaugat in coada.',
            'body' => ' Procesul de export nu a putut fi adaugat in coada de procesare. Te rugam sa incerci din nou mai tarziu.',
        ],
    ],

    'export_finished' => [
        'title' => 'Exportul a fost finalizat',
        'body' => ' Procesul de export pentru :filename a fost finalizat',
        'action' => 'Descarcă',
    ],
];
