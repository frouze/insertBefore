insertBefore
============

Script d'insertion d'un texte dans une arborescence de fichiers.

L'idée de départ de ce code est de permettre d'insérer le même bout de contenu textuel dans une arborescence de pages HTML.
Par exemple : ajouter sur tout un site web statique l'appel à une CSS ou à un code javascript. 

La syntaxe du code PHP est la suivante :
php insertBefore.php "dossier" "texte_controle" "texte_recherché" "texte à insérer"

Déroulement du script :
Le script parcoure le "dossier" et les sous dossiers à la recherche des fichiers HTML.
Dans chaque fichier trouvé il recherche la présence de la chaine  "texte_controle"
Si cette chaine n'est pas trouvée le script recherche "texte_recherché" et insère juste avant "texte à insérer"

Dans le dépôt git. J'ai placé un contenu minimaliste de test et un .bat qui exécute le script