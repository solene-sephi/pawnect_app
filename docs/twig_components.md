# Utilisation des composants Twig dans le projet

J'ai choisi d'utiliser principalement des composants Twig pour plusieurs raisons :

✅ Modernité : Les composants Twig font partie des évolutions récentes du framework Symfony (UX), et favorisent une approche plus modulaire et propre.

✅ Praticité : Ils permettent de créer des éléments réutilisables avec une interface claire (propriétés, logique encapsulée, rendu conditionnel).

✅ Parfaitement adaptés à Tailwind CSS : Plutôt que de multiplier les fichiers CSS, j'utilise Tailwind directement dans les composants. Cela colle à la philosophie “utility-first” de Tailwind.

✅ Moins de duplication : On évite de répéter des blocs HTML/CSS similaires dans différents templates.

✅ Typage et logique côté PHP : On peut gérer la logique métier (par exemple : les classes selon les variantes) dans une classe PHP dédiée, tout en gardant une syntaxe claire dans les templates.

✅ Interopérabilité avec d'autres composants UX : Notamment avec Stimulus, Alpine.js, etc.

## Mise en place

Pour la mise en place, je me suis appuyée sur le tutoriel de SymfonyCasts :
https://symfonycasts.com/screencast/last-stack/twig-component

## Tentative avec html_cva (anciennement cva)

J’ai également tenté d’utiliser html_cva(), une alternative inspirée du package JavaScript class-variance-authority, dans le but de gérer dynamiquement les classes CSS avec variants (taille, couleur, etc.).

Cependant :

- La syntaxe devient vite difficile à maintenir en Twig pur (surtout avec de longs objets imbriqués).
- La fonction html_cva() ne semblait pas fonctionner correctement malgré les bonnes versions des différents packages installés.
- Très peu d’exemples sont disponibles, et le package semble peu utilisé dans la communauté Symfony.
