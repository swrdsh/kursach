# Inventory Office Auth Module

First coursework milestone for the topic "Office equipment inventory".

Implemented in an object-oriented style:

- PDO bootstrap through `db.php`
- `users` table schema in `database/schema.sql`
- `equipment` table schema in `database/equipment.sql`
- `orders` table schema in `database/orders.sql`
- secure registration with password hashing
- login with sessions and `password_verify`
- protected profile page
- protected admin pages with RBAC
- equipment creation form for the office inventory registry
- public equipment listing with XSS-safe output
- equipment request flow for users and joined admin order view
- logout flow
- dynamic navigation for guest and authorized users

Server structure for Beget:

- `db.php` should stay one level above `public_html`
- files from `public_html/` should be uploaded into the site root on Beget
- copy `db.example.php` to `db.php` and fill in real MySQL credentials before запуском

Test accounts after seeding:

- `admin@shop.local` / `admin123`
- `client@shop.local` / `admin123`

Initialization flow:

1. Open `db.example.php`, set database credentials and a private `setup_token`
2. Save the file as `db.php`
3. Open `/setup.php?token=YOUR_PRIVATE_TOKEN`
4. Open `/setup_inventory.php?token=YOUR_PRIVATE_TOKEN`
5. Open `/setup_orders.php?token=YOUR_PRIVATE_TOKEN`
6. After that the authentication module, equipment registry, and request flow are ready for testing
