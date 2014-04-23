# iziBoard

## Currently under development...

## Installation

* Add to composer.json
```"wetcat/board": "dev-master"```

* Add service provider ```'Wetcat\Board\BoardServiceProvider',```

* Run ```composer install``` or ```composer update```

* Publish the package assets using artisan ```php artisan asset:publish wetcat/board```

* This package uses it's own routes, you must remove the root ('/') route in laravel.

## This package uses Intervention/Image 

* To publish the Intervention assets (not required) run ```php artisan asset:publish intervention/image```

## Configuration

This package comes with some configuration options, to change them for your installation run the following command.

* Get a local version of the configuration ```php artisan config:publish wetcat/board```

### Change core style

TODO
