---
paths:
  - 'database/seeders/**'
---

# Seeders

## Permission naming convention: access_module
Permissions must be named as `{access}_{module}` using an underscore separator.
Standard access types: view, add, edit, delete, restore.
Examples: view_roles, add_posts, delete_categories, restore_users.
The roles permission form groups permissions by module name (everything after the first underscore) and renders them as a table with access types as columns.
