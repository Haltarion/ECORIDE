# Environnement de Travail – Développement

## 🌱 Gestion de version

J’utilise **Git** pour suivre l’évolution de mon code, versionner les différentes étapes du projet, et revenir à un état antérieur si besoin.

Je travaille principalement sur **GitHub**, où je suis une stratégie de branches simple mais efficace :

- La branche **`Dev`** est celle sur laquelle je développe de nouvelles fonctionnalités.
- Une fois qu’une fonctionnalité est testée et fonctionnelle, je la **merge** manuellement dans la branche **`main`**, qui représente la version stable du projet.

## 🖥️ Éditeur de code

J’utilise **Visual Studio Code (VSCode)** comme éditeur principal. Il est léger, rapide et personnalisable. J’y ai installé plusieurs **extensions** pour optimiser mon confort de travail et la qualité de mon code :

- **Color Highlight** : met en surbrillance les couleurs écrites en hexadécimal ou en nom (utile pour le CSS).
- **Auto Rename Tag** : modifie automatiquement la balise de fermeture lorsqu’on change la balise d’ouverture (et inversement).
- **GitLens** : améliore l'intégration Git dans VSCode en affichant l’historique des modifications ligne par ligne.
- **Copilot** : m’aide à gagner du temps en suggérant du code en fonction de ce que j’écris.

## 💾 Installation et utilisation

### Prérequis

- Installer [Git](https://git-scm.com/)
- Créer un compte [GitHub](https://github.com/)
- Installer [Visual Studio Code](https://code.visualstudio.com/)

### Installation de l’environnement

1. Cloner le dépôt :
   ```bash
   git clone https://github.com/Haltarion/ECORIDE.git
2. Se placer dans le projet :
    ```bash
    cd ECORIDE
## ⌨️ Utilisation
- Développer sur la branche Dev
- Tester les modifications
- Merger vers main lorsque tout est fonctionnel :
    ```bash
    git checkout main
    git merge Dev
    git push origin main
