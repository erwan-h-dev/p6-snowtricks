<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(
        private HttpClientInterface $client
    ) { }

    public function load(ObjectManager $manager): void
    {
        $categorieRepository = $manager->getRepository(Categorie::class);
        $utilisateurRepository = $manager->getRepository(Utilisateur::class);

        $utilisateur = $utilisateurRepository->findOneBy(['username' => 'admin']);
        $categories = $categorieRepository->findAll();

        $tricksData = [
            [
                'title' => "Les grabs",
                'content' => "<p>Un&nbsp;<em>grab</em> consiste &agrave; attraper la planche avec la main pendant le saut. Le verbe anglais <em>to grab</em>&nbsp;signifie &laquo;&nbsp;attraper.&nbsp;&raquo;</p>
                    <p>Il existe plusieurs types de&nbsp;<em>grabs</em>&nbsp;selon la position de la saisie et la main choisie pour l'effectuer, avec des difficult&eacute;s variables&nbsp;:</p>
                    <ul>
                    <li><strong>mute</strong>&nbsp;: saisie de la carre&nbsp;<em>frontside</em>&nbsp;de la planche entre les deux pieds avec la main avant&nbsp;;</li>
                    <li><strong>sad</strong>&nbsp;ou&nbsp;<strong>melancholie</strong>&nbsp;ou&nbsp;<strong>style week</strong>&nbsp;: saisie de la carre&nbsp;<em>backside</em>&nbsp;de la planche, entre les deux pieds, avec la main avant&nbsp;;</li>
                    <li><strong>indy</strong>&nbsp;: saisie de la carre&nbsp;<em>frontside</em>&nbsp;de la planche, entre les deux pieds, avec la main arri&egrave;re&nbsp;;</li>
                    <li><strong>stalefish</strong>&nbsp;: saisie de la carre&nbsp;<em>backside</em>&nbsp;de la planche entre les deux pieds avec la main arri&egrave;re&nbsp;;</li>
                    <li><strong>tail grab</strong>&nbsp;: saisie de la partie arri&egrave;re de la planche, avec la main arri&egrave;re&nbsp;;</li>
                    <li><strong>nose grab</strong>&nbsp;: saisie de la partie avant de la planche, avec la main avant&nbsp;;</li>
                    <li><strong>japan</strong>&nbsp;ou&nbsp;<strong>japan air</strong>&nbsp;: saisie de l'avant de la planche, avec la main avant, du c&ocirc;t&eacute; de la carre&nbsp;<em>frontside</em>.</li>
                    <li><strong>seat belt</strong>: saisie du carre frontside &agrave; l'arri&egrave;re avec la main avant&nbsp;;</li>
                    <li><strong>truck driver</strong>: saisie du carre avant et carre arri&egrave;re avec chaque main (comme tenir un volant de voiture)</li>
                    </ul>
                    <p>Un&nbsp;<em>grab</em>&nbsp;est d'autant plus r&eacute;ussi que la saisie est longue. De plus, le saut est d'autant plus esth&eacute;tique que la saisie du snowboard est franche, ce qui permet au rideur d'accentuer la torsion de son corps gr&acirc;ce &agrave; la tension de sa main sur la planche. On dit alors que le grab est&nbsp;<em>tweak&eacute;</em>&nbsp;(le verbe anglais&nbsp;<em>to tweak</em>&nbsp;signifie &laquo;&nbsp;pincer&nbsp;&raquo; mais a &eacute;galement le sens de &laquo;&nbsp;peaufiner&nbsp;&raquo;).</p>"
            ], [
                'title' => "Les rotations",
                'content' => "<p>On d&eacute;signe par le mot &laquo;&nbsp;rotation&nbsp;&raquo; uniquement des rotations horizontales&nbsp;; les rotations verticales sont des&nbsp;<em>flips</em>. Le principe est d'effectuer une rotation horizontale pendant le saut, puis d'att&eacute;rir en position switch ou normal. La nomenclature se base sur le nombre de degr&eacute;s de rotation effectu&eacute;s &nbsp;:</p>
                <ul>
                <li>un&nbsp;<em>180</em>&nbsp;d&eacute;signe un demi-tour, soit 180 degr&eacute;s d'angle&nbsp;;</li>
                <li><em>360</em>,&nbsp;<em>trois six</em>&nbsp;pour un tour complet&nbsp;;</li>
                <li><em>540</em>,&nbsp;<em>cinq quatre</em>&nbsp;pour un tour et demi&nbsp;;</li>
                <li><em>720</em>,&nbsp;<em>sept deux</em>&nbsp;pour deux tours complets&nbsp;;</li>
                <li><em>900</em>&nbsp;pour deux tours et demi&nbsp;;</li>
                <li><em>1080</em>&nbsp;ou&nbsp;<em>big foot</em>&nbsp;pour trois tours&nbsp;;</li>
                <li>etc.</li>
                </ul>
                <p>Une rotation peut &ecirc;tre&nbsp;<em>frontside</em>&nbsp;ou&nbsp;<em>backside</em>&nbsp;: une rotation&nbsp;<em>frontside</em>&nbsp;correspond &agrave; une rotation orient&eacute;e vers la carre&nbsp;<em>backside</em>. Cela peut para&icirc;tre incoh&eacute;rent mais l'origine &eacute;tant que dans un&nbsp;<em>halfpipe</em> ou une rampe de skateboard, une rotation&nbsp;<em>frontside</em>&nbsp;se d&eacute;clenche naturellement depuis une position&nbsp;<em>frontside</em>&nbsp;(<em>i.e.</em>&nbsp;l'appui se fait sur la carre frontside), et vice-versa. Ainsi pour un rider qui a une position&nbsp;<em>regular</em>&nbsp;(pied gauche devant), une rotation&nbsp;<em>frontside</em>&nbsp;se fait dans le sens inverse des aiguilles d'une montre.</p>
                <p>Une rotation peut &ecirc;tre agr&eacute;ment&eacute;e d'un grab, ce qui rend le saut plus esth&eacute;tique mais aussi plus difficile car la position tweak&eacute;e a tendance &agrave; d&eacute;s&eacute;quilibrer le rideur et d&eacute;saxer la rotation. De plus, le sens de la rotation a tendance &agrave; favoriser un sens de grab plut&ocirc;t qu'un autre. Les rotations de plus de trois tours existent mais sont plus rares, d'abord parce que les modules assez gros pour lancer un tel saut sont rares, et ensuite parce que la vitesse de rotation est tellement &eacute;lev&eacute;e qu'un grab devient difficile, ce qui rend le saut consid&eacute;rablement moins esth&eacute;tique.</p>
                <p>Pour entrer sur une barre de slide, le rideur peut se mettre perpendiculaire &agrave; l'axe de la barre et fera donc un quart de tour en l'air,&nbsp;<em>modulo</em>&nbsp;360 degr&eacute;s &mdash; il est possible de faire&nbsp;<em>n</em>&nbsp;tours complets plus un quart de tour. On a donc la d&eacute;nomination suivante pour ce type de rotations&nbsp;:</p>
                <ul>
                <li><em>90</em>&nbsp;pour un quart de tour simple&nbsp;;</li>
                <li><em>270</em>&nbsp;pour trois quarts de tours&nbsp;;</li>
                <li><em>450</em>&nbsp;pour un tour un quart&nbsp;;</li>
                <li><em>630</em>&nbsp;pour un tour trois quarts&nbsp;;</li>
                <li><em>810</em>&nbsp;pour deux tours un quart&nbsp;;</li>
                <li>etc.</li>
                </ul>"
            ], [
                'title' => "Les flips",
                'content' => "<p>Un&nbsp;<strong>flip</strong>&nbsp;est une rotation verticale. On distingue les&nbsp;<strong>front flips</strong>, rotations en avant, et les&nbsp;<strong>back flips</strong>, rotations en arri&egrave;re.</p>
                <p>Il est possible de faire plusieurs flips &agrave; la suite, et d'ajouter un grab &agrave; la rotation.</p>
                <p>Les flips agr&eacute;ment&eacute;s d'une vrille existent aussi (<em>Mac Twist</em>,&nbsp;<em>Hakon Flip</em>...), mais de mani&egrave;re beaucoup plus rare, et se confondent souvent avec certaines rotations horizontales d&eacute;sax&eacute;es.</p>
                <p>N&eacute;anmoins, en d&eacute;pit de la difficult&eacute; technique relative d'une telle figure, le danger de retomber sur la t&ecirc;te ou la nuque est r&eacute;el et conduit certaines stations de ski &agrave; interdire de telles figures dans ses snowparks.</p>"
            ], [
                'title' => "Les rotations désaxées",
                'content' => "<p>Une rotation d&eacute;sax&eacute;e est une rotation initialement horizontale mais lanc&eacute;e avec un mouvement des &eacute;paules particulier qui d&eacute;saxe la rotation. Il existe diff&eacute;rents types de rotations d&eacute;sax&eacute;es (<em>corkscrew</em>&nbsp;ou&nbsp;<em>cork</em>,&nbsp;<em>rodeo</em>,&nbsp;<em>misty</em>, etc.) en fonction de la mani&egrave;re dont est lanc&eacute; le buste. Certaines de ces rotations, bien qu'initialement horizontales, font passer la t&ecirc;te en bas.</p>
                <p>Bien que certaines de ces rotations soient plus faciles &agrave; faire sur un certain nombre de tours (ou de demi-tours) que d'autres, il est en th&eacute;orie possible de d'att&eacute;rir n'importe quelle rotation d&eacute;sax&eacute;e avec n'importe quel nombre de tours, en jouant sur la quantit&eacute; de d&eacute;saxage afin de se retrouver &agrave; la position verticale au moment voulu.</p>
                <p>Il est &eacute;galement possible d'agr&eacute;menter une rotation d&eacute;sax&eacute;e par un grab.</p>"
            ], [
                'title' => "Les slides",
                'content' => "<p>Un&nbsp;<strong>slide</strong> consiste &agrave; glisser sur une barre de slide. Le slide se fait soit avec la planche dans l'axe de la barre, soit perpendiculaire, soit plus ou moins d&eacute;sax&eacute;.</p>
                <p>On peut slider avec la planche centr&eacute;e par rapport &agrave; la barre (celle-ci se situe approximativement au-dessous des pieds du rideur), mais aussi en&nbsp;<strong>nose slide</strong>, c'est-&agrave;-dire l'avant de la planche sur la barre, ou en&nbsp;<strong>tail slide</strong>, l'arri&egrave;re de la planche sur la barre.</p>"
            ], [
                'title' => "Les one foot tricks",
                'content' => "<p>Figures r&eacute;alis&eacute;e avec un pied d&eacute;croch&eacute; de la fixation, afin de tendre la jambe correspondante pour mettre en &eacute;vidence le fait que le pied n'est pas fix&eacute;. Ce type de figure est extr&ecirc;mement dangereuse pour les ligaments du genou en cas de mauvaise r&eacute;ception.</p>"
            ], [
                'title' => "Old school",
                'content' => "<p>Le terme&nbsp;<em>old school</em>&nbsp;d&eacute;signe un style de&nbsp;<em>freestyle</em>&nbsp;caract&eacute;ris&eacute;e par en ensemble de figure et une mani&egrave;re de r&eacute;aliser des figures pass&eacute;e de mode, qui fait penser au freestyle des ann&eacute;es 1980 - d&eacute;but 1990 (par opposition &agrave;&nbsp;<em>new school</em>)&nbsp;:</p>
                <ul>
                <li>figures d&eacute;su&egrave;tes&nbsp;:&nbsp;<em>Japan air</em>,&nbsp;<em>rocket air</em>, ...</li>
                <li>rotations effectu&eacute;es avec le corps tendu</li>
                <li>figures saccad&eacute;es, par opposition au style&nbsp;<em>new school</em>&nbsp;qui privil&eacute;gie l'amplitude</li>
                </ul>
                <p>&Agrave; noter que certains tricks&nbsp;<em>old school</em>&nbsp;restent ind&eacute;modables&nbsp;:</p>
                <ul>
                <li><em>Backside Air</em></li>
                <li><em>Method Air</em></li>
                </ul>"
                ]
                
        ];
            

        foreach ($tricksData as $trickData) {
            $trick = new Trick();
            $trick->setTitle($trickData['title'])
                ->setCategorie($categories[rand(0, count($categories) - 1)])
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime())
                ->setContent($trickData['content'])
                ->setAuteur($utilisateur)
            ;

            $manager->persist($trick);
        }

        for($i = 1; $i <= 30; $i++) {
            $trick = new Trick();

            $response = $this->client->request(
                'GET',
                'https://loripsum.net/api/4/medium/headers/ul/decorate'
            );

            $trick->setTitle('Trick ' . $i)
                ->setCategorie($categories[rand(0, count($categories) - 1)])
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime())
                ->setContent($response->getContent())
                ->setAuteur($utilisateur)
            ;

            $manager->persist($trick);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategorieFixtures::class,
            UtilisateurFixtures::class,
        ];
    }
}
