# PHP Coding Exercise – Integer manipulation
## Installation
```bash
git clone https://github.com/DShumkov/exercise.git
cd exercise
composer install
```
You can run it with your local php `php -S localhost:8081 -t ./public`

## Production improvements
To run this app in production environment I suggest to do:
* Put integer manipulations into model class
* Add tests for model
* Put the app into docker container
* Improve UI with intro, help messages, tooltips
* Build frontend with webpack
* Improve frontend validation
