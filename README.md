# SymfonyShop 🛍️

**Site e-commerce – PHP Symfony + MySQL + Bootstrap**

## 📋 Description

SymfonyShop est un site e-commerce développé avec le framework PHP Symfony. Il permet aux utilisateurs de parcourir une boutique en ligne, d’ajouter des produits à leur panier, de passer commande et de gérer leur compte personnel. L’application intègre également une interface d’administration sécurisée pour gérer les produits, catégories, commandes et utilisateurs.

Le système d’authentification est renforcé par l’envoi de mails avec tokens JWT pour la vérification des comptes et la réinitialisation des mots de passe. L’interface a été conçue en responsive avec Twig et Bootstrap pour une expérience utilisateur fluide sur tous les appareils.

## ✨ Fonctionnalités

### ✅ Fonctionnalités déjà mises en place :
- Authentification sécurisée avec vérification par mail
- Réinitialisation du mot de passe via token JWT
- Espace utilisateur (gestion du profil et des commandes)
- Interface d’administration protégée (CRUD produits, catégories, utilisateurs)
- Gestion du panier et des commandes
- Upload et affichage des images de produits
- Envoi de mails (confirmation de compte, commandes, réinitialisation)
- Responsive design (Twig + Bootstrap)

### 🛠️ Fonctionnalités prévues :
- Système de paiement en ligne
- Filtrage et tri des produits
- Gestion des stocks
- Page de contact avec formulaire

## 🧰 Technologies utilisées

- **Backend** : PHP (Symfony)
- **Base de données** : MySQL avec Doctrine ORM
- **Frontend** : Twig, Bootstrap, JavaScript (vanilla)
- **Authentification & Sécurité** : JWT, gestion des rôles, tokens de vérification
- **Services** : Envoi de mails (Mailer)

## 🚀 Installation

```bash
git clone https://git@github.com:AlexDelapierre/SymfonyShop.git
cd SymfonyShop
```

## Configuration de l’environnement :
Créez un fichier .env.local avec vos variables d’environnement :
(DATABASE_URL, clé JWT, credentials mailer, etc.)

### Installez les dépendances PHP et front :

```bash
composer install
npm install
npm run dev
```

### Exécutez les migrations :

```bash
php bin/console doctrine:migrations:migrate
```

### Lancez le serveur Symfony :

```bash
symfony server:start
```

## 📌 Évolutions envisagées
- Intégration d’un module de paiement sécurisé (Stripe/PayPal)
- Gestion multi-utilisateurs avec rôles avancés
- Optimisation SEO
- Système de notation/commentaires sur les produits

## 👤 Auteur
Alexandre Delapierre – [LinkedIn](https://www.linkedin.com/in/alexandre-delapierre/)
