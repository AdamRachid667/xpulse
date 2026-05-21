---
name: project-state
description: État actuel du projet XPULSE - fonctionnalités implémentées et structure
metadata:
  type: project
---

Projet XPULSE : mini réseau social gaming (Quasar + PHP simple + MySQL).

**Stack :**
- Frontend : Quasar (Vue 3) dans `frontend/` → tourne sur http://localhost:9000
- Backend : PHP sans framework dans `backend/` → http://localhost/adam/xpulse/backend/
- Base de données : MySQL, database `xpulse`

**Fonctionnalités implémentées (mai 2026) :**
- Inscription / Connexion (avec messages d'erreur)
- Feed de posts chronologique
- Création de posts (avec vérification connexion)
- Likes
- Commentaires (dépliables sur chaque post via PostCard.vue)
- Profils utilisateurs avec bio éditable
- Barre de recherche (posts + comptes)
- Logout

**Structure backend :**
- db.php, register.php, login.php, get_posts.php, create_post.php, like.php
- add_comment.php, get_comments.php, get_profile.php, update_bio.php, search.php

**Structure frontend pages :**
- IndexPage.vue (feed + recherche), LoginPage.vue, RegisterPage.vue, CreatePostPage.vue, ProfilePage.vue
- Composant réutilisable : components/PostCard.vue

**Base de données :**
- Table users : id, username, email, password, bio
- Table posts : id, user_id, title, content, likes, comments_count, created_at
- Table comments : id, post_id, user_id, content, created_at

**Why:** Projet d'apprentissage — backend ultra simple, 1 fichier PHP = 1 action, pas de framework.
**How to apply:** Garder le backend simple et lisible. Pas d'abstraction inutile côté PHP.
