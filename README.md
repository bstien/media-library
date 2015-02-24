# Laravel Media Library

The goal of this package is to keep control and tidyness in your media library. As of now, only TV-shows are supported. Movies will be in the future.

**NB! This package is made for [Laravel 5](http://laravel.com/).**

## Library structure
```
[media root]
  Serie
    Season
      Episode
```

## Install
Require the package in your composer.json
```json
"require": {
    "bstien/media-library": "dev-master"
},
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/bstien/media-library"
    }
]
```

Publish configuration and run migrations in Laravel 5:
``` bash
php artisan vendor:publish
php artisan migrate
```

Edit the configfile:
``` bash
vim config/medialibrary.php
```

## Usage
### Library
```php
use Stien\MediaLibrary\Facades\Library
```
This is the main class used to keep control of your library and access TvDb-API.
It's a facade, and should be registered in `app/config.php` for simplicity.

### TvDb
[TheTVDB.com](http://thetvdb.com/) is used to scrape information about the series. Be sure to get an API-key for their services [here](http://thetvdb.com/?tab=apiregister) and place this in the config-file.

It's API is reachable via `Library::tvdb()`. See [Moinax/TvDb](https://github.com/Moinax/TvDb) for API-reference.
```php
# Search for serie.
$res = Library::tvdb()->getSeries("Modern Family");
foreach($res as $serie)
{
    echo $serie->name.'</br>';
}

# Save series- and episodes-info to DB.
# In this case, the first match from our search.
$res = Library::tvdb()->getSeries("Modern Family");
Library::tvdb()->createOrUpdate($res[0]->id);
```
