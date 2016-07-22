# [Laravel 5.* Boilerplate](http://laravel-boilerplate.com) Installer

This is a command line installer for the Laravel 5 Boilerplate project that gives you a step by step wizard for installation instead of doing it manually.

## How To Use

First, download the Laravel installer using Composer:

```composer global require "rappasoft/laravel-boilerplate-installer"```

Make sure to place the ```~/.composer/vendor/bin``` directory (or the equivalent directory for your OS) in your PATH so the ```boilerplate``` executable can be located by your system.

Once installed, the ```boilerplate new``` command will create a fresh Laravel Boilerplate installation in the directory you specify.

If you leave the directory out it will install in the current working directory.

For example:

```boilerplate new mywebsite```

Will install in a new folder called ```mywebsite``` using the current working directory as the base.

It will take you through the following steps:

- Download
- Composer Install
- NPM Install
- Running Gulp
- Generate the Key
- Set the Namespace
- Connect to the Database
- Set the Administrator Account
- Seed the Database

Not all steps are required an it will ask you along the way.

**This has only been tested on Laravel Homestead and not MAMP/XXAMP**