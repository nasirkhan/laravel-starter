# ---------------------------------------------------------------
# Laravel Starter – one-command project setup (Windows PowerShell)
# Usage: .\setup.ps1 [--demo] [--skip-npm]
# ---------------------------------------------------------------

$ErrorActionPreference = "Stop"

Write-Host ""
Write-Host "╔════════════════════════════════════════════════════╗"
Write-Host "║                                                    ║"
Write-Host "║        Laravel Starter – Project Setup             ║"
Write-Host "║                                                    ║"
Write-Host "╚════════════════════════════════════════════════════╝"
Write-Host ""

# Install PHP dependencies
Write-Host "→ Installing Composer dependencies..."
composer install --no-interaction --prefer-dist

# Run the interactive Artisan setup wizard (handles .env, DB, migrations, seed, npm)
Write-Host ""
Write-Host "→ Running setup wizard..."
php artisan starter:install @args
