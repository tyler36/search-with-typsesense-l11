# Copilot Instructions for This Codebase

## Overview
This project is a Laravel 11 web application with a Typesense-powered search feature. It uses a standard Laravel structure, but includes custom search and filtering logic, and is set up for local development with DDEV.

## Architecture & Key Components
- **App Structure:**
  - `app/Models/` — Eloquent models (e.g., `User.php`).
  - `app/Http/Controllers/` — Controllers for handling HTTP requests.
  - `resources/views/` — Blade templates for UI (notably `search.blade.php` for search UI).
  - `routes/web.php` — Main route definitions.
  - `database/` — Migrations, factories, and seeders for test data.
- **Search Integration:**
  - Search and faceted filtering are implemented in `search.blade.php` and the corresponding controller.
  - Facets and filters are passed as arrays to the view; filters are submitted via checkboxes that auto-submit the form.
  - Example: Each facet's filters are rendered as checkboxes, with checked state determined by the current request (see `@checked(in_array(...))`).
- **Frontend:**
  - Uses Tailwind CSS via CDN for styling.
  - Vite is configured for asset bundling (`vite.config.js`).

## Developer Workflows
- **Local Development:**
  - Use DDEV for local environment management.
  - Start the frontend dev server: `ddev npm run dev` (or use the VS Code task: "DDEV: npm dev").
  - Enable/disable Xdebug: `ddev xdebug on` / `ddev xdebug off` (or use VS Code tasks).
- **Testing:**
  - Run tests with `php artisan test` or via PHPUnit (`tests/` directory).
- **Cache & Debugging:**
  - Clear Laravel cache: `ddev php artisan cache:clear` (VS Code task available).

## Project-Specific Conventions
- **Faceted Search:**
  - Filters are grouped by facet name; form field names use `filters[facet_name][]`.
  - The checked state for filters is determined by `request('filters.authors', [])` — update this if you add new facets.
- **Blade Templates:**
  - Use `@checked()` for checkbox state.
  - Use `{!! $result !!}` to render HTML results safely.
- **Environment:**
  - DDEV is required for consistent local development.
  - Typesense integration is assumed but not shown in this repo; check controller logic for API usage.

## Key Files & Examples
- `resources/views/search.blade.php` — Main search UI and filter logic.
- `routes/web.php` — Route definitions for search and other endpoints.
- `app/Http/Controllers/` — Search logic and Typesense integration.
- `vite.config.js` — Frontend asset configuration.

## Tips for AI Agents
- Always check for DDEV tasks before running npm or artisan commands.
- When adding new facets or filters, update both the controller and Blade view to ensure correct request handling.
- Follow Laravel conventions unless a project-specific pattern is documented here.
