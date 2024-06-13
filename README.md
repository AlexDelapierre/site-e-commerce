# site-e-commerce

## Services et Extensions Twig

### CategoriesService

Le service `CategoriesService` est utilisé pour récupérer les catégories de l'application, triées par ordre de catégorie. 
Ce service est défini dans `src/Service/CategoriesService.php` et est configuré dans `config/services.yaml`.

### AppExtension

L'extension Twig `AppExtension` rend les catégories disponibles dans tous les templates Twig via une variable globale categories. L'extension est définie dans `src/Twig/AppExtension.php` et configurée dans `config/services.yaml`.
