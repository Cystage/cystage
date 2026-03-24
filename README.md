![Svelte](https://img.shields.io/badge/Svelte-FF3E00?style=for-the-badge&logo=svelte&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![SQLite](https://img.shields.io/badge/sqlite-%2307405e.svg?style=for-the-badge&logo=sqlite&logoColor=white)

![Taille repo](https://img.shields.io/github/repo-size/BerretMan/cystage)

# Cystage

Le projet consiste à créer une application web permettant de simplifier et de centraliser la recherche de stage pour les étudiants de Cytech. Elle permettra également aux entreprises de diffuser des offres de stages ainsi qu’à l’administration de suivre les dossiers des étudiants.

## Framework 
Le projet utilise les frameworks suivants: 
- **Svelte**
- **Laravel**

## Installation et Setup du Framework 
Pour installer et setup tout les frameworks, voici les commandes: 

```console
sudo apt install npm
npm install
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.2/install.sh | bash
sudo apt install php-sqlite3
sudo apt install composer
composer global require laravel/installer
nvm install node
```

Puis dans le **dossier** du projet
```console
php artisan config:clear
php artisan migrate
```
## Prérequis

Pour lancer le projet, vous aurez besoin de 
- **PHP** (>= 8)
- **Nodejs** (>= 20.x)
- **Composer** 

## Lancer le projet 
Pour lancer le **front-end**, il faut executer

```console
composer run dev 
```

Pour lancer le **back-end**, il faut executer dans le dossier du projet 

```console
php artisan serve
```
