# FoodConnect.ci

**FoodConnect.ci** est une application web qui vise à faciliter la mise en relation entre les vendeurs de produits alimentaires et les consommateurs. Elle permet de découvrir des vendeurs, de consulter leurs produits et de faciliter les échanges entre acheteurs et vendeurs.

## Présentation du projet

FoodConnect.ci a pour objectif de rapprocher les acteurs du secteur alimentaire grâce au numérique, en proposant une plateforme accessible permettant aux consommateurs de découvrir les offres disponibles et de contacter directement les vendeurs.

## Fonctionnalités principales

### Pour les consommateurs
- Découvrir les produits alimentaires disponibles.
- Consulter les informations des vendeurs.
- Rechercher des vendeurs selon leur commune.
- Contacter directement les vendeurs.
- Effectuer une prise de contact ou une demande de commande via WhatsApp.

### Pour les vendeurs
- Disposer d'un espace dédié sur la plateforme.
- Présenter leurs produits.
- Rendre leurs offres visibles auprès des consommateurs.
- Faciliter les échanges avec les clients via WhatsApp.

## Technologies utilisées

| Technologie | Utilisation |
|---|---|
| PHP | Langage de programmation backend |
| Laravel 12 | Framework backend |
| Laravel Breeze | Authentification |
| Blade | Moteur de templates |
| Tailwind CSS | Mise en forme et design |
| JavaScript | Interactions côté client |
| Vite | Compilation des ressources frontend |
| Lucide | Icônes |
| MySQL 

## Identité visuelle

L'interface de FoodConnect.ci repose sur une identité visuelle composée de :

- Orange : couleur principale.
- Blanc : clarté et lisibilité.
- Noir : contraste et hiérarchie visuelle.

**Typographies :**
- Lobster
- Poppins

## Installation du projet

### 1. Prérequis

Avant de commencer, assurez-vous de disposer des outils suivants :

- PHP compatible avec Laravel 12.
- Composer.
- Node.js et npm.
- Un serveur de base de données compatible avec Laravel.
- Git.

### 2. Cloner le dépôt

```bash
git clone 
```

Accéder au projet :

```bash
cd FoodConnect
```

### 3. Installer les dépendances PHP

```bash
composer install
```

### 4. Installer les dépendances JavaScript

```bash
npm install
```

### 5. Configurer l'environnement

Copier le fichier d'environnement :

```bash
cp .env.example .env
```

Générer la clé de l'application :

```bash
php artisan key:generate
```

Configurer les informations de connexion à la base de données dans le fichier `.env`.

### 6. Exécuter les migrations

```bash
php artisan migrate
```

### 7. Lancer le projet

Démarrer le serveur Laravel :

```bash
php artisan serve
```

Lancer Vite dans un autre terminal :

```bash
npm run dev
```

L'application sera accessible à l'adresse :

http://127.0.0.1:8000

## Structure du projet

FoodConnect.ci suit l'organisation standard d'une application Laravel 

## État du projet

Projet en développement.

Les fonctionnalités et améliorations sont progressivement intégrées à l'application.

## Auteur

Projet de soutenance développé dans le cadre de la conception d'une solution numérique dédiée à la mise en relation des vendeurs de produits alimentaires et des consommateurs.


**FoodConnect.ci – Connecter les vendeurs aux consommateurs.**
