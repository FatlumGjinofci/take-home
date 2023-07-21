Steps to start take-home project in your machine

1.`composer install`.
<br>
2.Copy, paste `.env.example` to `.env` and change the `QUEUE_CONNECTION=database`, also check `DB_DATABASE=take_home` variable.
<br>
3.run `php artisan:migrate`.
<br>
You can see all the possible combinations if you visit the route `http://take-home.test/comment-combinations`.
<br>
I've taken care of it already and created a file in `/config/data.php`, an array that returns all the possible combinations.
<br>
4.The seeding command, 2 seeds will be executed, `PostSeeder`, `CommentsSeeder`, comments seeder inserts data as chunks, to improve the performance.
5.run `php artisan db:seed`.
<br>
<br>
<br>
<br>
