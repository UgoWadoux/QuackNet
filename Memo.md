make entity = créer une entité ou la modifié en remettant le même nom.

symfony serve : Lance le serveur sur le localhost renseigné.

php bin/console doctrine:schema:update --force : Télécharge et met a jour les bases de données selon les infos changé ou renseigné

php bin/console doctrine:migration : créé une migration renseigné, a la suite de ca une confirmation vous est demandé, créé également une table migration dans la quelle tout les migrations non effectué sont conservé jusqua la prochaine validation

php bin/console doctrine:migrations:migrate : valider la migration ou les migrations en attente.


Fonction SGBD/ORM : 

flush() : La fonction flush() est utilisée pour synchroniser les objets gérés par l'ORM avec la base de données. Cela signifie que toutes les opérations en attente, telles que les insertions, mises à jour ou suppressions, seront effectivement exécutées sur la base de données.


Cas d'utilisation : Après avoir utilisé persist() pour informer l'ORM des changements que vous souhaitez enregistrer, vous utilisez flush() pour appliquer ces changements à la base de données. Par exemple :

````
$entityManager->flush();
````


persist() :  La fonction persist() est généralement utilisée dans le contexte des ORM pour indiquer à l'ORM qu'un objet doit être géré (suivi) par le système de persistance. Cela signifie que l'objet devrait être enregistré dans la base de données lors de la prochaine opération de persistance.


Après avoir créé une nouvelle instance d'objet représentant une entité (par exemple, une ligne de base de données), vous utilisez persist() pour informer l'ORM que cet objet doit être géré. Par exemple (Doctrine) : 

````
$entityManager = $this->getDoctrine()->getManager();
$article = new Article();
// configurez les propriétés de l'article
$entityManager->persist($article);
````


remove() : La fonction remove() est utilisée pour indiquer à l'ORM que l'objet en question doit être supprimé de la base de données lors de la prochaine opération de persistance (lorsque flush() est appelé).


Cas d'utilisation : Lorsque vous souhaitez supprimer une entité de la base de données, vous utilisez remove() pour marquer cette entité à supprimer. Par exemple :

````
$entityManager = $this->getDoctrine()->getManager();
$article = $entityManager->getRepository(Article::class)->find($articleId);

if ($article) {
    $entityManager->remove($article);
    $entityManager->flush();
}
````



render() : La fonction render() n'est pas spécifiquement associée à Doctrine, mais plutôt à Symfony, qui est souvent utilisé conjointement avec Doctrine. Elle est utilisée dans le contexte des contrôleurs Symfony pour rendre une vue (généralement une page HTML) à partir d'un modèle et d'éventuelles données.

Cas d'utilisation : Lorsque vous souhaitez afficher une page web en réponse à une requête, vous utilisez render() pour rendre une vue en utilisant un modèle et, éventuellement, des données à afficher. Par exemple :


````
public function indexAction()
{
    $entityManager = $this->getDoctrine()->getManager();
    $articles = $entityManager->getRepository(Article::class)->findAll();

    return $this->render('article/index.html.twig', [
        'articles' => $articles,
    ]);
}
````

Dans cet exemple, la vue serait rendue à partir du fichier index.html.twig avec la liste des articles passée comme données.


redirectToRoute() : La fonction redirectToRoute() est utilisée pour rediriger l'utilisateur vers une route spécifique de l'application Symfony.

Cas d'utilisation :  Après une action réussie (par exemple, l'inscription d'un utilisateur), vous pourriez vouloir rediriger l'utilisateur vers une autre page de l'application. Voici un exemple :

````
return $this->redirectToRoute('dashboard');
````


getUser() : La fonction getUser() est utilisée pour obtenir l'utilisateur actuellement authentifié dans le système. Elle est généralement utilisée dans le contexte du composant Security de Symfony.

Cas d'utilisation : Lorsque vous avez besoin d'accéder aux informations de l'utilisateur actuellement connecté, vous pouvez utiliser getUser(). Par exemple :

````
$user = $this->getUser();
$username = $user->getUsername();
````
Dans cet exemple, $username contiendrait le nom d'utilisateur de l'utilisateur actuellement connecté.



hashPassword() :  La fonction hashPassword() n'est pas une fonction native de Symfony, mais elle pourrait être associée à la gestion des mots de passe sécurisée. En Symfony, le composant Security offre une classe PasswordEncoderInterface qui propose une méthode encodePassword(). Cela pourrait être utilisé pour hacher (hash) les mots de passe de manière sécurisée avant de les stocker en base de données.

Cas d'utilisation : Lors de l'enregistrement d'un nouvel utilisateur ou de la modification du mot de passe d'un utilisateur existant, vous pouvez utiliser encodePassword() pour hacher le mot de passe avant de le stocker.

````
se Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

// ...

public function register(UserPasswordEncoderInterface $passwordEncoder)
{
    // ...

    $user->setPassword(
        $passwordEncoder->encodePassword(
            $user,
            $plainPassword
        )
    );

    // ...
}
````


"->" :
Le -> est un opérateur utilisé en programmation orientée objet (OOP) pour accéder aux méthodes et propriétés d'un objet. C'est particulièrement courant dans des langages tels que PHP, Java, C++, et d'autres qui prennent en charge les concepts de programmation orientée objet.

Lorsque vous créez une instance d'un objet, vous utilisez -> pour appeler une méthode ou accéder à une propriété de cet objet. Voici un exemple en PHP :

````
// Création d'un objet de la classe MyClass
$myObject = new MyClass();

// Appel d'une méthode de l'objet
$myObject->myMethod();

// Accès à une propriété de l'objet
$value = $myObject->myProperty;
````

Dans cet exemple, $myObject->myMethod() appelle la méthode myMethod() de l'objet $myObject, et $myObject->myProperty accède à la propriété myProperty de l'objet.

L'utilisation de -> reflète la relation d'appartenance de l'objet à une classe. C'est un moyen de spécifier que vous effectuez une opération sur une instance spécifique de cette classe.

En résumé, -> est un opérateur utilisé pour accéder aux membres (méthodes et propriétés) d'un objet en programmation orientée objet.












