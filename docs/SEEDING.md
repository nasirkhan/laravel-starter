# Database Seeding

**Note:** This document has been consolidated into the main [README.md](../README.md#database-seeding) file for better discoverability.

## Quick Reference

For detailed seeding documentation, please refer to the [Database Seeding section in README.md](../README.md#database-seeding).

### Essential Commands

```bash
# Full seeding (essential + dummy data)
php artisan migrate:fresh --seed

# Essential data only
SEED_DUMMY_DATA=false php artisan migrate:fresh --seed

# On-demand demo data
php artisan laravel-starter:insert-demo-data --fresh
```

For complete documentation including all options, environment variables, and examples, see [README.md](../README.md#database-seeding).