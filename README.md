# Stephen Williams — Software Developer Portfolio

Plain PHP portfolio built on the Selfown template assets. No framework, no database.

Positioning: a software developer who builds products and digital systems that help
businesses and startups launch, operate, improve and scale. PHP/Laravel live in the
technical stack — they are not the whole identity.

## Pages

- `/index.php` — Home: hero → intro → capabilities → featured products → product experience → technical stack → education → contact
- `/projects.php` — All products and systems
- `/project.php?slug=bestschoolpage` — Reusable detail page (same structure for every project)

## Edit your info

- `config/config.php` — contact email (`email`), site URL, name, hero text, tech line, GitHub link.
- `data/projects.php` — add/remove products. Each entry supports:
  `title`, `slug`, `short_description`, `full_description`, `category`,
  `technologies`, `images[]`, `live_url`, `featured`, `status`, `business_context`, `what_built[]`.
- `data/profile.php` — about text, capability cards, product experience, tech groups, education.

## Screenshots

Each project reads its slider from the `images` array — add 4, 5, 6 or more images
without touching any HTML:

```php
'images' => [
    'images/projects/buy2055-originals/01.jpg',
    'images/projects/buy2055-originals/02.jpg',
    'images/projects/buy2055-originals/03.jpg',
    'images/projects/buy2055-originals/04.jpg',
],
```

Current `.svg` files in `images/projects/<slug>/` are placeholders. Replace them with
real captures (JPG/PNG) and update the paths. The slider is a Bootstrap 5 carousel:
touch swipe on mobile, arrows + indicators on desktop, fixed frame so images never
distort or push the page down.

## Contact form

The form on `index.php#contact` (`includes/contact-form.php`) submits via jQuery
AJAX (`js/contact.js`) to `contact-submit.php`, which validates server-side and
sends through SMTP using PHPMailer (`includes/contact-submit.php` returns JSON —
no page reload, no `alert()`, inline success/error messages).

- SMTP credentials live ONLY in `config/mail.php` (server-side, placeholders
  included — replace with your real details). Never committed with real secrets.
- Install dependencies with `composer install` (`vendor/` is git-ignored).
- `From` is the configured site mailbox; visitor address is set as `Reply-To`.
- Spam protection: server-side validation + length limits, CSRF token, honeypot
  field, 30s per-session rate limit. Detailed mail errors go to the server log;
  visitors only see generic messages.

## Run locally

```bash
php -S localhost:8000
# open http://localhost:8000/index.php
```

## Assets kept from Selfown

`css/`, `js/`, `images/`, `fonts/` are the original template assets plus `css/custom.css` and `images/projects/` added for this portfolio.
