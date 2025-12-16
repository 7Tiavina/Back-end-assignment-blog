# Backend Test – API Blog (Laravel + Docker)

Ce projet est une API REST développée avec Laravel pour la gestion des articles d'un blog. Il a été conçu pour démontrer les compétences en développement backend, notamment sur l'écosystème Laravel, la création d'API RESTful, l'utilisation de Docker et les tests automatisés.

---

## Table des matières

1.  [Stack Technique](#-stack-technique)
2.  [Installation et Lancement](#-installation-et-lancement)
3.  [Tests de l'API](#-tests-de-lapi)
4.  [Documentation des Endpoints](#-documentation-des-endpoints-de-lapi)

---

## 🧱 Stack Technique

*   **PHP** : 8.2
*   **Framework** : Laravel 12
*   **Base de données** : MySQL 8
*   **Conteneurisation** : Docker & Docker Compose
*   **Architecture** : API REST, structure MVC
*   **Accès aux données** : Le projet utilise le façade `DB` de Laravel pour exécuter des requêtes SQL brutes, privilégiant le contrôle direct sur les interactions avec la base de données plutôt que l'ORM Eloquent.

---

## 🚀 Installation et Lancement

Suivez ces étapes pour lancer l'application localement avec Docker.

### 1. Prérequis

*   **Docker Desktop** : Assurez-vous qu'il est installé et en cours d'exécution.
*   **Ports disponibles** : Les ports `8000` (API) et `3306` (MySQL) ne doivent pas être utilisés par d'autres services.

### 2. Cloner le dépôt

```bash
git clone <https://github.com/7Tiavina/Back-end-assignment-blog.git>
cd <backend-test-fintrellis>
```

### 3. Fichier d'environnement

Créez votre fichier d'environnement local en copiant l'exemple fourni. Aucune modification n'est nécessaire pour la configuration Docker par défaut.

```bash
cp .env.example .env
```

### 4. Démarrer les conteneurs

Construisez l'image et lancez les conteneurs Docker en mode détaché.

```bash
docker compose up --build -d
```

L'API sera accessible à l'adresse [http://localhost:8000].

### 5. Initialiser la base de données

Après le premier lancement, exécutez les migrations Laravel pour créer la table `postes`.

```bash
docker compose exec app php artisan migrate
```

⚠️ **Important** : Sans cette étape, l'API retournera des erreurs 500 car la db n'existera pas.

---

## 🧪 Tests de l'API

Le projet inclut des tests fonctionnels (PHPUnit) qui couvrent les endpoints de l'API pour garantir leur bon fonctionnement.

Pour lancer la suite de tests, exécutez la commande suivante depuis votre terminal :

```powershell
docker compose exec app php artisan test
```

---

## Endpoints de l'API

L'URL de base pour tous les endpoints est `http://localhost:8000/api`.

### 1. Lister tous les articles

*   **Méthode** : `GET`
*   **Endpoint** : `/allPostes`
*   **Description** : Récupère la liste de tous les articles.

*   **Réponse de succès (200 OK)** :

```json
[
    {
        "id": 1,
        "titre": "Mon premier article",
        "contenu": "Le contenu de mon article...",
        "created_at": "2023-10-27T10:00:00.000000Z",
        "updated_at": "2023-10-27T10:00:00.000000Z"
    }
]
```

### 2. Créer un article

*   **Méthode** : `POST`
*   **Endpoint** : `/postes`
*   **Description** : Crée un nouvel article.

*   **Corps de la requête (`application/json`)** :

| Champ     | Règles de validation        | Exemple                 |
| :-------- | :-------------------------- | :---------------------- |
| `titre`   | `required`, `string`, `max:255` | "Un titre accrocheur"   |
| `contenu` | `required`, `string`            | "Le début d'une histoire." |

*   **Réponse de succès (201 Created)** :

```json
{
    "message": "Poste inserré"
}
```

*   **Réponse d'erreur (422 Unprocessable Entity)** - Validation échouée :

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "titre": [
            "The titre field is required."
        ]
    }
}
```

### 3. Récupérer un article spécifique

*   **Méthode** : `GET`
*   **Endpoint** : `/postes/{id}`
*   **Description** : Récupère un article par son identifiant.

*   **Paramètres d'URL** :

| Paramètre | Type    | Description                |
| :-------- | :------ | :------------------------- |
| `id`      | `integer` | L'identifiant de l'article |

*   **Réponse de succès (200 OK)** :

```json
{
    "id": 1,
    "title": "Mon premier article",
    "content": "Le contenu de mon article...",
    "created_at": "2023-10-27T10:00:00.000000Z",
    "updated_at": "2023-10-27T10:00:00.000000Z"
}
```

*   **Réponse d'erreur (404 Not Found)** - Article non trouvé :

```json
{
    "message": "Erreur,Poste introuvable"
}
```

### 4. Mettre à jour un article

*   **Méthode** : `PUT`
*   **Endpoint** : `/postes/{id}`
*   **Description** : Met à jour un article existant.

*   **Paramètres d'URL** :

| Paramètre | Type    | Description                |
| :-------- | :------ | :------------------------- |
| `id`      | `integer` | L'identifiant de l'article |

*   **Corps de la requête (`application/json`)** :

| Champ     | Règles de validation              | Exemple                   |
| :-------- | :-------------------------------- | :------------------------ |
| `titre`   | `required`, `string`, `min:3`, `max:255` | "Un meilleur titre"       |
| `contenu` | `required`, `string`, `min:10`           | "Un contenu plus détaillé." |

*   **Réponse de succès (200 OK)** - Retourne l'article mis à jour :

```json
{
    "id": 1,
    "title": "Un meilleur titre",
    "content": "Un contenu plus détaillé.",
    "created_at": "2023-10-27T10:00:00.000000Z",
    "updated_at": "2023-10-27T11:30:00.000000Z"
}
```

*   **Réponse d'erreur (404 Not Found)** - Article non trouvé :

```json
{
    "success": false,
    "message": "Erreur, Poste introuvable"
}
```

### 5. Supprimer un article

*   **Méthode** : `DELETE`
*   **Endpoint** : `/postes/{id}`
*   **Description** : Supprime un article par son identifiant.

*   **Paramètres d'URL** :

| Paramètre | Type    | Description                |
| :-------- | :------ | :------------------------- |
| `id`      | `integer` | L'identifiant de l'article |

*   **Réponse de succès (200 OK)** :

```json
{
    "success": true,
    "message": "Poste effacé"
}
```

*   **Réponse d'erreur (404 Not Found)** - Article non trouvé :

```json
{
    "success": false,
    "message": "Poste non trouvé , impossible de supprimer"
}
```