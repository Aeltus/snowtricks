# README

## 1 - Introduction :

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/391b82c1-07e0-4b4f-867c-90f3bda98d69/big.png)](https://insight.sensiolabs.com/projects/391b82c1-07e0-4b4f-867c-90f3bda98d69)

This project is an exercice for php / symfony developpement cursus.

You can find the result on : snowtricks.david-danjard.fr

You can find the differents steps I followed (in french) on my google drive : https://docs.google.com/document/d/1aW-uVnwYyqqIUXHV5Me9FfwSxytk6QkzY0daXqGzVxI/edit?usp=sharing

Source code is on GitHub : https://github.com/Aeltus/snowtricks

## 2 - requirements :

For this project, I used the following environnement :
- php >= 5.6
- redis server 3.2.100 (https://redis.io/download) 
- MySql 5.7.9

## 3 - Structure :
This is a Symfony 3.2 project, witch respect the standards for the structure.
It is divided into 4 bundles :
- ConsoleBundle : witch is for the command lines instructions
- CoreBundle : The core of the web site
- OAuthBundle : An external bundle for the facebook authentication
- UserBundle : A bundle for authentication with Guard.

## 4 - Installation :

1. clone this repository (master branch)
2. put it into your server root folder
3. into command line install vendors by using composer
- https://getcomposer.org/download/
- use this command in prompt : composer install
4. set de configuration into :
- /app/config/parameters.yml.dist and rename it in /app/config/parameters.yml

5. also in command line set the database by using this commands
- php bin/console doctrine:database:create
- php bin/console doctrine:schema:update --force
- php bin/console snowtricks:database:load

6. put assets in rights folders by using (in prompt)
- php bin/console assets/install

### Your web site is now up to date !!! :)

## 5 - Others :
