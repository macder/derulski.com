# derulski.com

WordPress + Twig + Pattern-Lab

Personal site using Atomic Design workflow in WP

https://derulski.com

[Pattern library](https://pattern-lab.derulski.com/)

## Stack

WordPress<br>
Pattern Lab Twig Edition<br>
InuitCSS<br>
Webpack

## UI Source Quick Links

**Global**<br>
[Styles](https://github.com/macder/derulski.com/tree/develop/ui/src/styles)<br>
[Scripts](https://github.com/macder/derulski.com/tree/develop/ui/src/scripts)

**Features**<br>
[Patterns](https://github.com/macder/derulski.com/tree/develop/ui/src/patterns/_patterns)

**WP**<br>
[Theme](https://github.com/macder/derulski.com/tree/develop/wp/wp-content/themes/derulski)

## Install Local Dev

**Backend**

WordPress and dependencies(plugins) are installed using composer

From project root:
```sh
$ composer install
```

Database:
```sh
$ vagrant up
$ vagrant ssh

# Vagrant box
$ mysql -u root -proot scotchbox < derulski.sql
```

**Pattern Library**

*PHP 7 is required to run Pattern Lab Twig Edition*

```sh
$ cd ui/pattern-lab
$ composer install
```

**UI**

```sh
$ cd ui
$ npm install
```

## Run Local Dev

**WordPress**
```sh
$ vagrant up
```

Navigate to http://derulski.Local

**UI**

Start dev build and Pattern Lab
```sh
$ cd ui
$ npm start
```

Navigate to http://localhost:8080

In another terminal or tab start Browser Sync for Pattern Lab
```sh
$ cd ui
$ npm run dev:browsersync
```

## License

Derulski.com - Maciej Derulski's personal website UI

Copyright 2017-2018 by Maciej Derulski and contributors

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Wherever third party code has been used, credit has been given in the code's
comments.
