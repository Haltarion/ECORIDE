# <img src="public/media/Logo-EcoRide.png" alt="Logo EcoRide" width="50"> EcoRide 

## Présentation
EcoRide est une application de covoiturage développée avec Symfony et Docker, métant l'accent sur l'écologie. L'application se veut économe en énergie, sobre graphiquement, avec des couleur rappelant la nature.

### Pré-requis :
- [Docker](https://www.docker.com/)
- [Git](https://git-scm.com/)
- [GitHub](https://github.com/)
- [Node.js](https://nodejs.org/fr)
- [chart.js](https://www.chartjs.org/docs/latest/getting-started/installation.html)

### Installation

#### Récupération du projet depuis Git
Ouvrir un terminal et se placer dans le dossier où vous souhaitez installer le projet :

```bash
git clone https://github.com/Haltarion/ECORIDE.git
```

#### Lancement du projet avec Docker
Le projet utilise Docker Compose via le fichier docker-compose.yml situé à la racine du dépôt.

1. Lancer docker destop :
   Vérifier que Engine running est affiché.
   
2. Mettre à jour WSL si besoin :
    ```bash
    wsl --update
    ```
    
3. Se placer dans le dossier du projet :
    ```bash
    cd ECORIDE
    ```
    
4. Lancer les conteneurs :
Se placer dans le dossier du projet au préalable
   ```bash
   docker compose up -d
   ```

## Workflow Git
1. Se placer dans la branche `dev` :
    ```bash
    git checkout dev
    ```
    
2. Faire des commit régulier avec un message explicite:
    ```bash
    git commit -m “Message de votre commit”
    ```
    
3. Envoyer son travail sur le dépôt distant :
    ```bash
    git push -u origin dev
    ```
    
4. Une fois qu'une fonctionnalité est prête, merger la branch `dev` dans `main` :
    ```bash
    git checkout main
    git pull origin main
    git merge dev
    ```
Résoudre les conflits si nécessaire.

5. Pousser main :
    ```bash
    git push origin main
    ```

## Stack technique
### Frameworks
- [Symfony](https://symfony.com/) : structure et sécurité de l'application.
### Bibliothèques
- [chart.js](https://www.chartjs.org/) : graphiques de la page administrateur
