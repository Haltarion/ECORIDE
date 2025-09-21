# EcoRide

## Pour commencer

### Pré-requis :
- [Git](https://git-scm.com/)
- [GitHub](https://github.com/)
- [Node.js](https://nodejs.org/fr)
- [chart.js](https://www.chartjs.org/docs/latest/getting-started/installation.html)

### Installation
1. Initialiser un repository
Ouvrir le terminal ou l'invite de commande sur votre système d'exploitation.
Naviguer vers le répertoire du projet dans lequel vous souhaitez créer le dépôt Git.
Par exemple, si votre projet est situé dans le dossier « mon_projet », utilisez la commande suivante :
   ```bash
   cd mon_projet
2. Initialiser le repository git :
   ```bash
   git init
3. Cloner le dépôt :
   ```bash
   git clone https://github.com/Haltarion/ECORIDE.git

## Démarrage
1. Se placer dans la branche dev :
    ```bash
    git checkout dev
2. Faire des commit régulier avec un message explicite:
    ```bash
    git commit -m “Message de votre commit”
3. Avant de quitter le projet, renvoyer votre travail sur le dépot distant :
    ```bash
    git push -u origin Dev
4. Une fois qu'une fonctionnalité est prète, merger la branch `dev` dans `main`

## Fabriqué avec

### Editeur de code
J’utilise [Visual Studio Code](https://code.visualstudio.com/) comme éditeur principal. Il est léger, rapide et personnalisable. J’y ai installé plusieurs **extensions** pour optimiser mon confort de travail et la qualité de mon code :

- **Color Highlight** : met en surbrillance les couleurs écrites en hexadécimal ou en nom (utile pour le CSS).
- **Auto Rename Tag** : modifie automatiquement la balise de fermeture lorsqu’on change la balise d’ouverture (et inversement).
- **GitLens** : améliore l'intégration Git dans VSCode en affichant l’historique des modifications ligne par ligne.
- **GitHub Copilot** : m’aide à gagner du temps en suggérant du code en fonction de ce que j’écris.
- **ESLint** : permet d'afficher les erreurs directement dans l'application
- **Error Lens** : affiche les erreurs en surligné
- **Material Icon Theme** : pour le confort visuel
- **Prettier** : pour le confort visuel

### Bibliothèques utilisées
- chart.js : pour les graphiques de la page administrateur
