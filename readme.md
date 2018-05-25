# Blog
Live site at https://blog1.nathandemo.com

This site is built using Laravel 5.6, Vuejs, and Bootstrap 4 and is simply full of dummy data for now to demonstrate functionality. 
You can check out more by logging in as the demo user: 

email: demouser@nathanhaley.com

password: pass123 

Please feel free to submit a comment and edit it, create a post and edit it, follow/unfollow another user, like/unlike a comment/post/auther. And more. 

Note: You can create an account from scratch but you will need to validate your email before being able to add posts or comments. 

## Installation
 
### Prerequisites

* To run this project, you must have PHP 7 installed.
* You should setup a host on your web server for your local domain. For this you could also configure Laravel Homestead or Valet. 
* If you want use Redis as your cache driver you need to install the Redis Server. You can either use homebrew on a Mac or compile from source (https://redis.io/topics/quickstart). 

### Step 1

Begin by cloning this repository to your machine, and installing all Composer & NPM dependencies using Yarn.

```bash
git clone git@github.com:NathanHaley/laravel_blog_1.git
cd blog && composer install && yarn install
yarn run dev
```

### Step 2

* Modify the .env and .env.testing files as needed for database, logging, mail, cache, etc.
* Main configuration file is config/blog.php. This is where you can add administrator emails, they must also be registered as a user.


### Step 3

Next, boot up a server and visit your forum. If using a tool like Laravel Valet, of course the URL will default to `http://blog.test`. 

### Step 4

The configuration file is at config/blog.php