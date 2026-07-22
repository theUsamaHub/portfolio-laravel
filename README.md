# Portfolio CMS — Admin Panel Documentation

A full-featured admin panel for managing a developer portfolio, built with Laravel 13, Blade, and PostgreSQL.

---

## Access

| URL | Description |
|-----|-------------|
| `/login` | Admin login (default path: `a9x7k2m8`, configurable) |
| `/admin` | Dashboard (requires authentication) |

**Default credentials:** `admin@portfolio.dev` / `password`

---

## Architecture

### Tech Stack
- **Backend:** Laravel 13, PHP 8.5
- **Database:** PostgreSQL 15
- **Frontend:** Blade templates, SCSS, vanilla JS
- **Auth:** Laravel Breeze (customized)
- **Build:** Vite

### Security
- **Auth route obfuscation** — Login/register URLs are randomized (e.g., `a9x7k2m8`) and configurable from admin settings
- **Admin middleware** — `EnsureUserIsAdmin` checks `role === 'super_admin'` or `role === 'admin'`
- **Security headers** — X-Content-Type-Options, X-Frame-Options, X-XSS-Protection, Referrer-Policy, optional HSTS
- **Maintenance mode** — Admin routes always accessible, public routes blocked with 503

### User Roles
| Role | Access |
|------|--------|
| `super_admin` | Full access to all admin features |
| `admin` | Full access to all admin features |
| `user` | No admin access |

---

## Dashboard

**URL:** `/admin`

The dashboard provides a real-time overview of the portfolio:

### Stats Cards
| Card | Data |
|------|------|
| Total Projects | Count + published/draft breakdown |
| Blog Posts | Count + published/draft breakdown |
| Total Messages | Count + today's count + replied count |
| Unread Messages | Count with red badge |

### Analytics
| Card | Data |
|------|------|
| Page Views Today | Today's page view count |
| Views This Month | Monthly page view count |
| Total Views | All-time page view count |

### Content Stats
Skills, Services, Testimonials, Experiences, Education, Certificates, Awards, Newsletter Subscribers

### Weekly Views Chart
CSS bar chart showing page views for the last 7 days

### Recent Content
- Recent Messages (5 latest)
- Recent Projects (5 latest)
- Recent Blog Posts (5 latest)
- Quick action buttons

### Activity Log
Last 10 activity log entries with user, action, description, and timestamp

---

## Content Management

### Hero Section
**URL:** `/admin/hero`

| Field | Type | Description |
|-------|------|-------------|
| Title | text | Main heading (required) |
| Subtitle | text | "Hello, I'm" prefix |
| Description | textarea | Hero description |
| Profile Image | file upload | Profile photo |
| Background Image | file upload | Background image |
| Background Video | file upload | MP4/WebM video |
| Resume File | file upload | PDF/DOC resume |
| Active | checkbox | Enable/disable hero |
| CTAs | dynamic rows | Label, URL, style (primary/outline/secondary) |
| Rotating Professions | dynamic rows | Text that cycles with typewriter effect |

### About Section
**URL:** `/admin/about`

| Field | Type | Description |
|-------|------|-------------|
| Title | text | Section heading |
| Subtitle | text | Section subheading |
| Description | textarea | About text |
| Highlights | textarea | Newline-separated skill tags |
| Profile Image | file upload | About photo |
| Experience Years | number | Years of experience |
| Location | text | City, Country |
| Languages | textarea | Newline-separated languages |
| CV File | file upload | Downloadable CV |

### Skills
**URL:** `/admin/skills`

Manage skill categories and individual skills:

**Categories:** Name, slug (auto-generated), description, icon, color, sort order
**Skills:** Category, name, slug, percentage (0-100), description, icon, featured flag

### Services
**URL:** `/admin/services`

| Field | Type | Description |
|-------|------|-------------|
| Name | text | Service name (required) |
| Description | textarea | Service description (required) |
| Icon | text | Emoji or icon character |
| Features | textarea | Newline-separated features |
| Price | number | Optional price |
| Price Unit | text | e.g., "per project", "per hour" |
| Featured | checkbox | Highlight on homepage |

### Projects
**URL:** `/admin/projects`

Full CRUD with listing, create, edit, and delete.

**Fields:**
| Field | Type | Description |
|-------|------|-------------|
| Name | text | Project name (required) |
| Slug | text | Auto-generated from name |
| Category | select | Project category |
| Description | textarea | Full description (required) |
| Short Description | text | Brief description for cards |
| Content | textarea (rich) | Detailed project content |
| Thumbnail | file upload | Project thumbnail image |
| Status | select | draft / published / archived |
| Client Name | text | Client or company name |
| Project URL | text | Live project link |
| GitHub URL | text | Source code link |
| Start Date | date | Project start date |
| End Date | date | Project end date |
| Featured | checkbox | Show on homepage |
| Sort Order | number | Display order |
| Tags | multi-select | Associated tags |
| Technologies | dynamic rows | Technology name + sort order |

**Listing features:** Status filter, search by name, pagination (15/page)

### Blog Posts
**URL:** `/admin/posts`

Full CRUD with listing, create, edit, and delete.

**Fields:**
| Field | Type | Description |
|-------|------|-------------|
| Title | text | Post title (required) |
| Slug | text | Auto-generated from title |
| Category | select | Blog category |
| Excerpt | textarea | Short preview text |
| Content | textarea (rich) | Full post content (required) |
| Featured Image | file upload | Post thumbnail |
| Status | select | draft / published / archived |
| Published At | datetime | Publication date |
| Featured | checkbox | Highlight on homepage |
| Meta Title | text | SEO title |
| Meta Description | text | SEO description |
| Keywords | text | SEO keywords |
| Tags | multi-select | Associated tags |

**Listing features:** Status filter, search by title, pagination (15/page)

### Contact Messages
**URL:** `/admin/messages`

| Feature | Description |
|---------|-------------|
| Listing | Status filter (unread/read/replied/archived/spam), search by name/email/subject |
| Detail View | Full message with sender info, IP, user agent, referrer |
| Status Management | Mark as read, reply, archive, mark as spam |
| Reply | Admin reply with email notification |
| Auto-mark | Messages auto-marked as read when viewed |

---

## Resume Management

### Work Experience
**URL:** `/admin/experiences`

| Field | Type | Description |
|-------|------|-------------|
| Company | text | Company name (required) |
| Position | text | Job title (required) |
| Description | textarea | Job description |
| Location | text | City, Country |
| Employment Type | text | Full-time, Part-time, etc. |
| Start Date | date | Start date (required) |
| End Date | date | End date (nullable if current) |
| Current | checkbox | Currently working here |
| Company URL | text | Company website |
| Company Logo | file upload | Company logo image |
| Achievements | textarea | Newline-separated achievements |

### Education
**URL:** `/admin/educations`

| Field | Type | Description |
|-------|------|-------------|
| Institution | text | School/university name (required) |
| Degree | text | Degree type (required) |
| Field of Study | text | Major/concentration |
| Description | textarea | Additional details |
| Start Date | date | Start date (required) |
| End Date | date | End date |
| Grade | text | GPA or grade |
| Activities | textarea | Extracurricular activities |
| Institution Logo | file upload | School logo |

### Certificates
**URL:** `/admin/certificates`

| Field | Type | Description |
|-------|------|-------------|
| Name | text | Certificate name (required) |
| Organization | text | Issuing organization (required) |
| Issue Date | date | When issued (required) |
| Expiry Date | date | When expires (optional) |
| Credential ID | text | Verification ID |
| Credential URL | text | Verification link |
| Description | textarea | Details |
| Image | file upload | Certificate image |

### Awards
**URL:** `/admin/awards`

| Field | Type | Description |
|-------|------|-------------|
| Name | text | Award name (required) |
| Organization | text | Granting organization (required) |
| Date | date | Award date (required) |
| Description | textarea | Details |
| URL | text | Link to award |
| Image | file upload | Award image |

---

## Site Management

### Navigation Menu
**URL:** `/admin/navigation`

Manage the site navigation with parent/child hierarchy:

| Field | Type | Description |
|-------|------|-------------|
| Label | text | Menu item text (required) |
| URL | text | Link URL (required) |
| Icon | text | Optional icon |
| Parent | select | Parent item (for submenus) |
| Open in New Tab | checkbox | External links |
| Active | checkbox | Show/hide |
| Sort Order | number | Display order |

### Tags
**URL:** `/admin/tags`

Manage tags shared between Projects and Blog Posts:

| Field | Type | Description |
|-------|------|-------------|
| Name | text | Tag name (required, unique) |
| Slug | text | Auto-generated from name |

Shows project/post count for each tag.

### Social Links
**URL:** `/admin/social-links`

| Field | Type | Description |
|-------|------|-------------|
| Platform | text | Platform name (required) |
| URL | text | Profile URL (required) |
| Icon | text | Icon identifier |
| Username | text | Platform username |
| Sort Order | number | Display order |

### Clients
**URL:** `/admin/clients`

| Field | Type | Description |
|-------|------|-------------|
| Name | text | Client name (required) |
| Logo | file upload | Client logo |
| URL | text | Client website |
| Sort Order | number | Display order |

### Contact Settings
**URL:** `/admin/contact-settings`

| Field | Type | Description |
|-------|------|-------------|
| Email | text | Contact email |
| Phone | text | Phone number |
| WhatsApp | text | WhatsApp number |
| Address | text | Street address |
| City | text | City |
| State | text | State/Province |
| Country | text | Country |
| Postal Code | text | ZIP/Postal code |
| Map Embed URL | text | Google Maps embed URL |
| Working Hours | textarea | Newline-separated hours |

### Statistics
**URL:** `/admin/statistics`

| Field | Type | Description |
|-------|------|-------------|
| Label | text | Stat name (required) |
| Value | number | Numeric value (required) |
| Suffix | text | e.g., "+", "K", "%" |
| Icon | text | Optional icon |

---

## Settings

### Site Settings
**URL:** `/admin/settings`

7 settings groups with key-value pairs:

| Group | Keys |
|-------|------|
| **General** | site_name, site_tagline, site_description, site_keywords, site_logo, site_favicon, site_author, site_currency, site_locale, site_timezone |
| **Appearance** | primary_color, secondary_color, accent_color, default_theme, custom_css, custom_js |
| **Contact** | contact_email, contact_phone, contact_whatsapp, contact_address, contact_map_embed |
| **Footer** | footer_copyright, footer_tagline, footer_show_social |
| **Analytics** | google_analytics_id, google_tag_manager, facebook_pixel, hotjar_id |
| **Email** | smtp_host, smtp_port, smtp_username, smtp_password, smtp_encryption, email_from_name, email_from_address |
| **Security** | enable_recaptcha, enable_hsts, maintenance_mode |

**Settings types:** text, color, boolean, json, image (file upload)

### SEO Settings
**URL:** `/admin/seo`

Per-page SEO for 6 pages: home, projects, blog, contact, about, services

| Field | Description |
|-------|-------------|
| Meta Title | Page title for search engines |
| Meta Description | Page description for search results |
| Keywords | Comma-separated keywords |
| OG Image | OpenGraph image |
| Canonical URL | Canonical link |
| Robots | index/follow directives |
| OG Type | OpenGraph type |
| Twitter Card | Twitter card type |
| Schema Type | Structured data type |

### Auth Routes
**URL:** `/admin/auth-routes`

Configure custom URL paths for authentication routes:

| Route | Default | Description |
|-------|---------|-------------|
| Login | `a9x7k2m8` | Login page URL |
| Register | `7f3a9b2c` | Registration URL |
| Forgot Password | `x4k8m2n9` | Password reset request URL |
| Reset Password | `r7p3w5q1` | Password reset form URL |

- Paths must be alphanumeric (hyphens/underscores allowed)
- All paths must be unique
- Changes invalidate existing password reset links

### Maintenance Mode
**URL:** `/admin/settings/security`

Toggle maintenance mode to block public access while keeping admin accessible.

---

## Media Management

All file uploads are handled by `MediaService` and stored on the `public` disk:

| Folder | Used By |
|--------|---------|
| `hero/` | Hero section images, video, resume |
| `about/` | About section profile image, CV |
| `projects/` | Project thumbnails |
| `blog/` | Blog post featured images |
| `testimonials/` | Client photos |
| `experience/` | Company logos |
| `education/` | Institution logos |
| `certificates/` | Certificate images |
| `awards/` | Award images |
| `clients/` | Client logos |
| `settings/` | Settings page uploads |

**File handling:**
- Upload: Generates unique filename with prefix
- Replace: Deletes old file, uploads new one
- Delete: Removes file from storage

---

## Profile Management

**URL:** `/profile`

| Feature | Description |
|---------|-------------|
| Edit Profile | Update name, email, phone, bio |
| Change Password | Requires current password |
| Delete Account | Requires password confirmation |

---

## Database Tables (38 custom tables)

| Table | Purpose |
|-------|---------|
| `users` | User accounts with roles |
| `hero_sections` | Homepage hero content |
| `hero_ctas` | Hero call-to-action buttons |
| `rotating_professions` | Typewriter text items |
| `about_sections` | About page content |
| `skill_categories` | Skill groupings |
| `skills` | Individual skills |
| `services` | Service offerings |
| `project_categories` | Project groupings |
| `projects` | Portfolio projects |
| `project_technologies` | Project tech stack |
| `project_gallery` | Project images |
| `project_tag` | Project-tag pivot |
| `tags` | Content tags |
| `blog_categories` | Blog groupings |
| `posts` | Blog articles |
| `post_tag` | Post-tag pivot |
| `testimonials` | Client reviews |
| `experiences` | Work history |
| `educations` | Education history |
| `certificates` | Certifications |
| `awards` | Awards received |
| `statistics` | Homepage stats |
| `clients` | Client list |
| `partners` | Partner list |
| `social_links` | Social media links |
| `navigation_menus` | Site navigation |
| `contact_messages` | Contact form submissions |
| `contact_settings` | Contact information |
| `footer_sections` | Footer content |
| `site_settings` | Key-value site configuration |
| `seo_settings` | Per-page SEO data |
| `default_images` | Fallback images |
| `activity_logs` | User activity tracking |
| `login_logs` | Login attempt tracking |
| `page_views` | Page view analytics |
| `newsletter_subscribers` | Email subscribers |
| `backups` | Backup records |

---

## Quick Reference

### Admin Sidebar Sections

| Section | Links |
|---------|-------|
| **Overview** | Dashboard |
| **Homepage** | Hero, About, Skills, Statistics |
| **Content** | Projects, Blog Posts, Services, Testimonials |
| **Resume** | Experience, Education, Certificates, Awards |
| **Site** | Navigation, Tags, Social Links, Clients, Contact Info, Messages |
| **Settings** | SEO, Auth Routes, Site Settings |

### Keyboard Shortcuts (Admin)
- `Ctrl+K` — Search (if implemented)
- `Esc` — Close modals/dropdowns

### Flash Messages
- Green banner: Success operations
- Red banner: Error messages
- Auto-dismiss after 5 seconds
