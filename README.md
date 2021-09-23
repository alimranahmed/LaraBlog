[![MIT Licence](https://badges.frapsoft.com/os/mit/mit.svg?v=103)](https://opensource.org/licenses/mit-license.php)


# Blog Using Laravel 8
### Let's keep it as simple as possible. Configure anything you want
A full-featured blogging system for personal use. No frontend theme and anything heavy or unnecessary library used.

### Technologies used
1. Laravel
2. Livewire
3. TailwindCSS
 
### There are four several types of users with several permissions
1. Admin/Owner
  * Can manage articles and comments of other users.
  * Can manage categories.
  * Can manage keywords.
  * Can manage other users except Owner.
  
4. Reader
  * Can read and comment on article providing his email address.
  * Can subscribe to be notified for new articles.
  * Can search for articles.
  * Can navigate articles based on categories.

### Installation Process
1. Execute `git clone https://github.com/alimranahmed/LaraBlog.git` on your terminal to download this project.
2. Go to the project root directory and execute `composer install` to install all PHP dependencies of the project
3. Create a file named as .env and copy the content of .env.example to newly created .env file 
4. Then execute `php artisan key:generate` on your terminal/cmd to generate environment key
5. Then create a Database for this project and edit the .env file to authorized this project on your database. 
6. Execute `php artisan migrate:refresh --seed` terminal on your terminal.
7. Now you are ready to go, If you don't want to create any virtual host for this project then execute
  `php artisan serve`
8. Now visit the url shown on your terminal, something like `localhost:8000`. It's running!

### Screen shots

##### Home page
![home_page](https://user-images.githubusercontent.com/7629427/132961669-34f4161a-05e9-4fd6-aa32-d2b2f04134ab.png)

##### Single article view
![article_page](https://user-images.githubusercontent.com/7629427/132961667-d30aa00e-da49-4e5c-9bb6-9db9f048ee50.png)

### Contribution 
**Anyone is always welcome to contribute on the project. If you want to work with:**
1. Just create an issue(even if you want to fix the issue). 
2. After fixing any issue or adding any new feature just send a pull request.
3. I will be happy to add your code in order to enhance this project. 
Thanks.

##### License
[MIT](https://opensource.org/licenses/MIT)
