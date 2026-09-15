# Resumify

[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![JavaScript](https://img.shields.io/badge/JavaScript-Frontend-F7DF1E?logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
[![Composer](https://img.shields.io/badge/Composer-Dependencies-885630?logo=composer&logoColor=white)](https://getcomposer.org/)
[![PHPMailer](https://img.shields.io/badge/PHPMailer-Email-0A66C2?logo=maildotru&logoColor=white)](https://github.com/PHPMailer/PHPMailer)
[![Google Gemini](https://img.shields.io/badge/Google%20Gemini-Optional%20AI-8E75B2?logo=google&logoColor=white)](https://ai.google.dev/)

Resumify is a PHP and MySQL resume builder. Users can create an account, maintain a profile, build multiple resumes, add education, experience, skills, projects, and achievements, then view, edit, clone, print, download, and share resumes using multiple templates.

## Features

- User registration, login, logout, and password recovery by email OTP
- Profile creation and account management
- Multiple resumes per user
- Resume sections for:
  - Personal information
  - Objective and about-me content
  - Education
  - Work experience
  - Skills and proficiency percentages
  - Projects
  - Achievements
- Three resume presentation templates: `resume.php`, `resume2.php`, and `resume3.php`
- Printable A4 resume layouts
- Resume background and font customization
- Profile image uploads
- Resume cloning and soft deletion
- Feedback and contact forms
- Optional Gemini-powered writing assistance in `live_res`

## Tech Stack

- PHP
- MySQL with MySQLi
- HTML, CSS, and JavaScript
- Bootstrap and Bootstrap Icons via CDN
- PHPMailer for registration and password-recovery emails
- Composer dependencies for the Gemini integration:
  - `gemini-api-php/client`
  - `symfony/http-client`
  - `nyholm/psr7`

## Requirements

- PHP 8.2 or later is recommended because the `live_res` dependencies require PHP 8.2+
- MySQL or MariaDB
- PHP extensions:
  - `mysqli`
  - `curl` for Gemini HTTP requests
  - `openssl` for secure SMTP connections
- Composer, if using the Gemini integration
- A web server such as Apache, XAMPP, Laragon, or PHP's built-in development server

## Installation

### 1. Clone or copy the project

Place the project in your web server's document root. For example, with XAMPP:

```text
C:\xampp\htdocs\RESUME_BUILDER-main
```

### 2. Create the database

Create a MySQL database named `resumebuilder`:

```sql
CREATE DATABASE resumebuilder;
```

The application expects tables including `users`, `profiles`, `resumes`, `education`, `experiences`, `skills`, `projects`, `achivements`, and `feedback`.

This repository does not currently include a SQL schema or seed file. Create the tables using the queries and fields expected by the PHP action files before trying to register or create a resume.

### 3. Configure the database connection

Update [assets/class/database.class.php](assets/class/database.class.php) if your MySQL credentials differ from the current local defaults:

```php
private $host = 'localhost';
private $username = 'root';
private $database = 'resumebuilder';
private $password = '';
```

Do not use these defaults in production.

### 4. Install the optional AI dependencies

The Gemini integration has its own Composer project:

```powershell
cd live_res
composer install
```

The main application includes PHPMailer in `assets/packages/phpmailer` and does not have a root-level `composer.json`.

### 5. Configure email and Gemini credentials

Before using registration or password recovery, configure the SMTP server settings used by:

- `actions/register.action.php`
- `actions/sendcode.action.php`

For AI-assisted writing, configure the Gemini API key in `live_res/response.php`. Store SMTP credentials and API keys in environment variables or a server-side configuration file rather than committing them to the repository.

## Running Locally

From the project root, start PHP's built-in server:

```powershell
php -S localhost:8000
```

Open [http://localhost:8000](http://localhost:8000) in a browser.

With Apache, open the project directory through your local host, for example:

```text
http://localhost/RESUME_BUILDER-main/
```

## AI Endpoint

The optional AI endpoint is located at `live_res/response.php`. It accepts JSON containing a `text` property:

```powershell
Invoke-RestMethod `
  -Uri http://localhost:8000/live_res/response.php `
  -Method Post `
  -ContentType 'application/json' `
  -Body '{"text":"Improve this resume summary for a software developer."}'
```

A successful response contains generated text in the `text` property. The endpoint requires a configured Gemini API key and the dependencies installed in `live_res`.

## Project Structure

```text
.
├── actions/                 Form handlers and CRUD actions
├── assets/
│   ├── class/               Database and session helper classes
│   ├── css/                 Application stylesheets
│   ├── images/              Logos, templates, and backgrounds
│   ├── includes/            Shared header, navbar, and footer files
│   ├── js/                  Front-end scripts
│   └── packages/phpmailer/  Bundled PHPMailer source
├── live_res/                Optional Gemini resume-writing integration
├── index.php                Public landing page
├── login.php                Registration and login page
├── myresumes.php            Authenticated resume dashboard
├── createresume.php         Profile creation
├── add_resume.php           Resume creation
├── updateresume.php         Resume editing
├── resume.php               Resume template 1
├── resume2.php              Resume template 2
└── resume3.php              Resume template 3
```

## Security Notes

This project is intended for local development and should be reviewed before production deployment. In particular:

- Move database, SMTP, and API credentials out of source code.
- Replace the current MD5 password handling with `password_hash()` and `password_verify()`.
- Add CSRF protection to authenticated forms.
- Validate upload MIME types, file size, and file names before storing profile images.
- Use prepared statements consistently for database queries.
- Configure HTTPS and restrict access to uploaded files and configuration files.

## License

This project is licensed under the [MIT License](LICENSE). You may use, modify, and distribute the project in accordance with its terms.
