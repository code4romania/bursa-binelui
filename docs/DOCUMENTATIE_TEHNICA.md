# Documentație Tehnică - Bursa Binelui

## Cuprins
1. [Prezentare generală](#1-prezentare-generală)
2. [Stack tehnologic](#2-stack-tehnologic)
3. [Arhitectura aplicației](#3-arhitectura-aplicației)
4. [Modul Organizații](#4-modul-organizații)
5. [Modul Proiecte](#5-modul-proiecte)
6. [Fluxuri principale](#6-fluxuri-principale)
7. [Baza de date](#7-baza-de-date)
8. [Autentificare și autorizare](#8-autentificare-și-autorizare)
9. [Integrări externe](#9-integrări-externe)
10. [Medii de deployment](#10-medii-de-deployment)

---

## 1. Prezentare generală

**Bursa Binelui** este o platformă civic tech dezvoltată de Code for Romania care conectează organizațiile neguvernamentale (ONG-uri) cu donatori și voluntari. Platforma permite:

- **ONG-urilor** să se înregistreze, să creeze proiecte și să colecteze donații
- **Donatorilor** să doneze către proiecte aprobate
- **Voluntarilor** să se oferte pentru proiecte sau organizații

### 1.1 Obiective principale
- Facilitarea colectării de fonduri pentru proiecte sociale
- Vizibilitate pentru organizațiile neguvernamentale
- Transparență în gestionarea donațiilor
- Conectarea voluntarilor cu organizațiile care au nevoie de suport

---

## 2. Stack tehnologic

| Componentă | Tehnologie |
|------------|------------|
| **Backend** | PHP 8.2, Laravel 10.x |
| **Frontend** | Vue 3, Inertia.js, Tailwind CSS |
| **Admin Panel** | Filament v2 |
| **Baza de date** | MySQL (compatibil MariaDB) |
| **Fișiere** | AWS S3 / Storage local |
| **Plăți** | EuPlatesc |
| **Deployment** | Docker, Terraform |

### 2.1 Dependențe principale
- `inertiajs/inertia-laravel` - integrare SPA fără API REST
- `filament/filament` - panou administrare
- `spatie/laravel-medialibrary` - gestionare imagini
- `spatie/laravel-activitylog` - jurnalizare acțiuni
- `spatie/laravel-query-builder` - filtrare și sortare
- `tightenco/ziggy` - rute Laravel în JavaScript

---

## 3. Arhitectura aplicației

### 3.1 Structura directorelor
```
app/
├── Concerns/          # Traits reutilizabile (BelongsToOrganization, HasCounties, etc.)
├── Console/           # Comenzi Artisan (import, EndProjectPeriod)
├── Enums/             # Enum-uri (ProjectStatus, OrganizationStatus, UserRole)
├── Filament/          # Resurse admin (ProjectResource, OrganizationResource)
├── Http/
│   ├── Controllers/   # Controllere public (ProjectController, OrganizationController)
│   │   └── Dashboard/ # Controllere pentru ONG-uri autentificate
│   ├── Filters/       # Filtre Query Builder
│   ├── Requests/      # Form Requests
│   └── Resources/     # API Resources (transformări JSON)
├── Models/            # Eloquent models
├── Policies/          # Politici autorizare
├── Services/          # Logică business (ProjectService, OrganizationService)
├── Notifications/     # Notificări email
└── Listeners/         # Event listeners

resources/js/
├── Pages/
│   ├── Public/        # Pagini publice (Projects, Organizations)
│   └── AdminOng/      # Pagini dashboard ONG (Projects, Organizations, Volunteers)
└── Components/        # Componente Vue reutilizabile
```

### 3.2 Modes de rulare
- **Public** - Site-ul vizibil vizitatorilor (proiecte, organizații, donații)
- **Dashboard ONG** - Interfață pentru utilizatorii organizațiilor (`/dashboard`)
- **Filament Admin** - Panou administrare pentru superadmin (`/admin`)

---

## 4. Modul Organizații

### 4.1 Model și relații
**Fișier:** `app/Models/Organization.php`

| Câmp | Tip | Descriere |
|------|-----|-----------|
| name | string | Denumire organizație |
| slug | string | URL-friendly identifier |
| cif | string | CUI unic |
| description | text | Descriere |
| address | string | Adresă |
| contact_person | string | Persoană de contact |
| contact_phone | string | Telefon |
| contact_email | string | Email |
| website | string | Site web |
| facebook | string | Pagină Facebook |
| accepts_volunteers | boolean | Acceptă voluntari |
| why_volunteer | text | Motivație voluntariat |
| status | enum | pending, approved, rejected, pending_changes |
| eu_platesc_merchant_id | string | ID merchant EuPlatesc (criptat) |
| eu_platesc_private_key | string | Cheie privată EuPlatesc (criptată) |

**Relații:**
- `projects` - HasMany Project
- `users` - HasMany User (membrii organizației)
- `activityDomains` - BelongsToMany ActivityDomain (domenii de activitate)
- `counties` - MorphToMany County (județe de acoperire)
- `tickets` - HasMany Ticket (tichete suport)
- `badges` - BelongsToMany Badge
- `donations` - HasManyThrough Donation (prin Project)

### 4.2 Statusuri organizație
| Status | Descriere |
|--------|-----------|
| pending | În așteptarea aprobării inițiale |
| approved | Aprobată, poate crea proiecte |
| rejected | Respinasă |
| pending_changes | Modificări în așteptarea aprobării |

### 4.3 Flux înregistrare organizație
1. Utilizatorul completează formularul de înregistrare (tip: organizație)
2. Se creează User cu rol `admin` și Organization cu status `pending`
3. Se încarcă logo și statut
4. Se atașează domenii de activitate și județe
5. Adminul Bursa Binelui aprobă/respinge organizația în Filament
6. La respingere, se creează tichet cu motivul

### 4.4 Serviciu organizație
**Fișier:** `app/Services/OrganizationService.php`
- `update()` - Actualizare atribute; câmpurile din `requiresApproval` (name, cif, statute) trec prin flow de aprobare

### 4.5 Rute
| Metodă | URL | Controller | Descriere |
|--------|-----|------------|-----------|
| GET | /organizations | OrganizationController@index | Lista organizații publice |
| GET | /organizations/{slug} | OrganizationController@show | Pagina organizație |
| POST | /organizations/{slug}/volunteer | OrganizationController@volunteer | Înscriere voluntar |
| GET | /dashboard/organization | Dashboard\OrganizationController@edit | Editare organizație (ONG) |
| POST | /dashboard/organization | Dashboard\OrganizationController@update | Salvare organizație |

---

## 5. Modul Proiecte

### 5.1 Tipuri de proiecte
| Tip | Model | Tabel | Descriere |
|-----|-------|-------|-----------|
| Proiect standard | Project | projects | Proiecte principale ale platformei |
| Proiect Gala | GalaProject | gala_projects | Proiecte pentru evenimente Gala |
| Proiect regional | RegionalProject | regional_projects | Proiecte regionale |
| Proiect BCR | BCRProject | b_c_r_projects | Proiecte parteneriat BCR |

### 5.2 Model Project
**Fișier:** `app/Models/Project.php`

| Câmp | Tip | Descriere |
|------|-----|-----------|
| organization_id | FK | Organizația proprietară |
| name | string | Denumire proiect |
| slug | string | URL (generat la aprobare) |
| status | enum | draft, pending, approved, rejected, archived |
| target_budget | integer | Buget țintă (lei) |
| start | date | Data început |
| end | date | Data sfârșit |
| archived_at | date | Data arhivării |
| description | text | Descriere |
| scope | text | Domeniu de aplicare |
| beneficiaries | text | Beneficiari |
| reason_to_donate | text | Motiv donație |
| is_national | boolean | Proiect național (toate județele) |
| accepting_volunteers | boolean | Acceptă voluntari |
| accepting_comments | boolean | Acceptă comentarii |
| videos | json | Array URL-uri video |
| external_links | json | Link-uri externe |

**Relații:**
- `organization` - BelongsTo Organization
- `donations` - HasMany Donation
- `categories` - MorphToMany ProjectCategory
- `counties` - MorphToMany County (dacă nu e național)
- `volunteers` - MorphToMany Volunteer (prin model_has_volunteers)
- `stages` - BelongsToMany ChampionshipStage
- `tickets` - HasManyThrough Organization

**Colecții media (Spatie Media Library):**
- `preview` - Imagine principală
- `gallery` - Galerie imagini

### 5.3 Statusuri proiect
| Status | Vizibil public | Descriere |
|--------|----------------|-----------|
| draft | Nu | Proiect în lucru |
| pending | Nu | În așteptarea aprobării |
| approved | Da | Aprobat, vizibil |
| rejected | Nu | Respins |
| archived | Nu | Arhivat (după perioada de colectare) |

**Statusuri vizibile (atribute derivate):**
- `starting_soon` - În curând
- `open` - Deschis pentru donații
- `close` - Închis
- `archived` - Arhivat

### 5.4 Flow aprobare proiect
1. ONG creează proiect cu status `draft` (ProjectService)
2. ONG trimite la aprobare → status `pending`
3. Admin aprobă/respinge în Filament
4. La aprobare: generare slug unic, actualizare status
5. La respingere: creare tichet cu motiv, notificare ONG
6. Câmpurile `requiresApproval`: name, target_budget, start, end - modificările trec prin flow aprobare (LogsActivityForApproval)

### 5.5 Serviciu proiect
**Fișier:** `app/Services/ProjectService.php`
- `create()` - Creare proiect draft
- `update()` - Actualizare (counties, categories, image, gallery sau câmpuri simple)
- `changeStatus()` - Schimbare status (pending, archived, publish pentru Gala)

### 5.6 Rute proiecte
| Metodă | URL | Controller | Descriere |
|--------|-----|------------|-----------|
| GET | /projects | ProjectController@index | Lista proiecte (listă/hartă) |
| GET | /projects/map | ProjectController@map | Hartă proiecte |
| GET | /projects/{slug} | ProjectController@show | Pagina proiect |
| POST | /projects/{slug}/donate | ProjectController@donate | Inițiere donație |
| POST | /projects/{slug}/volunteer | ProjectController@volunteer | Înscriere voluntar |
| GET | /dashboard/projects | Dashboard\ProjectController@index | Lista proiecte ONG |
| GET | /dashboard/projects/create | Dashboard\ProjectController@create | Formular creare |
| POST | /dashboard/projects | Dashboard\ProjectController@store | Creare proiect |
| GET | /dashboard/projects/{id}/edit | Dashboard\ProjectController@edit | Editare proiect |
| POST | /dashboard/projects/{id} | Dashboard\ProjectController@update | Actualizare proiect |
| POST | /dashboard/projects/{id}/status | Dashboard\ProjectController@changeStatus | Schimbare status |

### 5.7 Filtre și sortări (lista publică)
- **Filtre:** județ, categorie, interval date, status, voluntari, căutare, național
- **Sortări:** data publicare, data încheiere, buget țintă, total donații, număr donații

---

## 6. Fluxuri principale

### 6.1 Donare la proiect
1. Utilizator selectează proiect și suma pe pagina proiectului
2. POST `/projects/{slug}/donate` → creare Donation cu status INITIALIZE
3. Redirect către `/doneaza/{uuid}` (DonationController)
4. Integrare EuPlatesc pentru plată
5. Callback EuPlatesc actualizează status donație
6. Job-uri: CaptureAuthorizedDonationJob, ProcessAuthorizedTransactionsJob

### 6.2 Înscriere voluntar
- **Pentru proiect:** POST `/projects/{slug}/volunteer`
- **Pentru organizație:** POST `/organizations/{slug}/volunteer`
- Se creează/actualizează Volunteer și pivot model_has_volunteers cu status `pending`
- ONG-ul aprobă/respinge în dashboard (`/dashboard/volunteers`)

### 6.3 Ciclu de viață proiect
```
draft → pending → approved (public) → archived
                ↘ rejected
```
- Comanda `EndProjectPeriod` (Console) arhivează proiectele care au depășit perioada
- Notificare `ProjectEndingNotification` trimisă ONG-urilor cu proiecte care se apropie de sfârșit

---

## 7. Baza de date

### 7.1 Migrații relevante
| Fișier | Descriere |
|--------|-----------|
| 2023_05_05_142228_create_organizations_table | Tabel organizații |
| 2023_05_15_123613_create_projects_table | Tabel proiecte |
| 2023_05_05_142245_add_organization_column_to_users_table | organization_id pe users |
| 2023_06_20_001911_create_activity_domain_organization | Pivot organizații-domenii |
| 2023_08_13_072825_create_project_categories_table | Categorii proiecte |
| 2023_08_13_072830_create_model_has_project_categories_table | Pivot proiecte-categorii |
| model_has_counties | Pivot polimorf pentru județe (organizații, proiecte) |
| model_has_volunteers | Pivot polimorf voluntari (proiecte, organizații) |

### 7.2 Diagramă relații (simplificată)
```
Organization 1──* Project
Organization 1──* User
Organization *──* ActivityDomain
Organization *──* County (morph)
Organization 1──* Ticket

Project 1──* Donation
Project *──* ProjectCategory (morph)
Project *──* County (morph)
Project *──* Volunteer (morph, pivot: VolunteerRequest)
Project *──* ChampionshipStage (pivot)
```

---

## 8. Autentificare și autorizare

### 8.1 Roluri utilizatori
| Rol | Cod | Acces |
|-----|-----|-------|
| Super Admin | superadmin | Filament admin, tot |
| Super Manager | supermanager | Filament admin |
| Admin ONG | admin | Dashboard ONG, organizație proprie |
| Manager ONG | manager | Dashboard ONG, organizație proprie |
| User | user | Donator, profil personal |

### 8.2 Politici
- **ProjectPolicy:** view/update doar dacă user aparține organizației proiectului sau e superadmin
- **OrganizationPolicy:** update doar superuser sau admin/manager al organizației; create/delete restricționat

### 8.3 Middleware
- `hasOrganization` - Utilizatorii dashboard trebuie să aibă organization_id (ONG)
- `auth`, `verified` - Pentru zone protejate

---

## 9. Integrări externe

### 9.1 EuPlatesc
- Plăți card pentru donații
- Configurare per organizație: `eu_platesc_merchant_id`, `eu_platesc_private_key`
- Flux: autorizare → încărcare (charge) prin job-uri
- Config: `config/euplatesc.php`

### 9.2 AWS S3
- Stocare imagini (logo, preview, gallery) și documente (statut)
- Config: `config/filesystems.php`, `config/media-library.php`

### 9.3 Google Maps
- Hartă proiecte pe județe
- Config: `services.google_maps_api_key`

### 9.4 Newsletter (Mailchimp)
- Abonare la înregistrare
- Config: `config/newsletter.php`

---

## 10. Medii de deployment

### 10.1 Docker
- Configurare în `docker/` (nginx, php, s6 services)
- Cron, queue worker, Laravel, SSR pentru Vue

### 10.2 Terraform
- Infrastructură în `terraform/`

### 10.3 Comenzi utile
```bash
# Setup inițial
composer install
npm install
php artisan key:generate
php artisan migrate:fresh --seed

# Development
npm run dev
php artisan serve

# Build production
npm run build
```

---

## Glosar

| Termen | Definiție |
|--------|-----------|
| ONG | Organizație neguvernamentală |
| EuPlatesc | Gateway plăți românesc |
| Filament | Framework admin Laravel |
| Inertia | Bridge Laravel-Vue fără API REST |
| Spatie Media Library | Gestionare fișiere pe modele |

---

*Documentație generată pentru predarea proiectului către o nouă echipă. Ultima actualizare: februarie 2025.*
