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
```
composer require octopouce-mu/avertising-bundle
```
Composer will install the bundle to your project's `vendor/` directory.

### Step 3: Setting AdminBundle
You go to the documentation [OctopouceAdminBundle](http://packagist.org/packages/octopouce-mu/admin-bundle).

### Step 4: Import Octopouce Advertising routing file
Now that you have activated and configured the bundle, all that is left to do is import the routing files.
```yaml
# config/routes/octopouce.yaml

_octopouce_advertising:
    resource: "@OctopouceAdvertisingBundle/Resources/config/routing.yaml"
```

### Step 5: Publish the Assets
Now that you have activated and configured the bundle, all that is left to do is import the routing files.
```
php bin/console assets:install --symlink
```

### Step 6: Add adzone in page
Array Twig Exemple : 
```twig
{{ adzone("Exemple") }}
```

HTML Exemple : 
```twig
{{ adzone("Exemple", true)|raw }}
```

