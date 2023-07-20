Steps to start take-home project in your machine

1.composer install.
2.copy, paste `.env.example` to `.env` and change the `QUEUE_CONNECTION=database`, also check `DB_DATABASE=take_home` variable.
3.run `php artisan:migrate`.
4.run `php artisan db:seed`.

You can see all the possible combinations if you visit the route `http://take-home.test/comment-combinations`.

I've taken care of it and created a file in `/config/data.php`, an array that returns all the possible combinations.
To insert all the combinations:
5.run command `php artisan load:dataset`.
6.then run command: `php artisan queue:work`, all the comments will be inserted using a Job.

Enjoy It.
