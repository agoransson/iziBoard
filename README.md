# iziBoard

## Currently under development...

## Installation

* Add to composer.json
```"wetcat/board": "dev-master"```

* Add service provider ```'Wetcat\Board\BoardServiceProvider',```

* Run ```composer install``` or ```composer update```

* Publish the package assets using artisan ```php artisan asset:publish wetcat/board```

* Publish the package config ```php artisan config:publish wetcat/board```

* This package uses it's own routes, you must remove the root ('/') route in laravel.

* Run database migrations ```php artisan migrate --package="wetcat/board"```

## This package uses Intervention/Image 

* To publish the Intervention assets (not required) run ```php artisan asset:publish intervention/image```

## Configuration

This package comes with some configuration options, to change them for your installation run the following command.

* Get a local version of the configuration ```php artisan config:publish wetcat/board```

### Change core style

#### Styles
The package uses Bootstrap for frontend, per default it will use the bootswatch CDN to load a Yeti theme. However, if you want to use a locally stored bootstrap stylesheet all you need to do is include either ```public/css/bootstrap.min.css``` or ```public/css/bootstrap.css files```, they will always have precedence over the CDN.

You can also change what bootstrap CDN to use in the config.

Note that if you're using a locally stored bootstrap stylesheet you will likely need to install the glyphicon set locally as well, bootstrap uses [Glyphicon halflings set](http://glyphicons.com/)
