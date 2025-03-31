# Organisation des données de développement et de test

## 1. Structure générale

Cette structure est inspirée de l'approche Monofony (https://github.com/monofony/Monofony/tree/0.11/src/Monofony/MetaPack/CoreMeta/.recipe/src/DataFixtures).

Le projet est divisé en deux catégories de fixtures :

- DefaultFixtures → Contient les données fixes et indispensables à l'application.
- FakeFixtures → Contient des données dynamiques générées pour simuler un environnement réaliste et varié.

**Organisation des dossiers**

```
src/
 ├── DataFixtures/
 │    ├── Factory/      # Factories Foundry (AnimalFactory.php, AnimalTypeFactory.php, etc.)
 │    ├── Story/        # Stories Foundry pour définir des scénarios complets (DefaultAnimalTypeStory.php, DefaultAnimalBreedStory.php, AnimalStory.php, …)
 │    ├── Provider/     # Fournisseurs personnalisés Faker (ex : PetNameProvider.php)
 │    ├── DefaultFixtures.php   # (Optionnel) Fixture classique regroupant éventuellement des stories fixes
 │    └── FakeFixtures.php      # Fixture classique pour lancer la génération dynamique si nécessaire
```

## 2. Pourquoi utiliser des factories pour toutes les données ?

**Fixtures classiques pour données fixes :**

Nous pourrions, en théorie, insérer directement des données fixes en créant de nouveaux objets (ex. avec persist() et flush()).

Exemple traditionnel :

```
$animalType = new AnimalType();
$animalType->setName('dog');
$manager->persist($animalType);
$manager->flush();
```

- Avantage : simplicité apparente.
- Inconvénient : cette approche est fragmentée. Nous devons gérer séparément des fichiers pour les données fixes et utiliser des factories pour les données dynamiques. De plus, dans un environnement de dev où la base est souvent réinitialisée, il est plus rapide et cohérent de générer tout via des factories.

**Factories (et Stories) pour toutes les données :**

Bien que l’utilisation d’une factory pour des données fixes puisse sembler « overkill » au premier abord, elle présente de nombreux avantages :

- Uniformité de la création : Toute la génération de données (fixes ou dynamiques) passe par le même mécanisme Foundry, ce qui facilite la maintenance.
- Performance : Les factories génèrent les objets en mémoire et les insèrent directement, évitant ainsi des appels supplémentaires en base (ex. avec getReference() dans des fixtures classiques).
- Facilité de test : Nous pouvons appeler une story ou une factory pour recréer facilement l’état désiré de la base, sans mélange de logique entre fixtures et factories.
- Réutilisabilité : Une factory pour AnimalType ou AnimalBreed peut être utilisée à la fois dans des tests unitaires et dans la génération de données fixes via une story.
- Flexibilité : Si nous devons modifier le scénario (par exemple, ajouter des variations ou des states), nous le faisons dans la factory (ou via des states) de manière centralisée.

## 3. Mise en place concrète

### Points d'entrée `DefaultFixtures.php` et `FakeFixtures.php`

Ces fichiers sont les point d’entrée pour charger toutes les Stories correspondantes.

**Exemple:**

```
class DefaultFixtures extends Fixture {
    public function load(ObjectManager $manager): void {
        DefaultAnimalTypeStory::load();
        DefaultAnimalBreedStory::load();
    }

    public static function getGroups(): array
    {
        return ['default'];
    }
}
```

**Pourquoi utiliser ces fichiers comme points d'entrée ?**

- Chargement ciblé des données de base : Si on veut remplir la base avec les données obligatoires (races d’animaux, types, etc.) mais sans générer de fausses données, on peux exécuter uniquement le groupe 'default'. Par exemple, sur un serveur de test ou en prod, on veut une base propre avec les types et races, mais sans fausses données.
- Séparation claire des responsabilités : DefaultFixtures s'occupe des données statiques, celles qui ne changent pas et qui constituent le socle de l'application. DynamicFixtures gère les données dynamiques, générées aléatoirement pour simuler un environnement réaliste en développement (par exemple, des animaux, des utilisateurs, etc.). Cette séparation rend le projet plus lisible et facilite la maintenance : en cas de besoin de modifier les données fixes ou dynamiques, nous savons exactement où intervenir.

### Factories

Les factories Foundry nous permettent de définir comment chaque entité doit être générée. Elles utilisent Faker pour remplir les champs avec des valeurs par défaut ou aléatoires.

Avantages des factories :

- Gestion propre de la création : Au lieu d’instancier directement les entités (ex. via new AnimalType()), nous utilisons par exemple AnimalTypeFactory::createOne().
- Uniformisation : Nous utilisons le même mécanisme pour créer toutes nos entités, qu’elles soient fixes ou dynamiques.
- Fallback en tests : La méthode getDefaults() fournit des valeurs par défaut utiles lorsque la factory est utilisée en dehors d’une story.

**Exemple pour des données fixes :**

```
final class AnimalTypeFactory extends PersistentProxyObjectFactory {
    protected function getDefaults(): array {
        return [
            'name' => 'default_type', // Cette valeur sert de fallback si la Story ne l’override pas.
        ];
    }
}

```

**Exemple pour des données dynamiques :**

```
final class AnimalFactory extends PersistentProxyObjectFactory {
    protected function getDefaults(): array {
        return [
            'name' => self::faker()->firstName(),
            'dateOfBirth' => self::faker()->dateTimeThisDecade(),
            'breed' => BreedFactory::random(), // Récupère un breed au hasard.
            'shelter' => ShelterFactory::random(),
        ];
    }
}
```

### Stories

Les stories nous permettent de déclarer les ensembles de données à insérer dans la base. Elles servent à structurer la génération des données en scénarios cohérents.

Avantages des stories :

- Séparation entre déclaration et insertion : La story définit précisément quelles données fixes ou dynamiques doivent être créées.
- Réutilisation et modularité : Une story peut être exécutée seule, ce qui permet de réinitialiser ou recharger un ensemble spécifique de données sans affecter le reste.
- Organisation : Chaque story est dédiée à un type de données ou à un scénario particulier (ex. un ensemble de types d’animaux ou un scénario d’animaux associés à un refuge).

**Exemple pour des données fixes :**

```
final class DefaultAnimalTypeStory extends Story {
    private static array $typeNames = ['dog', 'cat', 'rabbit', 'chicken'];

    public function build(): void {
        foreach (self::$typeNames as $type) {
            AnimalTypeFactory::createOne(['name' => $type]);
        }
    }
}
```

**Exemple pour des données dynamiques :**

```
final class AnimalStory extends Story {
    public function build(): void {
        AnimalFactory::createMany(50);
    }
}
```

**Pourquoi utiliser des stories et pas uniquement des factories ?**
Si nous utilisions uniquement les factories, nous serions obligés de répéter les appels de création et la logique de génération de scénarios dans chaque test ou commande. Les stories nous permettent de :

- Centraliser la logique de chargement des données (fixes ou dynamiques) dans un ou plusieurs scénarios prédéfinis.

- Exécuter sélectivement des ensembles de données via une commande unique (par exemple, recharger uniquement les données fixes via DefaultFixtures.php).

- Meilleure organisation : Chaque Story est dédiée à un ensemble de données précis (ex: DefaultAnimalTypeStory pour les types d'animaux).
