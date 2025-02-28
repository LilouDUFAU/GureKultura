<?php

/**
 * @class ControllerFaq
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "FAQ"
 */
class ControllerFaq extends Controller
{
    /**
     * @constructor ControllerFaq
     * @details Constructeur de la classe ControllerFaq
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader)
    {
        parent::__construct($twig, $loader);
    }

    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "FAQ"
     * @return void
     */
    public function lister()
    {
        $faq = [
            [
                'name' => 'Général',
                'questions' => [
                    ['question' => 'Qu’est-ce que GureKultura ?', 'answer' => 'GureKultura est une application dédiée à la découverte de la culture basque. Vous y trouverez diverses actualités et divers événements au sein de la région basque.'],
                    ['question' => 'A quoi sert GureKultura ?', 'answer' => 'GureKultura vous permet de rechercher et de vous inscrire à des événements, et lire des actualités sur la région basque.'],
                    ['question' => 'Sur quels appareils puis-je utiliser GureKultura ?', 'answer' => 'GureKultura une application web, qui est donc disponible sur tout appareils possédant un navigateur web.'],
                    ['question' => 'L’application est-elle gratuite ?', 'answer' => 'Oui, l’application est 100% gratuite.']
                ]
            ],
            [
                'name' => 'Contenu et Fonctionnalités',
                'questions' => [
                    ['question' => 'Quels types de contenus trouve-t-on sur GureKultura ?', 'answer' => 'Vous y trouverez des festivals, concerts, expositions, ateliers, sports, et bien plus encore !'],
                    ['question' => 'Comment rechercher un événement culturel près de chez moi ?', 'answer' => 'Utilisez la barre de recherche et filtrez par localisation pour voir les événements à proximité.'],
                    //['question' => 'Puis-je enregistrer mes événements favoris ?', 'answer' => 'Oui, vous pouvez enregistrer vos événements préférés dans votre compte utilisateur.'],
                    //['question' => 'Comment être informé des nouvelles activités culturelles ?', 'answer' => 'Activez les notifications dans les paramètres de votre compte pour recevoir des mises à jour.']
                ]
            ],
            [
                'name' => 'Comptes',
                'questions' => [
                    ['question' => 'Dois-je créer un compte pour utiliser GureKultura ?', 'answer' => 'Non, mais un compte vous permet d’accéder à des fonctionnalités supplémentaires comme la capacité de vous inscrire à des événements, ou encore la possibilité de publier les vôtres.'],
                    ['question' => 'Comment modifier mes informations personnelles ?', 'answer' => 'Rendez-vous dans les paramètres de votre compte, puis dans Editer le profil.'],
                    ['question' => 'Y a-t-il une version premium avec des fonctionnalités supplémentaires ?', 'answer' => 'Non, GureKultura ne possède pas de fonctionnalités premium.'],
                    ['question' => 'Comment supprimer mon compte ?', 'answer' => 'Vous pouvez supprimer votre compte en allant dans les paramètres, dans Editer le profil, puis en cliquant sur Supprimer, ou alors en contactant notre support.']
                ]
            ],
            [
                'name' => 'Événements et inscriptions',
                'questions' => [
                    ['question' => 'Comment faire pour s\'inscrire à un événement ?', 'answer' => 'Rendez vous sur la page de l\'événement auquel vous souhaitez vous inscrire, puis cliquez sur le bouton S\'inscrire.'],
                    ['question' => 'Puis-je annuler mon inscription ?', 'answer' => 'Rendez vous sur la page de l\'événement auquel vous souhaitez vous inscrire, puis cliquez sur le bouton Se désinscrire.'],
                    ['question' => 'Comment savoir si un événement est complet ?', 'answer' => 'Un indicateur de disponibilité est affiché sur chaque événement.'],
                    ['question' => 'Puis-je proposer un événement sur GureKultura ?', 'answer' => 'Oui, les organisateurs peuvent soumettre leurs événements via notre plateforme dédiée. Pour cela, après connection à votre compte GureKultura, allez en haut de la page et cliquez sur Proposer. Vous serez ensuite incités à remplir un formulaire contenant les informations de votre événement. Une fois le formulaire rempli, cliquez sur Proposer, puis patientez le temps qu\'un de nos modérateurs vérifie la validité de votre événement.']
                ]
            ],
            [
                'name' => 'Support et Contact',
                'questions' => [
                    ['question' => 'Que faire si j’ai un problème avec l’application ?', 'answer' => 'Contactez notre support via la section “Aide” de l’application.'],
                    ['question' => 'Comment signaler un bug ou une erreur sur un événement ?', 'answer' => 'Vous pouvez utiliser le bouton “Signaler un problème” sur la page de l’événement concerné.'],
                    ['question' => 'Comment contacter l’équipe de GureKultura ?', 'answer' => 'Nous sommes joignables par email à gurekultura@gmail.com.'] //Si on les implémente, ajouter : ou via nos réseaux sociaux
                ]
            ]
        ];

        $managerCategorie = new CategorieDao($this->getPdo());
        $categorie = $managerCategorie->findAll();
        // Rendre le template Twig avec la FAQ
        echo $this->getTwig()->render('faq.html.twig', [
            'title' => 'FAQ',
            'faq' => $faq,
            'categories' => $categorie
        ]);
    }
}
