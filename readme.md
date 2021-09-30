# SymForm

Projet à vocation pédagogique : Génération d'un site statique avec un Backend Notion pour la chaine YouTube [YoanDev](https://www.youtube.com/c/yoandevco)

## 👾 Environnement de développement

### 🏁 Pré-requis

* [Symfony CLI](https://symfony.com/download)
* [PHP 7.4](https://www.php.net/downloads)
* [Composer](https://getcomposer.org/)

### 🔥 Installer le projet en local

```bash
composer install
symfony serve -d
```

### ✅ Lancer la génération du site statique

```bash
bin/console dump-static-site
php -S localhost:8080 -t output
```