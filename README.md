# InternTrack

**AI-Powered Malaysia Internship Discovery & Student Matching**

InternTrack is a localhost web application that helps university and college
students in Malaysia build a structured academic profile, discover real
Malaysian companies and relevant industry sectors, understand why an
internship opportunity is a good or weak match, and track applications from
saved opportunity through to interview, offer, rejection or withdrawal.

InternTrack is built as an **Open Source Learning Project** from day one —
public on GitHub, developed live, and free for students and hobbyist
developers to clone, install and learn from.

> Core principle: InternTrack stays useful even when external APIs or the
> Claude API are unavailable. External data is an enhancement, never a hard
> dependency. Company, vacancy and salary data are honestly labelled
> ("Demo", "Manually added", "Public source", "Not disclosed") — never
> fabricated.

## Current Status

🚧 **v0.1.0 — Project Shell** (in progress). The landing page, base
configuration approach and repository structure are being set up. None of
the modules below are functional yet — see [CHANGELOG.md](CHANGELOG.md) for
release history as it grows.

## Key Features (planned modules)

1. Student Profile — academic profile, skills & preferences, photo upload
2. Dashboard — KPIs and Chart.js visualisations from live MySQL data
3. Company Directory — Malaysian companies by industry and location
4. Internship Discovery — opportunities with honestly labelled data sources
5. AI Match Results — deterministic 100-point scoring + Claude API reasoning
6. My Applications — pipeline tracking from saved to offer/rejection
7. Application Detail & Timeline
8. Calendar / Reminders — interview dates and follow-ups
9. Resume / CV Builder — auto-populated from profile, PDF export
10. Settings / Data — export/import JSON, AI toggle, demo reset

## Tech Stack

- PHP 8+ (plain/native, no heavy framework)
- MySQL / MariaDB via XAMPP, accessed with PDO prepared statements
- Bootstrap 5.3.3 + custom CSS, mobile-first responsive layout
- Vanilla JavaScript, AJAX/fetch, SweetAlert2
- Chart.js & Lucide icons
- Claude API (server-side only) for match explanations, JD summaries and
  draft application emails — never for inventing company, vacancy or
  salary data

## Screenshots

_Coming soon — screenshots will be added here as modules are built._

## Follow This Project — Built Live on TikTok

InternTrack is being built **live**, from an empty folder to a working
system, as a Build-in-Public learning series:

**TikTok Live → GitHub → Download → Install → Learn**

- 🎥 TikTok: `<TODO: add TikTok profile URL>`
- 📦 Source code: this repository (public, MIT licensed)
- 🖥️ Run it yourself: see [INSTALL.md](INSTALL.md) for the Windows + XAMPP
  setup guide

### Live Episodes

| Episode | Date | What was built | Milestone |
|---|---|---|---|
| Live 01 | 2026-11-27 | Project shell, landing page, Git repo setup | `v0.1.0` (in progress) |

_This table is updated after every live session — see
[docs/DEVELOPMENT_LOG.md](docs/DEVELOPMENT_LOG.md) for detailed session
notes once development logging starts._

## Getting Started (quick version)

1. Clone or extract this repository into your `htdocs` folder (XAMPP).
2. Copy `.env.example` to `.env` and adjust `DB_*` / `APP_PORT` for your
   machine.
3. Start Apache & MySQL in XAMPP, then open the app at the host/port you
   configured.

A full step-by-step guide (database import via phpMyAdmin, Apache port
setup, optional Claude API key) will live in [INSTALL.md](INSTALL.md).

## Versioning & Roadmap

| Version | Scope |
|---|---|
| `v0.1.0` | Project shell, database schema, seed data & basic dashboard |
| `v0.2.0` | Student Profile Management & photo upload |
| `v0.3.0` | Company Directory & Internship Discovery |
| `v0.5.0` | Deterministic Matching Engine & Claude AI analysis |
| `v0.8.0` | Resume/CV Builder & Application Tracker |
| `v1.0.0` | Final release — source ZIP, clean SQL schema + seed, tested XAMPP install guide |

## Contributing

Issues and pull requests are welcome — this is a learning project, so
clear, well-explained contributions (even small ones) are encouraged.
Please don't include real personal data, API keys or credentials in any
contribution.

## License

Released under the [MIT License](LICENSE) — free to use, modify and
redistribute for learning purposes, with the original copyright notice
retained.
