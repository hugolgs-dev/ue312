# Guide d'installation et explications du projet*

#### *par rapport à ce que je comprends

---

## Installation du projet sur votre ordi perso:

### Clonez le dépôt :

1. Placez vous dans ```/var/www/html/``` 
2. faites : ```git clone https://github.com/hugolgs-dev/ue312.git[View](src/Router/View)```
3. ```cd ue312/```

### Pour vérifier que le projet est bien installé et que tout fonctionne normalement :

1. ```git pull``` 
2. ```git remote add origin https://github.com/hugolgs-dev/ue312.git```
3. ```composer install```

---

## Découpage du projet :

Le prof l'explique déjà dans le document de cours, donc je vais aller à l'essentiel.
Les deux dossiers principaux sont ```src/Router``` et ```src/Template```, c'est sur ces dossiers que l'on va travailler. 
Le reste n'est pas vraiment important pour ce que l'on doit produire.

Aussi, je donne plus de détails à l'intérieur de chaque fichier. Ci-dessous, c'est plutôt un résumé du rôle que chaque fichier joue, et comment ils interragissent entre eux.


### 1. ```src/Router/Exception/HttpMethodNotImplemented.php```

On l'utilise quand une méthode HTTP non-supportée est utilisée sur une vue

### 2. ```src/Router/Exception/InvalidViewImplementation.php```

On l'utilise pour s'assurer que seules les view enregistrées avec un routing sont affichées/prises en compte.

> J'ai l'impression que il n'y a pas grande chose à changer dans ces deux premiers fichiers. <br>
> Mais il faudra quand même être vigilant voir si on peut pas implémenter un nouveau type d'erreur ou non.

### 3. ```src/Router/View/BaseView.php```

Ce fichier à pour but de définir un standard d'interface d'affichages (Views), une sorte de base sur laquelle se reposeront nos différentes Views.

### 4. ```src/Router/Request.php```

Améliorer la classe ```Request``` de Symfony, en l'adaptant à nos besoins. 

### 5. ```src/Router/Router.php```

Définit l'interface ```Router```, qui sert de structure pour toutes les Routes du projet.

### 6. ```src/Router/SimpleRouter.php```

Utilise la class ```Router``` définie dans le fichier précédent. Le but de ce fichier est de gérer le Routing et la gestion des requêtes. <br>
J'ai l'impression que c'est plus ou moins le fichier principal du projet.

### 7. ```src/Template/Renderer.php```

Ce fichier, et même le dossier ```Template```, sont responsables de toute la partie affichage des données/objets issues des résultats requêtes HTTP.

---

## Proposition de déroulement du projet

Maintenant qu'on a une idée un peu plus claire (j'espère) de l'organisation du projet et du rôle des fichiers, on peut passer à la partie suivante : plannifier.

---

1. Définir la logique de Routing
2. S'occuper du processus de gestion du Routing et de la logique de View
3. Gérer le processus des requêtes
4. Gérer le rendu et l'affichage de tout ça (la partie frontend du projet)

Tout ça se fait pour chaque "composant" du projet, ce ne sont pas des blocs à faire successivement.

## Sources :

1. ChatGPT (le goat) pour "traduire" les informations des sources ci-dessous
2. Le [code source](https://github.com/symfony/http-foundation) de HttpFoundation
3. La [documentation](https://symfony.com/doc/current/components/http_foundation.html) de HttpFoundation
4. [Markdown Guide](https://www.markdownguide.org/basic-syntax/) pour rédiger ce document.
5. Le cours du prof