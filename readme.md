# Blog

Just a playground to trying out ideas and learning Laravel(5.6). 

Live site at http://159.89.227.137

## Installation
 
### Prerequisites

* To run this project, you must have PHP 7 installed.
* You should setup a host on your web server for your local domain. For this you could also configure Laravel Homestead or Valet. 
* If you want use Redis as your cache driver you need to install the Redis Server. You can either use homebrew on a Mac or compile from source (https://redis.io/topics/quickstart). 

### Step 1

Begin by cloning this repository to your machine, and installing all Composer & NPM dependencies using Yarn.

```bash
git clone git@github.com:NathanHaley/blog.git
cd blog && composer install && yarn install
yarn run dev
```

### Step 2

* Modify the .env and .env.testing files as needed for database, logging, mail, cache, etc.
* Main configuration file is config/blog.php. This is where you can add administrator emails, they must also be registered as a user.


### Step 2

Next, boot up a server and visit your forum. If using a tool like Laravel Valet, of course the URL will default to `http://blog.test`. 

### Step 3

The configuration file is at config/blog.php