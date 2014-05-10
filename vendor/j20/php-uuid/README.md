PHP UUID
========

Generate a UUID v4 (psuedo random) using PHP.

### Installation:

Using a command line interface, change into the root directory of your project and then run the following command to install the package via Composer:

```
composer require j20/php-uuid:dev-master
```

If using the Laravel framework, open app/config/app.php and add the following within your 'aliases' array:

```
'Uuid'            => 'J20\Uuid\Uuid',
```

### Usage:

```PHP
Uuid::v4();  // E.g. 5c01e9be-008f-45eb-811a-639df3c56f7d
Uuid::v4(false); // E.g. 5c01e9be008f45eb811a639df3c56f7d
```
