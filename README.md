

php artisan serve

php artisan migrate:fresh

php artisan db:seed --class=UsersTableSeeder

username : john@example.com

password : password

change Mail

MAIL_MAILER=smtp MAIL_HOST=smtp.mailtrap.io MAIL_PORT=2525 MAIL_USERNAME=null MAIL_PASSWORD=null MAIL_ENCRYPTION=null MAIL_FROM_ADDRESS=example@example.com MAIL_FROM_NAME="${APP_NAME}"

//php artisan make:mail FormCreatedNotification

//php artisan make:job SendFormCreatedNotification

.env file. QUEUE_CONNECTION=database

php artisan queue:table

php artisan migrate

php artisan queue:work
