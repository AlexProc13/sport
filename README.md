## Installation by docker-compose (Only or development) //TO DO
- install docker and docker-compose
- set up .env file and set docker's data. Set ```APP_ENV```, ```APP_URL``` etc.
- set up .env file's in ```black-sport``` and ```front-sport```.

- install node packages:
```bash
docker-compose run --rm npm install
```
- build assets:
```bash
docker-compose run --rm npm run build
```
- build assets:
```bash
docker-compose run --rm npm run build
```
- run composer: 
```bash
docker-compose run --rm php composer install
```
- run migration:
```bash
sudo docker-compose exec php php artisan migrate
```
- set permissions (in back-sport directory):
```bash
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
```
