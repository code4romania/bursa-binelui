# Bursa Binelui

[![GitHub contributors][ico-contributors]][link-contributors]
[![GitHub last commit][ico-last-commit]][link-last-commit]
[![License: MPL 2.0][ico-license]][link-license]

Bursa Binelui is a civic-tech platform that connects NGOs with donors and volunteers. Organizations register, publish projects, and collect donations. Donors give to approved projects, and volunteers offer their time to organizations and projects.

The app is PHP 8.2 and Laravel 10 on the backend, with Vue 3, Inertia.js, and Tailwind CSS on the frontend. Filament v2 is the admin panel.

[See the project live][link-production]

[Contributing](#contributing) | [Built with](#built-with) | [Development](#development) | [Deployment](#deployment) | [Feedback](#feedback) | [License](#license) | [About Code for Romania](#about-code-for-romania)

## Contributing

This project is built by amazing volunteers and you can be one of them! Here's a list of ways in [which you can contribute to this project][link-contributing]. If you want to make any change to this repository, please **make a fork first**.

Help us out by testing this project in the [staging environment][link-staging]. If you see something that doesn't quite work the way you expect it to, open an Issue. Make sure to describe what you _expect to happen_ and _what is actually happening_ in detail.

If you would like to suggest new functionality, open an Issue and mark it as a __[Feature request]__. Please be specific about why you think this functionality will be of use. If you can, please include some visual description of what you would like the UI to look like, if you are suggesting new UI elements.

## Built With

- **Languages:** PHP 8.2, JavaScript
- **Backend:** Laravel 10, Filament v2
- **Frontend:** Vue 3, Inertia.js, Tailwind CSS
- **Package managers:** Composer, npm
- **Database:** MySQL or MariaDB

## Development

### Prerequisites

- PHP 8.2 or newer, with the `pdo_mysql`, `mbstring`, `gd`, `intl`, `zip`, and `exif` extensions
- [Composer](https://getcomposer.org/)
- Node.js 20 and npm. The repo pins the version in `.nvmrc`, so `nvm use` selects it.
- MySQL or MariaDB
- [Laravel Herd](https://herd.laravel.com) is optional. The built-in PHP server works too.

### Install

1. Copy the environment file:

```bash
cp .env.example .env
```

2. Create a database named `bursa_binelui`.

3. Point `.env` at your local MySQL server. `.env.example` uses the hostname `mariadb`, which is only reachable from a container. On the host machine, set:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bursa_binelui
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

Cache and queues already use `CACHE_DRIVER=file` and `QUEUE_CONNECTION=sync`, so a local Redis server is not required.

4. Install PHP dependencies:

```bash
composer install
```

5. Install JavaScript dependencies:

```bash
npm install
```

6. Generate the application key:

```bash
php artisan key:generate
```

7. Migrate and seed:

```bash
php artisan migrate:fresh --seed
```

Seeding creates a large set of organizations and articles, so it can take a while. If it fails on a Faker date, run the same command again.

8. Link the public storage disk:

```bash
php artisan storage:link
```

9. Turn off Content Security Policy for local development by adding this to `.env`:

```dotenv
CSP_ENABLED=false
```

CSP is enabled by default. Keep that setting for local development only.

10. Set `APP_URL` to the URL you will open in the browser:

- Laravel Herd: `APP_URL=https://bursabinelui.test`
- Built-in PHP server: `APP_URL=http://127.0.0.1:8000`

### Run

Start the Vite dev server:

```bash
npm run dev
```

Then serve PHP with one of these options.

**Laravel Herd.** Link this project in Herd, select PHP 8.2, and enable HTTPS. Open [https://bursabinelui.test](https://bursabinelui.test).

**Built-in PHP server.** In a second terminal:

```bash
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000).

### Seeded accounts

`php artisan migrate:fresh --seed` creates these users. The password for both is `password`.

| Email | Role |
| --- | --- |
| `superadmin@example.com` | Super admin. Signs in at `/admin`. |
| `supermanager@example.com` | Super manager |

### Optional services

`GOOGLE_MAPS_API_KEY` enables the county map. Mail, S3, EuPlatesc, Mailchimp, and Sentry can stay empty while you work locally.

`npm run dev` is enough for day-to-day work. `npm run build` compiles the client and SSR assets used by the production image. That image starts server rendering with `php artisan inertia:start-ssr`.

### Tests

```bash
php artisan test
```

Feature tests use `RefreshDatabase` and run against the database configured in `.env`. `phpunit.xml` keeps the MySQL connection. Point `DB_*` at a separate database before you run the suite, so the refresh does not wipe your development data.

## Deployment

Production runs from the [Dockerfile](Dockerfile). The image installs PHP dependencies, builds the Vite client and SSR bundles, and serves the app with nginx and PHP-FPM, plus a queue worker, cron, and the Inertia SSR process. Process configuration lives in [`docker/`](docker/).

Local installation is described in [Development](#development).

## Feedback

* Request a new feature on GitHub.
* Vote for popular feature requests.
* File a bug in GitHub Issues.
* Email us with other feedback contact@code4.ro

## License

This project is licensed under the MPL 2.0 License - see the [LICENSE](LICENSE) file for details

## About Code for Romania

Started in 2016, Code for Romania is a civic tech NGO, official member of the Code for All network. We have a community of around 2.000 volunteers (developers, ux/ui, communications, data scientists, graphic designers, devops, it security and more) who work pro-bono for developing digital solutions to solve social problems. #techforsocialgood. If you want to learn more details about our projects [visit our site][link-code4] or if you want to talk to one of our staff members, please e-mail us at contact@code4.ro.

Last, but not least, we rely on donations to ensure the infrastructure, logistics and management of our community that is widely spread across 11 timezones, coding for social change to make Romania and the world a better place. If you want to support us, [you can do it here][link-donate].


[ico-contributors]: https://img.shields.io/github/contributors/code4romania/bursa-binelui.svg?style=for-the-badge
[ico-last-commit]: https://img.shields.io/github/last-commit/code4romania/bursa-binelui.svg?style=for-the-badge
[ico-license]: https://img.shields.io/badge/license-MPL%202.0-brightgreen.svg?style=for-the-badge

[link-contributors]: https://github.com/code4romania/bursa-binelui/graphs/contributors
[link-last-commit]: https://github.com/code4romania/bursa-binelui/commits/main
[link-license]: https://opensource.org/licenses/MPL-2.0
[link-contributing]: https://github.com/code4romania/.github/blob/main/CONTRIBUTING.md

[link-production]: insert_link_here
[link-staging]: insert_link_here

[link-code4]: https://www.code4.ro/en/
[link-donate]: https://code4.ro/en/donate/
