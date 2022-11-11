# Hot Metal Market (Backend) - Laravel

# Introduction
This application serves as a backend for the next-js frontend counterpart https://github.com/chrismcintosh/hot-metal-market-frontend.
It uses Laravel Filament as an admin panel to manage products.

# What to Know

## Payments
This application uses Stripe to process payments. You'll need to populate your stripe credentials into the `.env` file.

### How do Payments Work?
All the payment data is handled using webhooks you can find the webhooks in `/app/Jobs/StripeWebhooks/`.
## Getting Started
You'll need to have a valid Laravel environment to run it in. For M1 Macs I find Laravel Valet with DBngin to work well. For Intel Macs Laravel Homestead worked well for me.

Once you have a Laravel environment set up and the project cloned

1. Run `composer install` from the root directory
2. Run `npm install` from the root directory
3. Run `php artisan migrate:fresh --seed` this should migrate the database and run the initial database seed. The email in the seeder is set to `sample@example.com` and the password is `password`