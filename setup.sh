#!/usr/bin/env bash
# ---------------------------------------------------------------
# Laravel Starter – one-command project setup
# Usage: bash setup.sh [--demo] [--skip-npm]
# ---------------------------------------------------------------

set -e

echo ""
echo "╔════════════════════════════════════════════════════╗"
echo "║                                                    ║"
echo "║        Laravel Starter – Project Setup             ║"
echo "║                                                    ║"
echo "╚════════════════════════════════════════════════════╝"
echo ""

# Install PHP dependencies
echo "→ Installing Composer dependencies..."
composer install --no-interaction --prefer-dist

# Run the interactive Artisan setup wizard (handles .env, DB, migrations, seed, npm)
echo ""
echo "→ Running setup wizard..."
php artisan starter:install "$@"
