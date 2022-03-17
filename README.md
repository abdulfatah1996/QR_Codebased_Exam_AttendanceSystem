
## About App QR Code-based Exam Attendance System using Laravel 9

The code is a site to add exams and register students' attendance through a special code generated from their university number.

## Application requirements

- **[Node.js](https://nodejs.org/en/)**
- **[composer](https://getcomposer.org/)**
- **[xampp server v8.1](https://www.apachefriends.org/index.html)**
- **[laravel 9](https://laravel.com/)**
- **[Visual Studio Code](https://code.visualstudio.com/)**

## Application Install
- git clone https://github.com/abdulfatah1996/QR_Codebased_Exam_AttendanceSystem.git
- cd QR_Codebased_Exam_AttendanceSystem
- composer install
- copy .env.example to .env
- php artisan key:generate
- create database name qr_system on xampp server http://localhost/phpmyadmin/index.php?route=/server/databases.
- php artisan migrate:fresh
- php artisan db:seed
- php artisan serve
- http://localhost:8000 on browser
- You have two accounts to login email : administrator@gmail.com | password : administrator or email : teacher@gmail.com | password : teacher.

## Application Run
- https://www.youtube.com/watch?v=Pvi249pysaQ.

