insertBefore
============

Script d'insertion d'un texte dans une arborescence de fichiers.

L'id�e de d�part de ce code est de permettre d'ins�rer le m�me bout de contenu textuel dans une arborescence de pages HTML.
Par exemple : ajouter sur tout un site web statique l'appel � une CSS ou � un code javascript. 

La syntaxe du code PHP est la suivante :
php insertBefore.php "dossier" "texte_controle" "texte_recherch�" "texte � ins�rer"

D�roulement du script :
Le script parcoure le "dossier" et les sous dossiers � la recherche des fichiers HTML.
Dans chaque fichier trouv� il recherche la pr�sence de la chaine  "texte_controle"
Si cette chaine n'est pas trouv�e le script recherche "texte_recherch�" et ins�re juste avant "texte � ins�rer"

Dans le d�p�t git. J'ai plac� un contenu minimaliste de test et un .bat qui ex�cute le script