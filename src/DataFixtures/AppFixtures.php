<?php

namespace App\DataFixtures;

use App\Entity\Projet;
use App\Entity\Livre;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Etat;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasherPassword;

    public function __construct(UserPasswordHasherInterface $hasher){
           $this->hasherPassword=$hasher; 
    }
    
    public function load(ObjectManager $manager): void
    {

        $admin=new User();
        $admin->setEmail("admin@gmail.com");
        $admin->setUsername("admin");
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword($this->hasherPassword->hashPassword(
            $admin,
            "12345678"
        ));
        $admin->setCode('');
        $admin->setImage('admin.jpg');
        $manager->persist($admin);

        $user1=new User();
        $user1->setEmail("user1@gmail.com");
        $user1->setUsername("Akari");
        $user1->setRoles(["ROLE_USER"]);
        $user1->setPassword($this->hasherPassword->hashPassword(
            $user1,
            "12345678"
        ));
        $user1->setAdresse('147, rue Saint-Exupery');
        $user1->setImage('user1.jpg');
        $manager->persist($user1);

        $user2=new User();
        $user2->setEmail("emyholmes@gmail.com");
        $user2->setUsername("Emy");
        $user2->setRoles(["ROLE_USER"]);
        $user2->setPassword($this->hasherPassword->hashPassword(
            $user2,
            "12345678"
        ));
        $user2->setAdresse('18, rue de la malice');
        $user2->setImage('user2.jpg');
        $manager->persist($user2);

        $user3=new User();
        $user3->setEmail("girlinthesouth@gmail.com");
        $user3->setUsername("Girl in the South");
        $user3->setRoles(["ROLE_USER"]);
        $user3->setPassword($this->hasherPassword->hashPassword(
            $user3,
            "12345678"
        ));
        $user3->setAdresse('50, rue des visions');
        $user3->setImage('user2.jpg');
        $manager->persist($user3);

        $projet1=new Projet();
        $projet1->setName("slogan");
        $projet1->setValue("Bienvenue sur BookStream");
        $manager->persist($projet1);

        $lorem="Plongez dans les pages, écoutez les mots.";
        $projet2=new Projet();
        $projet2->setName("presentation");
        $projet2->setValue($lorem);
        $manager->persist($projet2);

        //////////////////////////////////////// ETATS /////////////////////////////////////

        $etat1=new Etat();
        $etat1->setStatut("En Cours");
        $manager->persist($etat1);

        $etat2=new Etat();
        $etat2->setStatut("Brouillon");
        $manager->persist($etat2);

        $etat3=new Etat();
        $etat3->setStatut("Archivé");
        $manager->persist($etat3);

        $etat4=new Etat();
        $etat4->setStatut("Terminé");
        $manager->persist($etat4);

        //////////////////////////////////////// CATEGORIES /////////////////////////////////////

        $category1=new Category();
        $category1->setDescription("Fanfiction");
        $manager->persist($category1);

        $category2=new Category();
        $category2->setDescription("Livres Audios");
        $manager->persist($category2);

        $category3=new Category();
        $category3->setDescription("Fantasy");
        $manager->persist($category3);

        $category4=new Category();
        $category4->setDescription("EnemyToLovers");
        $manager->persist($category4);

        $category5=new Category();
        $category5->setDescription("Crossover");
        $manager->persist($category5);

        $category6=new Category();
        $category6->setDescription("Thriller");
        $manager->persist($category6);

        //////////////////////////////////////// LIVRES /////////////////////////////////////

        $livre1=new Livre();
        $livre1->setTitle("L'Espionne du Cardinal - Livre I");
        $livre1->setContent("Paris, XVIIème siècle Céleste n'est pas une jeune femme comme les autres. 
        Et pour cause... Du haut de ses vingt-cinq ans, elle est la meilleure meurtrière, voleuse et espionne de l'homme le 
        plus puissant du royaume de France : le Cardinal de Richelieu. Accompagnée de son fidèle frère, Alec, elle enchaîne missions et 
        assassinats pour le Cardinal, qu'elle considère comme son père. Jusqu'au jour où, sous les faux traits de la jeune Colombe, 
        comtesse de Vertus, Céleste entre à la cour avec un seul et unique but : espionner la Reine Anne d'Autriche. Mais à partir de 
        ce moment-là, plus rien ne se passe comme prévu : on attente à la vie de la reine, Céleste découvre petit à petit de terribles secrets, 
        et rencontre un homme qu'elle n'aurait jamais dû rencontrer, et encore moins apprécier... Son nom seul aurait dû la dégoutter 
        et l'éloigner. Et ce nom... Il s'agit de Jean-Armand de Tréville, Capitaine des Mousquetaires du Roi.");
        $livre1->setCreatedAt(new DateTimeImmutable());
        $livre1->setModifiedAt(new DateTimeImmutable());
        $livre1->setUser($user2);
        $livre1->setCategory($category1, $category3);
        $livre1->setEtat($etat4);
        $livre1->setAudio("");
        $livre1->setImage("livre1-mousquetaires.jpg");
        $manager->persist($livre1);

        $livre2=new Livre();
        $livre2->setTitle("Le Secret de Lomé - Livre I");
        $livre2->setContent("Un destin à accomplir. Un peuple à libérer.
        Lomé mène une vie parfaite, jusqu'au jour où, lors d'une excursion, elle tombe au fond d'une grotte et resurgit dans une contrée inhospitalière et terriblement dangereuse : Bâl'Shanta.
        Dans ce monde peuplé de créatures extraordinaires, la jeune fille, qui a toujours obtenu ce qu'elle voulait, découvre une civilisation organisée en castes et se retrouve assimilée à celle des esclaves.
        Pour survivre et espérer rentrer chez elle, Lomé devra faire preuve d'une grande force de caractère et se battre. Heureusement elle pourra compter sur le soutien d'alliés inattendus...
        Bonne écoute ! ❤😉");
        $livre2->setCreatedAt(new DateTimeImmutable());
        $livre2->setModifiedAt(new DateTimeImmutable());
        $livre2->setUser($user3);
        $livre2->setCategory($category2, $category3);
        $livre2->setEtat($etat1);
        $livre2->setImage("lomé.jpg");
        $livre2->setAudio("Secret_Lome.mp3");
        $manager->persist($livre2);

        $livre3=new Livre();
        $livre3->setTitle("Quelque chose s'achève, quelque chose commence - Naruto Story");
        $livre3->setContent("Après sa mort, Hitomi se réveilla dans un monde où les conflits se règlaient à torrents de feu et mers de boues 
        envoyés à la figure d'un adversaire. Puisqu'elle n'était alors, à ce moment-là, qu'un bébé, elle décida de profiter de cette période 
        pour tirer des plans pour sortir vivante de tout ce bordel et des évènements à venir. Et si, au passage, elle pouvait envoyer Danzô 
        se faire foutre au pays des arc-en-ciels, sauver quelques personnages et faire en sorte qu'un certain démon-renard soit aimé et 
        entouré dès son plus jeune âge... Eh bien, c'était tout gagné, pas vrai ?");
        $livre3->setCreatedAt(new DateTimeImmutable());
        $livre3->setModifiedAt(new DateTimeImmutable());
        $livre3->setUser($user1);
        $livre3->setCategory($category5, $category1);
        $livre3->setEtat($etat4);
        $livre3->setAudio("");
        $livre3->setImage("naruto.jpg");
        $manager->persist($livre3);

        $livre4=new Livre();
        $livre4->setTitle("Le Retour de L'Espionne - Livre II");
        $livre4->setContent("Suite du livre L'Espionne du Cardinal, à lire en premier de préférence.
        Six ans se sont écoulés. Six longues années où Céleste, l'ancienne Espionne du Cardinal, s'est terrée dans le royaume de France, 
        priant pour ne jamais plus recroiser les mousquetaires. Mais les choses ont bien changées : Richelieu est mort, la guerre contre 
        l'Espagne fait rage, Tréville est devenu Ministre de la Guerre, et les mousquetaires reviennent à peine des combats en tant que héros 
        de guerre.Malheureusement pour la jeune femme, son destin semble lié à celui des cinq hommes qu'elle a appris à connaître et à 
        aimer, il y a bien longtemps de cela. Aura-t-elle le courage de faire marche arrière, d'oublier son passé, et d'aller demander 
        pardon à ceux qu'elle a blessé ? Mais le plus incertain dans cette histoire... Les mousquetaires pourront-ils pardonner ? 
        Les mousquetaires voudront-ils pardonner ? Et, surtout, Tréville... Pourrait-il, lui, accepter le retour de la femme qu'il a tant 
        aimé mais qui l'a trahi ? Mais qu'importe leurs décisions et leurs sentiments respectifs, les mousquetaires et l'ancienne 
        espionne vont devoir allier leurs forces pour vaincre un ennemi des plus puissants, et ainsi, peut-être, survivre et enfin avoir 
        droit à leurs propres fins heureuses...");
        $livre4->setCreatedAt(new DateTimeImmutable());
        $livre4->setModifiedAt(new DateTimeImmutable());
        $livre4->setUser($user2);
        $livre4->setCategory($category1, $category3);
        $livre4->setEtat($etat1);
        $livre4->setAudio("");
        $livre4->setImage("livre2-mousquetaires.jpg");
        $manager->persist($livre4);

        $livre5=new Livre();
        $livre5->setTitle("The Travel Dreamer");
        $livre5->setContent("Il y a bien longtemps, dans une galaxie lointaine, très lointaine...
        L'Empire n'est plus, et ce depuis plusieurs années déjà. La vie a repris son cours mais pour certains, rien n'a changé. 
        Elle est toujours sur Ongarth, elle répare toujours des vaisseaux. Elle écoute encore les histoires de ses clients et ne rêve que de 
        quitter cette planète montagneuse, partir à la découverte de la galaxie. Mais elle est esclave et spéciale. 
        Le Mandalorien, accompagné d'un être précieux aux vestiges de l'Empire et aux croyances Jedi, va vite se rendre compte de la 
        particularité de cette mécanicienne aux yeux mauves. Des capacités en mécaniques impressionnantes et des aptitudes aux combats 
        remarquables pour son âge, Eowyn ne tardera pas à prendre son envol vers un rêve qu'elle pensait impossible à atteindre.");
        $livre5->setCreatedAt(new DateTimeImmutable());
        $livre5->setModifiedAt(new DateTimeImmutable());
        $livre5->setUser($user3);
        $livre5->setCategory($category1, $category3, $category5);
        $livre5->setEtat($etat1);
        $livre5->setAudio("");
        $livre5->setImage("traveldreamer.jpg");
        $manager->persist($livre5);

        $livre6=new Livre();
        $livre6->setTitle("Sombra");
        $livre6->setContent("Lorsque'Amara Verdana revient en Californie après cinq ans d'absence, elle n'est plus la jeune fille éprise 
        de musique et de poésie que connaissaient ses parents. Sa fougue naturelle l'a menée à apprendre le maniement des armes, et les 
        nouvelles venues de Los Angeles la forcent à rentrer à la maison pour combattre aux côtés de Zorro, le célèbre justicier masqué. 
        Alors qu'elle prépare son masque, Amara est cependant tout autant confrontée aux injustices qui règnent qu'aux histoires de coeur... 
        pas facile, d'être une justicière masquée, surtout quand on est tellement incertaine de ses sentiments! Tous Droits Réservés");
        $livre6->setCreatedAt(new DateTimeImmutable());
        $livre6->setModifiedAt(new DateTimeImmutable());
        $livre6->setUser($user1);
        $livre6->setCategory($category1, $category3);
        $livre6->setEtat($etat4);
        $livre6->setAudio("");
        $livre6->setImage("sombra.jpg");
        $manager->persist($livre6);

        $livre7=new Livre();
        $livre7->setTitle("La danse du feu");
        $livre7->setContent("Le monde avait été en proie à un tel désespoir depuis si longtemps que la moindre perspective d'un monde 
        meilleur prenait des ampleurs disproportionnées. L'espoir qui envahissait les coeurs de la population face à la rumeur du 
        retour de l'avatar venait contrer tout ce qu'avait réussi à construire le royaume du feu.
        La rumeur disait que l'avatar était de retour et si cela était vrai il était le seul à pouvoir l'aider.
        Elle devait le trouver.");
        $livre7->setCreatedAt(new DateTimeImmutable());
        $livre7->setModifiedAt(new DateTimeImmutable());
        $livre7->setUser($user2);
        $livre7->setCategory($category1);
        $livre7->setEtat($etat1);
        $livre7->setAudio("");
        $livre7->setImage("dansefeu.jpg");
        $manager->persist($livre7);

        $livre8=new Livre();
        $livre8->setTitle("La Fille de Molo");
        $livre8->setContent("Dans la ville de New York où tout le monde parle du nouveau héros baptisé Iron man. 
        Une enfant est retrouvée inconsciente entourée de loups, tous sans vie. Celle-ci attirera l'attention particulière du shield. 
        Elle sera confiée à deux scientifiques, Bruce Banner et Tony Stark pour tenter de comprendre qui est cette enfant et ce qui 
        lui est arrivé.Elle tissera un lien fort et particulier avec le grand Tony Stark. La jeune fille essaiera d'évoluer dans un 
        monde qu'elle ne connait pas entourée d'agents du shield et de personnes hors du communs. 
        Son héritage sera convoité par ses ennemis. Les loups seront sa légion et Hydra sera leur proie.");
        $livre8->setCreatedAt(new DateTimeImmutable());
        $livre8->setModifiedAt(new DateTimeImmutable());
        $livre8->setUser($user1);
        $livre8->setCategory($category1);
        $livre8->setEtat($etat4);
        $livre8->setAudio("");
        $livre8->setImage("filleMolo.jpg");
        $manager->persist($livre8);

        $livre9=new Livre();
        $livre9->setTitle("Le jeu des dieux");
        $livre9->setContent("Les dieux ont un plan pour chacun d'entre nous...
        Nous ne contrôlons pas notre vie encore moins notre destin. Tu ne peut pas interférer avec les plan des dieux Percy 
        Non ! j'ai choisi de le faire, je t'ai choisi, peu m'importe ce que dit cette vieille momie fossiliser, 
        nous rentrerons ensemble dans ce maudit camp et je te dirait je te l'avais dit");
        $livre9->setCreatedAt(new DateTimeImmutable());
        $livre9->setModifiedAt(new DateTimeImmutable());
        $livre9->setUser($user3);
        $livre9->setCategory($category1);
        $livre9->setEtat($etat1);
        $livre9->setAudio("");
        $livre9->setImage("jeudieux.jpg");
        $manager->persist($livre9);

        $livre10=new Livre();
        $livre10->setTitle("L'Histoire d'Animalix");
        $livre10->setContent("Je m'appelle Animalix et voici mon histoire chez les X-Men: depuis que Charles Xavier (jeune) m'a trouvé, 
        jusqu'à mon inclusion dans la fantastique équipe des  X-Men. ");
        $livre10->setCreatedAt(new DateTimeImmutable());
        $livre10->setModifiedAt(new DateTimeImmutable());
        $livre10->setUser($user1);
        $livre10->setCategory($category1);
        $livre10->setEtat($etat1);
        $livre10->setAudio("");
        $livre10->setImage("animalix.jpg");
        $manager->persist($livre10);

        //////////////////////////////////////// COMMENTAIRES /////////////////////////////////////

        $comment1=new Comment();
        $comment1->setContent("Magnifique histoire avec une très jolie plume pour l'écriture ! J'ai dévorée le livre ! Vivement le 2ème tome");
        $comment1->setLivre($livre1);
        $comment1->setCreatedAt(new DateTimeImmutable());
        $comment1->setUser($user3);
        $manager->persist($comment1);

        $comment2=new Comment();
        $comment2->setContent("Le passé d'Eowyn est tellement triste mais l'histoire est tellement prenante ! A quand la suite ?");
        $comment2->setLivre($livre5);
        $comment2->setCreatedAt(new DateTimeImmutable());
        $comment2->setUser($user2);
        $manager->persist($comment2);

        $comment3=new Comment();
        $comment3->setContent("Wow ! Cette histoire te donne des frissons du début à la fin. J'adore ton style d'écriture! C'est possible qu'on se DM pour en parler ?");
        $comment3->setLivre($livre8);
        $comment3->setCreatedAt(new DateTimeImmutable());
        $comment3->setUser($user1);
        $manager->persist($comment3);

        $comment4=new Comment();
        $comment4->setContent("Il est très rare de trouver des livres sur Zorro et ce livre est aussi génial que la série ou les films ! Si vous souhaitez lire un roman de cape et d'épéé c'est par ici !");
        $comment4->setLivre($livre6);
        $comment4->setCreatedAt(new DateTimeImmutable());
        $comment4->setUser($user3);
        $manager->persist($comment4);

        $comment5=new Comment();
        $comment5->setContent("Moi qui rêvais d'un self-insert dans un anime c'est chose faite ! L'héroîne est tellement badass !");
        $comment5->setLivre($livre3);
        $comment5->setCreatedAt(new DateTimeImmutable());
        $comment5->setUser($user2);
        $manager->persist($comment5);

        $comment6=new Comment();
        $comment6->setContent("Je ne m'attendais pas à ce style d'écriture, c'est particulier mais on se laisse embarquer dans l'histoire. Juste un conseil ne plublie pas trop d'un coup ou ton rythme de publication va le sentir...");
        $comment6->setLivre($livre7);
        $comment6->setCreatedAt(new DateTimeImmutable());
        $comment6->setUser($user1);
        $manager->persist($comment6);

        $manager->flush();

    }
}
