# Laravuecrud
### Dockerized Laravel/Vue.js project.
#### Notable components/plugins
1. Laravel
2. Vue.js
3. Vue-router
4. Axios

#### Deployment

```sh
$ git clone https://github.com/MamelWorks/Laravuecrud.git
$ docker-compose up -d
$ docker-compose exec app rm -rf vendor composer.lock
$ docker-compose exec app composer install
$ docker-compose exec app php artisan migrate
```


Verify the deployment by navigating to your server address in
your preferred browser.

```sh
localhost:8000
```

'Welcome to Home Component' should appear.
