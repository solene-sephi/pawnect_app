# Gestion des Formulaires Relatifs au Refuge

Composants concernés :

- ShelterManagementController
- ShelterType (Formulaire principal du Refuge)
- AddressType (Sous-formulaire pour l'adresse, potentiellement utilisé seul)
- ShelterFormSubscriber
- ShelterAddressSubscriber
- ShelterPermissionService
- ShelterVoter

## 1. Contexte et Objectif

Dans notre application, certaines informations d'un refuge (`Shelter`) ne doivent être modifiables que par des utilisateurs autorisés. Pour cela, nous avons mis en place une logique de permission reposant sur la constante `SHELTER_EDIT_PARTIALLY`, gérée par un Voter.  
L’objectif est de désactiver dynamiquement certains champs du formulaire, en fonction des permissions de l'utilisateur, afin de limiter l’édition des données sensibles.

## 2. Form Subscribers : appliquer dynamiquement ces permissions

### Alternatives envisagées et inconvénients :

1. **Gestion dans le Contrôleur :**

   - Mélange des responsabilités (le contrôleur ne doit pas gérer la logique de formulaire).
   - Code non réutilisable, avec duplication dans plusieurs parties de l’application.

2. **Utiliser une option (e.g. `disabled_fields`) directement dans le FormType :**

   - Complexité accrue : il faudrait passer cette option partout.
   - Manque de flexibilité, car les champs désactivés seraient alors statiques et non contextuels.

3. **Utiliser une Form Extension :**

   - S’applique globalement à un type de formulaire, alors que nous avons besoin d’une personnalisation fine basée sur le contexte utilisateur.
   - Difficile d’accéder au contexte de l’utilisateur connecté.

### Avantages du Form Subscriber :

- **Dynamique et contextuel :** Le Subscriber, grâce à l’événement `PRE_SET_DATA`, permet d’accéder à l’entité et au contexte utilisateur (via l’injection de services), afin d’appliquer une logique de permissions adaptée.

- **Séparation des responsabilités :** La logique de modification du formulaire est isolée dans une classe dédiée (`ShelterFormSubscriber`), ce qui permet de garder le `ShelterType` simple et centré sur la structure du formulaire.

- **Flexibilité :** Il devient simple de modifier des options de champs (comme désactiver un champ ou modifier son label) en fonction des permissions déterminées par le Voter et le `ShelterPermissionService`.

## 3. ShelterPermissionService : centralisation de la logique d'édition des champs

Le **ShelterPermissionService** centralise la logique de gestion des permissions liées aux champs du formulaire. Il interroge le `ShelterVoter` pour déterminer si l’utilisateur dispose du droit de modifier partiellement le refuge et retourne, en conséquence, un tableau associatif indiquant les options à appliquer sur chaque champ (ex. désactivation, modification du label).

Ce service est une approche spécialisée, ce qui permet de mieux contrôler l'accès aux champs sensibles du formulaire sans complexifier la gestion des permissions dans le contrôleur ou le formulaire lui-même.

Par ailleurs, Symfony n'est pas conçu pour permettre la modification directe des options d'un champ une fois celui-ci ajouté au formulaire. En d'autres termes, on ne peut ni "modifier" ni "overrider" directement un champ existant, mais seulement l'ajouter ou le supprimer.
Comme Symfony ne permet pas de modifier directement un champ existant, nous le supprimons et le réajoutons avec les options modifiées.

## 4. ShelterVoter : gestion fine des permissions

Les **Voters** dans Symfony permettent de centraliser les décisions de sécurité.  
Dans notre cas, le `ShelterVoter` gère la permission `SHELTER_EDIT_PARTIALLY` pour déterminer si un utilisateur a le droit de modifier partiellement un refuge.

### Principaux points :

- `SHELTER_VIEW` est inutile, car l'accès en lecture est ouvert à tous.
- `SHELTER_EDIT` est réservé aux administrateurs globaux (`ROLE_ADMIN`) dont les droits sont gérés directement.
- Seule la permission `SHELTER_EDIT_PARTIALLY` est utilisée pour les cas où l'utilisateur doit avoir un accès limité à la modification.

### Pourquoi utiliser un Voter ?

- **Centralisation des décisions de sécurité :** La logique de sécurité est regroupée en un seul endroit, ce qui facilite la maintenance et l'évolution du système de permissions.

- **Réutilisabilité :** Le Voter peut être appelé dans des contrôleurs, dans des templates Twig ou d'autres services.

- **Bonne pratique Symfony :** L'utilisation de Voters pour la gestion fine des accès est la méthode recommandée par Symfony.

## 5. Gestion de l'option `related_entity` dans les formulaires

Pour rendre le formulaire `AddressType` réutilisable, nous avons introduit l'option personnalisée `related_entity` qui permet de passer dynamiquement l'entité liée à l'adresse (par exemple, un `Shelter`).

Cela permet ensuite, dans le `AddressFormSubscriber`, d'utiliser cette valeur pour appliquer les permissions spécifiques.

### Pourquoi utiliser une option ?

Cette approche permet de :

- **Passer dynamiquement** l'entité associée à l'adresse, ce qui est utile lorsque l'adresse est un sous-formulaire d'une entité (comme `Shelter`) ou utilisée seule.
- **Rendre le formulaire AddressType indépendant**, tout en gardant la possibilité d'appliquer des règles de permission en fonction du contexte.
- **Uniformiser la gestion** des données entre les formulaires parent et enfant.
