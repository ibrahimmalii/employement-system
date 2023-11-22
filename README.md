# Employment-system Task

## Installation

First clone the repository.

```
git clone https://github.com/ibrahimmalii/employement-system.git
```

Then copy the .env.example file to .env file.

```
cp .env.example .env
```

Then install the dependencies.

```
composer install
```

Then generate the application key.

```
php artisan key:generate
```

Then run this command to start the server with docker.

```
docker-compose up -d
```

Then create a database and add the database credentials to the .env file and migrate it with seeders.

```
php artisan migrate --seed
```



Then go to the browser and type the following url.

```
http://localhost/
```

Login with the following credentials.

```
email: admin@admin.com
password: a801B997C607328
```

NOW YOU CAN USE THE APPLICATION. :)
