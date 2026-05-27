# Cahier des charges — XPULSE

## 1. Présentation du projet

**Nom** : XPULSE  
**Type** : Mini réseau social  
**Thème** : Plateforme de partage de contenu (posts, likes, commentaires)  
**Développeur** : Adam Rachid  

## 2. Objectif

Créer une application web moderne permettant aux utilisateurs de publier du contenu, interagir via des likes et des commentaires, et consulter les profils des autres membres.

## 3. Technologies utilisées

| Couche | Technologie |
|--------|-------------|
| Frontend | Vue.js 3, Quasar Framework |
| Backend | PHP 8 |
| Base de données | MySQL (via phpMyAdmin / WAMP) |
| Serveur local | WampServer |

## 4. Fonctionnalités

### 4.1 Fonctionnalités obligatoires

| # | Fonctionnalité | Statut |
|---|----------------|--------|
| 1 | Publication de contenu (titre, texte, image optionnelle) | ✅ |
| 2 | Système de likes | ✅ |
| 3 | Ajout et affichage de commentaires | ✅ |
| 4 | Fil d'actualité (ordre chronologique) | ✅ |
| 5 | Interface moderne et responsive | ✅ |
| 6 | Validation des données (JavaScript + PHP) | ✅ |
| 7 | Algorithme de tri (tri des posts par likes — bubble sort) | ✅ |

### 4.2 Fonctionnalités bonus

| # | Fonctionnalité | Statut |
|---|----------------|--------|
| 1 | Système de connexion / inscription | ✅ |
| 2 | Upload d'images | ✅ |
| 3 | Recherche (posts + utilisateurs) | ✅ |
| 4 | Mode sombre | ✅ |
| 5 | Page profil avec bio modifiable | ✅ |

## 5. Architecture du projet

```
xpulse/
├── backend/
│   ├── db.php                 → Connexion PDO à MySQL
│   ├── register.php           → Inscription d'un utilisateur
│   ├── login.php              → Connexion d'un utilisateur
│   ├── create_post.php        → Création d'un post (avec image)
│   ├── get_posts.php          → Récupération du fil d'actualité
│   ├── like.php               → Like / unlike un post
│   ├── add_comment.php        → Ajout d'un commentaire
│   ├── get_comments.php       → Récupération des commentaires
│   ├── get_profile.php        → Données du profil utilisateur
│   ├── update_bio.php         → Modification de la bio
│   ├── search.php             → Recherche posts et utilisateurs
│   ├── uploads/               → Dossier des images uploadées
│   └── xpulse.sql             → Script de création de la BDD
│
└── frontend/
    └── src/
        ├── pages/
        │   ├── IndexPage.vue       → Fil d'actualité + tri
        │   ├── LoginPage.vue       → Page de connexion
        │   ├── RegisterPage.vue    → Page d'inscription
        │   ├── CreatePostPage.vue  → Formulaire de publication
        │   └── ProfilePage.vue     → Page profil
        ├── components/
        │   └── PostCard.vue        → Composant post (likes, commentaires)
        └── router/
            └── routes.js           → Définition des routes
```

## 6. Base de données

### Tables

**users**
| Colonne | Type | Description |
|---------|------|-------------|
| id | INT AUTO_INCREMENT | Identifiant unique |
| username | VARCHAR(50) | Pseudo |
| email | VARCHAR(191) | Email (unique) |
| password | VARCHAR(255) | Mot de passe hashé |
| bio | TEXT | Biographie |
| created_at | DATETIME | Date d'inscription |

**posts**
| Colonne | Type | Description |
|---------|------|-------------|
| id | INT AUTO_INCREMENT | Identifiant unique |
| user_id | INT | Référence vers users |
| title | VARCHAR(255) | Titre du post |
| content | TEXT | Contenu du post |
| image | VARCHAR(255) | Chemin de l'image (optionnel) |
| likes | INT | Nombre de likes |
| comments_count | INT | Nombre de commentaires |
| created_at | DATETIME | Date de publication |

**comments**
| Colonne | Type | Description |
|---------|------|-------------|
| id | INT AUTO_INCREMENT | Identifiant unique |
| post_id | INT | Référence vers posts |
| user_id | INT | Référence vers users |
| content | TEXT | Contenu du commentaire |
| created_at | DATETIME | Date du commentaire |

**likes**
| Colonne | Type | Description |
|---------|------|-------------|
| id | INT AUTO_INCREMENT | Identifiant unique |
| post_id | INT | Référence vers posts |
| user_id | INT | Référence vers users (unique par post) |
| created_at | DATETIME | Date du like |

## 7. Algorithmique — Tri par likes

L'application implémente un **tri à bulles (bubble sort)** côté JavaScript pour trier les posts par nombre de likes décroissant :

```javascript
for (let i = 0; i < arr.length - 1; i++) {
  for (let j = 0; j < arr.length - 1 - i; j++) {
    if (arr[j].likes < arr[j + 1].likes) {
      let tmp = arr[j]
      arr[j] = arr[j + 1]
      arr[j + 1] = tmp
    }
  }
}
```

**Complexité** : O(n²) — adapté car le nombre de posts affichés reste limité.

## 8. Sécurité

- Mots de passe hashés avec `password_hash()` / `password_verify()`
- Requêtes SQL préparées (PDO) pour éviter les injections SQL
- Validation des données côté serveur (PHP) et côté client (JavaScript)
- Le mot de passe n'est jamais renvoyé au frontend
- Vérification du type MIME pour l'upload d'images

## 9. Interface utilisateur

- **Mode sombre** par défaut (fond #080810)
- **Couleur principale** : violet (purple)
- **Responsive** : adapté mobile grâce à Quasar Framework
- **Composants** : avatars, cartes, boutons stylisés, inputs sombres

## 10. Installation

1. Installer WampServer
2. Importer `backend/xpulse.sql` dans phpMyAdmin
3. Placer le dossier `backend/` dans `www/`
4. Dans le dossier `frontend/`, exécuter :
   ```
   npm install
   quasar dev
   ```

## 11. Livrables

1. ✅ Cahier des charges (ce document)
2. ✅ Projet complet (frontend + backend + SQL)
3. Présentation orale
