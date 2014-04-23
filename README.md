# iziBoard

## Currently under development...

## Installation iziBoard

* Add to composer.json
```"wetcat/board": "dev-master"```

* Add service providers ```'Wetcat\Board\BoardServiceProvider',``` and ```'Cartalyst\Sentry\SentryServiceProvider',```

* Add aliases ```'Sentry' => 'Cartalyst\Sentry\Facades\Laravel\Sentry',```

* Run ```composer install``` or ```composer update```

* Publish the package assets using artisan ```php artisan asset:publish wetcat/board```

* Publish the package config ```php artisan config:publish wetcat/board```

* This package uses it's own routes, you must remove the root ('/') route in laravel.

* Run database migrations ```php artisan migrate --package=cartalyst/sentry``` and ```php artisan migrate --package="wetcat/board"```

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

## Credits

### Frameworks used for iziBoard

* [AngularJS](https://angularjs.org/)
* [Laravel](http://laravel.com/)
* [Bootstrap](http://getbootstrap.com/)

#### Angular directives and libraries used to produce iziBoard

* [UI Bootstrap](http://angular-ui.github.io/bootstrap/)
* [AngularJS directives for Google Maps](https://github.com/nlaplante/angular-google-maps.git)
* [angular-file-upload](https://github.com/danialfarid/angular-file-upload)
* [angular-tagger](https://github.com/monterail/angular-tagger)
* [angular-sanitize](http://angularjs.org)
* [angular-google-maps](https://github.com/nlaplante/angular-google-maps.git)
* [showdown](http://www.attacklab.net/)
* [angular-hotkeys](https://chieffancypants.github.io/angular-hotkeys)
* [underscore](http://underscorejs.org)
* [elastic](https://github.com/monospaced/angular-elastic/blob/master/elastic.js)