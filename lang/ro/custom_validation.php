<?php

declare(strict_types=1);

return [
    'activity_domains_ids' => 'Trebuie să selectați cel puțin un domeniu de activitate.',
    'counties_ids' => 'Te rugăm să selectezi cel puțin un județ.',
    'password_confirmed' => 'Ai întrodus două parole diferite.',
    'password_complexity' => 'Parola trebuie să conțină cel puțin 8 caractere, litere mari și mici, cifre și caractere speciale.',
    'email_unique' => 'Această adresa de email a fost deja folosită pentru înregistrare pe platforma Bursa Binelui. Alege o altă adresă sau scrie un mail administratorului la contact@bursabinelui.ro. ',
    'terms_required' => 'Pentru a te înregistra, te rugăm să accepți "Termeni și condiții" ale site-ului Bursa Binelui.',
    'ngo' => [
        'cif' => [
            'not_regex' => 'Te rugăm să întroduci un CUI/CIF valid.',
            'unique' => 'Acest CIF/CUI a fost deja folosit pentru înregistrarea pe platforma Bursa Binelui. Asigură-te că ai scris CIF/CUI corect sau scrie un mail administratorului la contact@bursabinelui.ro.',
        ],
        'field' => [
            'required' => 'Câmpul :attribute este obligatoriu.',
            'url' => 'Te rugăm să întroduci o adresă web validă, împreună cu https://',
        ],

    ],

    'start_date' => [
        'after_or_equal' => 'Data de început a perioadei de donații nu poate fi în trecut.',
    ],
    'project' =>
    [
        'start'=> [
            'after_or_equal' => 'Data de început a proiectului nu poate fi în trecut.',
        ],
        'end' => [
            'after' => 'Data de finalizare a proiectului trebuie să fie după data de început.',
        ],
    ]
];
