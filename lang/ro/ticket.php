<?php

declare(strict_types=1);

return[

    'label' => [
        'singular' => 'Tichet',
        'plural' => 'Tichete',
    ],

    'column' => [
        'id' => 'ID',
        'subject' => 'Subiect',
        'created_at' => 'Creat la data',
        'closed_at' => 'Închis la data',
    ],

    'closed_at' => 'Închis la data',
    'date' => 'Dată',
    'message' => 'Mesaj',
    'opened_by' => 'Deschis de',
    'organization' => 'Organizație',
    'subject' => 'Subiect',
    'status' => 'Status',
    'status.open' => 'Deschis',
    'status.closed' => 'Închis',

    'action' => [
        'reply' => 'Răspunde',
        'close' => 'Închide',
        'reopen' => 'Redeschide',
        'view' => 'Vezi ticketul',
    ],

    'action_close_confirm' => [
        'title' => 'Închide ticket',
        'text' => 'Ești sigur că dorești să efectuezi operaţia?',
        'action' => 'Închide',
        'success' => 'Ticket-ul a fost închis.',
    ],

    'action_reopen_confirm' => [
        'title' => 'Redeschide ticket',
        'text' => 'Ești sigur că dorești să efectuezi operaţia?',
        'action' => 'Redeschide',
        'success' => 'Ticket-ul a fost redeschis.',
    ],

    'action_open' => [
        'success' => 'Ticket-ul a fost deschis.',
    ],

    'action_reply' => [
        'success' => 'Mesajul a fost trimis.',
    ],

    'mail' => [
        'created' => [
            'subject' => 'Ticketul #:id a fost creat.',
            'line' => 'Administratorul platformei a deschis Ticketul #10 pentru tine.',
        ],
        'replied' => [
            'subject' => 'Ticketul #:id a primit un răspuns nou.',
            'body' => 'Administratorul platformei a trimis un răspuns la Ticketul #:id.',
        ],
        'closed' => [
            'subject' => 'Ticketul #:id a fost închis.',
        ],
        'reopened' => [
            'subject' => 'Ticketul #:id a fost redeschis.',
        ],
    ],

    'header' => [
        'open' => 'Tichete deschise (:number)',
        'close' => 'Tichete închise (:number)',
    ],
];
