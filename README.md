##Installation guides

    1. clone the repository using the command
        `git clone https://github.com/hamalaG/biometrichealthcard.git`
    2. Navigate to the project's directory using the command `cd biometrichealthcard`
    3. Run `composer update` to load dependencies
    4. Run `cp .env.example .env` to generate an environment file
    5. In the `.env` file put in appropriate credentials for DB_DATABASE, DB_USERNAME and DB_PASSWORD
    6. Create the corresponding database in your DBMS
    7. Run migrations using `php artisan migrate`
    8. Run the application `php artisan serve`
