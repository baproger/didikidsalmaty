# DiDi Kids Almaty — Project Handoff

## Project Overview

Multi-language kindergarten website (RU/KK/EN) for DiDi Kids Almaty.
- **URL**: https://didialmatykids.kz
- **Admin**: https://didialmatykids.kz/admin
- **Stack**: Laravel 13 + Filament 5 + Tailwind CSS 4 + Alpine.js 3 + Vite 8
- **PHP**: 8.3 | **DB**: MySQL (production), SQLite (local dev)
- **Localization**: mcamara/laravel-localization — routes prefixed `/ru/`, `/kk/`, `/en/`

---

## Deployment

### Server
| Parameter | Value |
|-----------|-------|
| Host | 185.98.5.104 |
| Hosting | Plesk (nturbo-2.hoster.kz) |
| FTP user | didialmatykids_k |
| FTP pass | DiDi111222!@ |
| SSH | **CLOSED** (port 22 times out — use FTP only) |
| Web root | `/var/www/vhosts/didialmatykids.kz/httpdocs/` |

### Git → Auto Deploy
- **GitHub repo**: https://github.com/baproger/didikidsalmaty
- **Branch**: main
- Plesk pulls from GitHub → deploys to `/httpdocs` automatically
- GitHub webhook → `https://nturbo-2.hoster.kz:8443/modules/git/public/web-hook.php?uuid=3`
- Post-deploy actions in Plesk:
  ```bash
  cd /var/www/vhosts/didialmatykids.kz/httpdocs && php artisan migrate --force && php artisan config:clear && php artisan cache:clear && php artisan view:clear
  ```

### GitHub Actions (deploy.yml)
- Runs on push to `main`
- Builds assets with `npm run build` (Node 24, npm cache enabled)
- Deploys only changed files + `public/build/` via lftp to FTP
- Timeout: 30 minutes (was 15 — increased because npm ci was slow)
- **Note**: GitHub Actions deploy and Plesk auto-deploy both run on push — they do different things:
  - GitHub Actions: builds JS/CSS assets → uploads via FTP
  - Plesk: git pull → runs artisan commands

### Manual FTP deploy (when needed)
```bash
lftp -u didialmatykids_k,'DiDi111222!@' 185.98.5.104 << 'EOF'
set ftp:ssl-allow no
put local/path/to/file.php -o httpdocs/path/to/file.php
EOF
```

---

## Current Status

| Feature | Status |
|---------|--------|
| Homepage | Working |
| Blog | Working |
| Teachers | Working |
| Gallery | Working |
| Contact form | Working |
| Dynamic CMS pages (Page Builder) | Working |
| Admin panel (Filament) | Working |
| RU/KK/EN localization | Working |
| Age groups block | Working — KK group shown first |
| Priorities block icons | Fixed (emoji encoding workaround applied) |
| Hero banner per-language links | Working |
| Plesk auto-deploy on git push | Configured (webhook + post-deploy actions) |

---

## Completed Work (this session)

1. **Kazakh age group moved first** on homepage (`resources/views/home/index.blade.php`)
2. **Hero banner: per-language button links** — added `btn_url_ru`, `btn_url_kk`, `btn_url_en` fields instead of single `btn_url`
3. **Priorities emoji fix** — fallback logic in HomeController when DB returns broken emoji
4. **GitHub Actions timeout fix** — increased to 30m + added npm cache
5. **Plesk webhook + post-deploy actions** — configured for full auto-deploy

---

## Modified Files

| File | What changed |
|------|-------------|
| `resources/views/home/index.blade.php` | Swapped KK and RU age group blocks (KK first) |
| `app/Filament/Resources/PageResource.php` | Replaced single `btn_url` with `btn_url_ru`, `btn_url_kk`, `btn_url_en` in hero block |
| `resources/views/pages/blocks/hero.blade.php` | `$btnUrl` now resolves by locale: `btn_url_{locale}` → fallback `btn_url_ru` → fallback `btn_url` |
| `app/Http/Controllers/Frontend/HomeController.php` | Added emoji validation loop — restores default icons if DB returns broken/empty emoji |
| `.github/workflows/deploy.yml` | timeout 15→30min, added `cache: 'npm'` and `--prefer-offline` |
| `database/migrations/2026_06_03_100000_fix_priorities_emoji_encoding.php` | Deletes corrupted `priorities` setting from DB (requires `php artisan migrate`) |

---

## Known Issues

### 1. Priorities emoji corrupted in DB
- **Cause**: MySQL on server doesn't store 4-byte UTF-8 emoji (needs `utf8mb4`). Emojis like `🎓 💚 🏠 🛡️ 🍎` were saved as empty strings. Only `❤️` survived (3-byte).
- **Workaround applied**: HomeController checks if icon is empty/ASCII-only → substitutes from hardcoded defaults.
- **Proper fix**: Run `php artisan migrate` to execute `2026_06_03_100000_fix_priorities_emoji_encoding.php` which deletes the corrupted DB record.

### 2. Plesk Laravel Toolkit — artisan runs from wrong path
- **Cause**: Plesk Laravel Toolkit points to `/var/www/vhosts/didialmatykids.kz/` instead of `/httpdocs/`
- **Workaround**: Always use full path: `php /var/www/vhosts/didialmatykids.kz/httpdocs/artisan <command>`
- **Or**: Use post-deploy action with `cd /var/www/vhosts/didialmatykids.kz/httpdocs && php artisan ...`

### 3. SSH access unavailable
- Port 22 times out. All server file operations must go through FTP.
- Use `lftp` for scripted uploads.

---

## Failed Attempts

| Attempt | Why it failed |
|---------|---------------|
| Running `php artisan migrate` in Plesk Laravel Toolkit | Toolkit runs from wrong dir (no `vendor/autoload.php` at root) |
| `ssh didialmatykids_k@185.98.5.104` | Port 22 closed/firewalled |
| GitHub Actions under 15min timeout | `npm ci` + `npm run build` exceeded limit without cache |

---

## Database

- **Settings table** stores JSON values — emoji in JSON values are corrupted if MySQL charset is not `utf8mb4`
- **Translatable fields** use Spatie Laravel Translatable — stored as JSON: `{"ru":"...", "kk":"...", "en":"..."}`
- **Media** handled by Spatie Media Library — files in `storage/app/public/`
- **Cache/Session/Queue** use database driver in production

---

## Architecture Notes

- All content-editable text goes through `Setting::get(key, default)` with 1-hour cache
- Page Builder blocks: stored as JSON in `pages.blocks`, rendered via `pages/blocks/{type}.blade.php`
- Hero banner block supports: image, style (green/dark/light), title/subtitle/btn_text/btn_url per language
- Age groups are hardcoded in HomeController (not DB) — KK group listed first
- Priorities are DB-backed via `settings` table but fall back to HomeController defaults

---

## Next Steps

1. **Run pending migration** on server: `php artisan migrate --force` (fixes priorities emoji in DB permanently)
2. **Verify Plesk webhook** works — make a test commit and check if Plesk auto-deploys
3. **Test all 3 language switches** (RU/KK/EN) on homepage, blog, and CMS pages
4. **Hero banner**: fill in `btn_url_kk` and `btn_url_en` fields in admin for existing banners
5. **Email config**: currently on `log` driver — configure SMTP for contact form to actually send emails
6. **Storage symlink**: verify `storage:link` is set up on server (`public/storage` → `storage/app/public`)
