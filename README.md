Laravel Crud Generator GUI Builder
=====================================

[![Latest Stable Version](https://poser.pugx.org/crud/generator-builder/v)](//packagist.org/packages/crud/generator-builder)
[![Total Downloads](https://poser.pugx.org/crud/generator-builder/downloads)](//packagist.org/packages/crud/generator-builder)
[![Monthly Downloads](https://poser.pugx.org/crud/generator-builder/d/monthly)](//packagist.org/packages/crud/generator-builder)
[![Daily Downloads](https://poser.pugx.org/crud/generator-builder/d/daily)](//packagist.org/packages/crud/generator-builder)
[![License](https://poser.pugx.org/crud/generator-builder/license)](//packagist.org/packages/crud/generator-builder)


This Generator package provides various generators like CRUD, API, Controller, Model, Migration, View for your painless development of your applications.

## Requirements
    Laravel >= ^8.0
    PHP >= ^7.3

## Installation

### Install laravel 8

```
    composer create-project --prefer-dist laravel/laravel blog
```
### Install Jetstream with the Livewire stack...
```
    composer require laravel/jetstream

    php artisan jetstream:install livewire
```
### Install crud/generator-builder
```
    composer require crud/generator-builder
 
```
### Publish Layout
```
    php artisan crud:publish
  
    php artisan crud.publish:layout 
    php artisan crud.publish:layout --localized (For Localized Views, run it with the option --localized)
```
### Install npm
```
    npm install
    npm run dev
  
```

### Generator Commands

    Generator provides various commands to generate scaffold & apis.
  
    php artisan crud:api $MODEL_NAME  
    
    php artisan crud:scaffold $MODEL_NAME
    
    php artisan crud:scaffold $MODEL_NAME --datatables=true (Single Page crud with datatables)
    
    php artisan crud:api_scaffold $MODEL_NAME
 
## Exmple

``` php artisan crud:scaffold Blog --datatables=true ```


## Author


#### Ravi Navadiya :email: [Email Me](mailto:ravinavadiya786@gmail.com)

## License

This project is licensed under the MIT License - see the [License File](LICENSE) for details
