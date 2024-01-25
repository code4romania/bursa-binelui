<?php

declare(strict_types=1);

return [
    'label' => [
        'singular' => 'organizație',
        'plural' => 'Organizații',
    ],

    'status_arr' => [
        'pending' => 'În așteptare',
        'active' => 'Activă',
        'disabled' => 'Inactivă',
        'approved' => 'Aprobată',
        'rejected' => 'Respinsă',
    ],
    'actions' => [
        'view' => 'Vizualizează',
        'edit' => 'Editează',
        'approve' => 'Aprobă',
        'reject' => 'Respinge',
        'deactivate' => 'Dezactivează',
        'reactivate' => 'Reactivează',
    ],
    'organization' => 'Organizație',
    'heading' => [
        'in_approval' => 'Cereri noi de înscriere (:number)',
        'approved' => 'Organizații active (:number)',
        'rejected' => 'Organizații dezactivate (:number)',
        'pending_changes' => 'Organizații aprobate cu modificări în așteptare (:number)',
    ],
    'filters' => [
        'counties' => 'Județe',
        'counties_placeholder' => 'Selectează județele',
        'activity_domains' => 'Domenii de activitate',
        'activity_domains_placeholder' => 'Selectează domeniile de activitate',
        'accepts_volunteers' => 'Acceptă voluntari',
        'has_volunteers' => 'Are voluntari',
        'has_projects' => 'Are proiecte',
        'has_active_projects' => 'Are proiecte active',
        'has_eu_platesc' => 'Are EuPlătesc',
        'has_donations' => 'Are donații',

    ],
    'labels' => [
        'has_statute_file' => 'Are statut',
        'general_data' => 'Date organizație',
        'name' => 'Denumire organizație',
        'cif' => 'CIF/CUI',
        'logo' => 'Logo-ul organizației',
        'description' => 'Descriere organizație',
        'activity_domains' => 'Domenii de activitate',
        'statute' => 'Statutul organizației',
        'volunteering_data' => 'Voluntari',
        'accepts_volunteers' => 'Organizația acceptă voluntari?',
        'why_volunteer' => 'De ce să devin voluntar?',
        'contact_data' => 'Contact organizație',
        'website' => 'Website organizație',
        'email_contact_organization' => 'Email contact organizație (public)',
        'phone_contact_organization' => 'Telefon contact organizație (public)',
        'contact_person' => 'Persoană de contact',
        'address' => 'Adresă sediu',
        'eu_platesc_data' => 'Date EuPlătesc',
        'eu_platesc_merchant_id' => 'Merchant ID',
        'eu_platesc_private_key' => 'Key',
        'administrator' => 'Administrator',
        'created_at' => 'Data înscrierii',
        'approved_at' => 'Data aprobarii',
        'updated_at' => 'Data ultimei modificări',
        'rejected_at' => 'Data dezactivării',
        'contact_email' => 'Email de contact',
        'contact_phone' => 'Telefon de contact',
        'counties' => 'Județe',
        'has_volunteers' => 'Organizația are voluntari?',
        'has_projects' => 'Organizația are proiecte?',
        'has_active_projects' => 'Organizația are proiecte active?',
        'has_eu_platesc' => 'Organizația are date EuPlătesc?',
        'has_donations' => 'Organizația are donații?',
        'changes_count' => 'Număr modificări în așteptare',
        'latest_updated_at' => 'Data ultimei modificări',
    ],
    'messages' => [
        'update_success' => 'Organizația a fost actualizată cu succes!',
        'update_error' => 'A apărut o eroare la actualizarea organizației!',
        'approve_success' => 'Organizația a fost aprobată cu succes!',
        'approve_error' => 'A apărut o eroare la aprobarea organizației!',
        'reject_success' => 'Organizația a fost respinsă cu succes!',
        'reject_error' => 'A apărut o eroare la respingerea organizației!',
    ],

    'approve_modal' => [
        'heading' => 'Aprobă organizația',
        'subheading' => 'Sunteți sigur că doriți să aprobați organizația ":name"?',
    ],

    'reject_modal' => [
        'heading' => 'Respinge organizația',
        'subheading' => 'Sunteți sigur că doriți să respingeți organizația ":name"?',
        'reason' => 'Motiv respingere',
    ],

    'deactivate_modal' => [
        'heading' => 'Dezactivează organizația',
        'subheading' => 'Sunteți sigur că doriți să dezactivați organizația ":name"?',
        'reason' => 'Motiv respingere',
    ],

    'reactivate_modal' => [
        'heading' => 'Reactivează organizația',
        'subheading' => 'Sunteți sigur că doriți să reactivați organizația ":name"?',
    ],

    'ticket_rejected' => [
        'subject' => 'Organizația ta a fost respinsă de către un administrator.',
    ],
];
