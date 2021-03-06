# iziBoard

## Currently under development...

## Installation iziBoard

* Create a laravel project ```composer create laravel/laravel my-project```

* Add to composer.json
```"wetcat/board": "dev-master"```

* Edit database configuration in ```my-project/app/config/database.php``` 

* Add service providers ```'Wetcat\Board\BoardServiceProvider',```

* Run ```composer update```

* Run ```php artisan izi:init```

* Edit ```my-project/app/config/packages/wetcat/board/config.php/```

* Remove the default root ```('/')``` route in ```my-project/app/routes.php``` because it will interfer with the routes in this package.

* Finally set the folder permissions for ```my-project/app/storage```

* Delete User.php

## Configuration

This package comes with some configuration options, to change them for your installation run the following command.

* Get a local version of the configuration ```php artisan config:publish wetcat/board```

### Change core style

#### Styles
The package uses Bootstrap for frontend, per default it will use the bootswatch CDN to load a Yeti theme. However, if you want to use a locally stored bootstrap stylesheet all you need to do is include either ```public/css/bootstrap.min.css``` or ```public/css/bootstrap.css files```, they will always have precedence over the CDN.

You can also change what bootstrap CDN to use in the config.

Note that if you're using a locally stored bootstrap stylesheet you will likely need to install the glyphicon set locally as well, bootstrap uses [Glyphicon halflings set](http://glyphicons.com/)

Recommended is to use [http://pikock.github.io/bootstrap-magic/app/index.html#!/editor](http://pikock.github.io/bootstrap-magic/app/index.html#!/editor) or similar tool to generate the css. Don't forget the fonts!

You can also add your own custom styles to ```public/css/my-project.css``` or ```public/css/my-project.min.css```, just make sure to set the my-project title in the config for your installation for this to work.

## Credits

### Frameworks used for iziBoard

* [AngularJS](https://angularjs.org/)
* [Laravel](http://laravel.com/)
* [Bootstrap](http://getbootstrap.com/)

#### Laravel packages used

* [Intervention/Image](http://image.intervention.io/)

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