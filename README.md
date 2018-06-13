AdvertisingBundle
===============

Introduction
------------
This Symfony bundle offers a manage website advertising.

## Prerequisites

This version of the bundle requires Symfony Flex. 

##Installation

### Step 1: Download AdvertisingBundle using composer
This library is available on [Packagist](http://packagist.org/packages/octopouce-mu/advertising-bundle).

```js
composer require octopouce-mu/avertising-bundle
```

Composer will install the bundle to your project's `vendor/` directory.

### Step 2: Update database

```js
php bin/console doctrine:schema:update --force
```

### Step 3: Import Octopouce Advertising routing file
Now that you have activated and configured the bundle, all that is left to do is import the routing files.
```js
# config/routes/octopouce.yaml

_octopouce_advertising:
    resource: "@OctopouceAdvertisingBundle/Resources/config/routing.yaml"
```

### Step 4: Publish the Assets
Now that you have activated and configured the bundle, all that is left to do is import the routing files.
```js
php bin/console assets:install --symlink
```

### Step 5: Add adzone in page
Array Twig Exemple : 
```js
{{ adzone("Exemple") }}
```

HTML Exemple : 
```js
{{ adzone("Exemple", true)|raw }}
```

