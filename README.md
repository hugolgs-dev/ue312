# Micro-framework UE312 - Documentation

## Préambule

Le but de ce document est de résumer notre approche du projet et notre réflexion
commune tout au long de celui-ci. <br>

## Répartition des rôles

| Nom      | `TwigRenderer.php`                   | `SimpleRouter.php`              | Les vues               | Templates Twig               |
|:---------|--------------------------------------|---------------------------------|------------------------|------------------------------|
| Hudayfa  | Fonction `render()`                  | Fonction `call()`                 | Non                    | Non                          |
| Hugo     | Non                                  | Non                             | Tous les fichiers `View` | Les trois fichier `.html.twig` |
| Julien   | Non                                  | Fonctions `register()` et `serve()` | Non                    | Non                          |
| Samantha | Contructeur et fonction `register()` | Contructeur                     | Non                    | Non                          |

NB: chaque membre du groupe était responsable également des fichiers de tests en rapport avec leur code.

## Fonctionnement global du framework

Ce framework fonctionne en reliant des routes à des contrôleurs qui affichent des vues. <br>
Les vues sont générées avec TwigRenderer, qui sert à afficher des fichiers templates avec des données.


## SimpleRouter.php


- La fonction `call()` permet de vérifier que la classe hérite bien de `BaseView.php`. Elle permet ensuite d'instancier
  cette vue et d'appeler la méthode `render` pour récupérer le contenu et l'envoyer. <br>
- Le constructeur de la classe initialise celle-ci en vérifiant que `$engine` est bien une instance/sous-classe de `Renderer` <br>
- La fonction `register()` enregistre une nouvelle route dans le routeur. <br>
- La fonction `serve()` a pour rôle de traiter une requête HTTP et d'envoyer une réponse à celle-ci.

## TwigRenderer

- Le constructeur de la classe a pour rôle de configurer un modèle de templates avec Twig. <br> `getTwig()` permet d'accéder à l'instance de `Twgi\Environment` car `$twig` est une propriété privée de `TwigRenderer`.
- La méthode `render` utilise Twig pour charger un template et le retourner avec les données renseignées.
- La fonction `register()` ajouter un dossier Twig, avec un alias. Cela lui permet d'accéder facilement aux fichiers du dossier Twig en utlisant cet alias plutôt que devoir spécifier tout le chemin.


## Les fichiers de vue

### HTMLView.php

Il s'agit de la vue la plus simple du projet, car elle retourne uniquement du contenu HTML. Elle utilise la classe BaseView, et retourne un template Twig <br>

### JSONView.php

Ce fichier offre une approche similaire au fichier HTMLView.php. Avec deux exceptions cependant :

1. Ici, on ne veut pas utiliser de template Twig. Car cette vue retourne des données en format JSON. C'est un format de données, qui n'est pas vouée à être affiché dans le navigateur, contrairement au HTML.
2. On utilise `JsonResponse`, qui traite automatiquement les données en format JSON. Cela fait donc moins de code à écrire.

### TemplateView.php

La vue responsable de la compilation d'un template. C'est en partie pour cela que l'on enregistre la classe comme un tag avec `$this->twigRenderer->register(static::class);` <br>

### ErrorView.php

Nous avons décidé d'ajouter une vue dont le rôle est de gérer l'affichage des erreurs HTTP. Il y avait deux manières d'aborder ce code :
1. Fixe : On code une réponse différente, avec une structure HTML propre, pour chaque erreur HTTP.
2. Dynamique : On crée une réponse en quelques mots pour chaque erreur, que l'on ajoute à une structure HTML qui sera utilisée pour toutes les réponses.

Nous avons choisi l'approche dynamique. Nous n'avons pas besoin de faire une mise en forme propre à chaque erreur, et cette approche facilite la maintenance. Il suffit juste de modifier le tableau $errors.

## Les fichiers Twig

Ces fichiers sont situés dans le dossier templates/ du projet. Pour le moment, il y en a 3 :

### base.html.twig

Ce fichier, comme son nom l'indique, sert de base pour tous les autres fichiers Twig du projet. Il est responsable de la structure HTML de la page. Il contient les balises
obligatoires (html, head, body, etc), afin que les autres fichiers ne continnent que le contenu qui leur est propre. Pour utiliser ce fichier dans les autres fichiers Twig,
il faut écrire la ligne "{% extends "base.html.twig" %}" au début du fichier correspondant.

### index.html.twig

Ce fichier sert uniquement d'exemple pour les autres fichiers. Il montre comment intégrer le fichier base, et le minimum de syntaxe


### errors/error.html.twig

Ce fichier affiche la vue générée par [le fichier des erreurs HTTP](#errorviewphp). Il s'agit d'un template propre à l'affichage des erreurs HTTP.

Petite note cependant : Nous n'avons pas trouvé comment visualiser le rendu généré par le fichier twig directement dans le navigateur, et sans fichier index.php (vu qu'il s'agit d'une bibliothèque).
