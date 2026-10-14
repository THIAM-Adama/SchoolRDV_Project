# 🏫 SchoolRDV — Plateforme Web de Gestion de Rendez-Vous Scolaires

> **Application web technico-fonctionnelle de prise et de gestion de rendez-vous entre parents d'élèves, enseignants et administration scolaire.**

---

## 📌 Présentation du Projet

**SchoolRDV** est une solution web conçue pour simplifier et automatiser l'organisation des rendez-vous au sein des établissements scolaires. Elle permet de fluidifier la communication, de supprimer les conflits de créneaux et d'offrir une interface centralisée pour tous les acteurs (Parents, Enseignants, Administrateurs).

---

## 🎯 Démarche Fonctionnelle & Conception

Le projet a été mené en suivant une méthodologie de conception logicielle complète :

* **Analyse des besoins & Spécifications :** Identification des cas d'utilisation (*Use Cases*) et rédaction du cahier des charges fonctionnel.
* **Modélisation des données (Merise / UML) :**
  * **MCD / MLD :** Conception de la structure de données relationnelle pour gérer les utilisateurs, rôles, créneaux et rendez-vous.
  * **Diagrammes UML :** Diagrammes de cas d'utilisation et de séquences.
* **Prototypage & UX/UI :** Création des maquettes interactives et de la charte graphique sous **Figma**.

---

## 🛠️ Architecture & Stack Technique

* **Backend / Framework :** PHP 8+, Laravel
* **Frontend :** Blade Templates, Tailwind CSS / Bootstrap, JavaScript
* **Base de données :** MySQL / MariaDB (ORM Eloquent)
* **Conception & Outils :** Figma, Merise / UML, Git & GitHub

---

## ✨ Fonctionnalités Principales

* 👥 **Gestion des utilisateurs & Rôles :** Espace dédié pour Parents, Enseignants et Administration.
* 📅 **Gestion des créneaux & Disponibilités :** Définition des plages horaires de rendez-vous par les enseignants.
* 📩 **Prise de rendez-vous & Confirmation :** Réservation en ligne avec validation automatique/manuelle et notifications.
* 📊 **Tableau de bord d'administration :** Suivi centralisé de l'activité de l'établissement et des plannings.

---

## 🚀 Installation & Lancement en local

### Prérequis
* PHP >= 8.1
* Composer
* MySQL / XAMPP

### Étapes d'installation

1. **Cloner le projet :**
   ```bash
   git clone https://github.com/THIAM-Adama/SchoolRDV_Project.git
