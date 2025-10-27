## Project Documentation

This documentation covers public HTTP APIs (routes), controllers, Eloquent models, and Blade components available in this application. It includes parameters, middleware, and examples to help you integrate and extend the system.

### Structure
- Routes: see `routes.md`
- Controllers: see `controllers.md`
- Models: see `models.md`
- Blade Components: see `components.md`

### Conventions
- All web endpoints are session-based and protected by CSRF. Use Blade forms or include the CSRF token header when calling via JavaScript.
- Auth-protected routes use the `auth` middleware; some administrative routes also require `role:*` middleware.
- Date/time values are ISO 8601 unless otherwise noted.

### Base URLs
- Web: `/`
- Admin: `/admin` (requires role: `admin` or `superadmin`)
- Superadmin: `/superadmin` (requires role: `superadmin`)

For full details, see the linked docs files.

