# Nova Cpanel Mail Tool

A Laravel Nova tool that integrate with Cpanel Mail to manage Email Addresses:

- List and search email addresses
- Create a new email address
- Delete an existing email address

## Installation:

You can install the package in to a Laravel app that uses Nova via composer:

```bash
composer require naif/cpanel-mail
```

## Usage:
Add the below to app/Providers/NovaServiceProvder.php

```php
  public function tools()
  {
      return [
           new CpanelMail()
      ];
  } 
```

Add the below to your .env file

```php
CPANEL_DOMAIN=domain.com
CPANEL_HOST=https://domain.com
CPANEL_PORT=2083
CPANEL_USERNAME=user
CPANEL_PASSWORD=password
```
## Screenshots

<img src="https://raw.githubusercontent.com/naifalshaye/nova-cpanel-mail/master/screenshots/add.png" width="800">

<img src="https://raw.githubusercontent.com/naifalshaye/nova-cpanel-mail/master/screenshots/list.png" width="800">

## Support:
naif@naif.io

https://www.linkedin.com/in/naif

## License:
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
