
first composer up 

.env example name change to .env

php artisan serve

php artisan migrate:fresh

php artisan db:seed --class=UsersTableSeeder

change Mail

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=jerinkm1010@gmail.com
MAIL_PASSWORD=iuoewlkwbxfvtngv
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=jerinkm10@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

php artisan queue:table

php artisan migrate

php artisan queue:work


E:\xamppes\htdocs\dynamic\CP3603\app\Jobs\SendFormCreatedNotification.php 

line 37 config email id 

login credentials

username : john@example.com

password : password
admin section 
http://127.0.0.1:8000/login

user section 
http://127.0.0.1:8000/users 
