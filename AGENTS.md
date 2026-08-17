# AGENTS.md

Laravel 10 (PHP 8.1) SPP fee-management app on the Stisla (Bootstrap 4) admin template, with Midtrans payment gateway for online SPP payments. Database is MySQL.

## Commands

- Setup: `composer install` → `npm install` → `npx mix` → `cp .env.example .env` → `php artisan key:generate` → `php artisan migrate --seed` → `php artisan serve`
- Assets: run `npx mix` after `npm install` — it copies node_modules packages into `public/library/`. Views load these via `asset('library/...')`. Vite (`npm run dev`/`build`) is configured but unused; no blade uses `@vite`.
- Lint: `vendor/bin/pint`
- Tests: `php artisan test` (uses MySQL; sqlite is commented out in `phpunit.xml`)

## Architecture

- Auth is session-based: `AuthController` calls `Auth::attempt` then sets `Session::put('cek', true)`; the `ValidasiUser` middleware guards all admin/dashboard routes by checking `Session('cek')`. It is NOT Laravel's standard `auth` middleware.
- Key models: `User` = siswa, `SppPlan` = SPP billing plan (no `Spp` model exists), `Payment` = fee record (`order_id`, `snap_token`, `status`).
- Payment flow: admin creates `Payment` records → siswa opens `payment_midtrans/create/{id}` → `MidtransController@create` fetches a Snap token → `checkout.blade.php` opens the Snap popup → Midtrans posts the status to `POST /payment_midtrans/notification`.
- Route syntax is inconsistent: admin routes use string syntax (`'PaymentController@index'`), the midtrans siswa routes use class-reference syntax (`[MidtransController::class, ...]`). Match the style of the group you're editing.

## Midtrans gotchas

- Midtrans keys live in `.env` (`MIDTRANS_SERVER_KEY`, `MIDTRANS_CLIENT_KEY`, `MIDTRANS_IS_PRODUCTION`). Current `.env` has sandbox keys; `checkout.blade.php` hardcodes the sandbox Snap URL (`app.sandbox.midtrans.com`). For production, switch both the env flags and this URL.
- `payments.status` is an ENUM `['unpaid','paid','pending']` (migration `2025_05_30_145005`), but `notificationHandler` also writes `challenge`, `denied`, `expired`, `canceled` — those writes fail under strict MySQL until the enum is widened.
- `POST /payment_midtrans/notification` is declared inside the `ValidasiUser` middleware group, so Midtrans server-to-server callbacks (which carry no session) get redirected to login and never reach the handler. It needs `->withoutMiddleware(['ValidasiUser'])`.
- `MidtransController` has a dead `use App\Models\Spp;` import; the model is `SppPlan`. It only breaks if actually referenced.
- `callback` is just a redirect target for Snap popup events (`onSuccess`/`onPending`/`onError`); it does not verify Midtrans signatures — trust the `notificationHandler` for authoritative status.