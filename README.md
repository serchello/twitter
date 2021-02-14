# TWITTER

## About Installation

1) git clone git@github.com:sergios1983/twitter.git
2) Connect with your locally DataBase (look env.)
   -  DB_DATABASE=
   -  DB_USERNAME=
   -  DB_PASSWORD=

    and for MAILTRAP (get after registration)
   -  MAIL_USERNAME=
   -  MAIL_PASSWORD=

3) From root project run > npm install 
4) From root project run > composer install 
5) From root project run > php artisan serve (open http://127.0.0.1:8000)
6) Now we need create necessary tables (Database > Migrations). From root project run >> php artisan migrate --seed 
We created Tables and inserted some example data., actually we created User with email ser@ser.com and password 'secret'.
Now, in http://127.0.0.1:8000 you can create new user, please do it
7) I recommend run this code 
- ALTER IGNORE TABLE `followers` ADD UNIQUE KEY(user_id, follower_id);
- ALTER IGNORE TABLE `followings` ADD UNIQUE KEY(user_id, following_id);
in your SQL for delete pare keys.
8) This project can being tested now

## Run test
From root project run (UserControllerTest.php i did only basic (9))
- ./vendor/bin/phpunit

## FOR API 
-  http://127.0.0.1:8000/api/users
-  http://127.0.0.1:8000/api/statistics


## MY COMMENTS
* Add validation on post new tweet. Allow only 140 characters  << created with validate(Rule Laravel) and html limit input
* On the timeline page, the user should see a list of all tweets from users who follow  --  created 2 functionality, because i didnt understand (Followers or Following)
* Style pages with Material UI
* Create a table in a database where the developer should store every page the user has visited and DateTime forevery record (Log_activities)
* Cache api results for 1 minute.(file cache).
* All images and avatar stored path -- public/images/<user_name>
* Dont forget enable extension  "extension=gd"  << php.ini for images (ratio)
* Images for testing you can find Public/Example_Image