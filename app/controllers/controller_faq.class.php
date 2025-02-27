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
                    ['question' => 'Qu’est-ce que GureKultura ?', 'answer' => 'GureKultura est une application dédiée à la culture basque.'],
                    ['question' => 'Comment fonctionne l’application ?', 'answer' => 'L’application vous permet de rechercher des événements, enregistrer vos favoris et obtenir des informations détaillées sur la culture basque.'],
                    ['question' => 'Sur quels appareils puis-je utiliser GureKultura ?', 'answer' => 'GureKultura est disponible sur mobile (Android, iOS) et sur le web.'],
                    ['question' => 'L’application est-elle gratuite ?', 'answer' => 'Oui, l’application est gratuite. Certaines fonctionnalités avancées peuvent nécessiter un abonnement.']
                ]
            ],
            [
                'name' => 'Contenu et Fonctionnalités',
                'questions' => [
                    ['question' => 'Quels types de contenus trouve-t-on sur GureKultura ?', 'answer' => 'Vous y trouverez des festivals, concerts, expositions, ateliers et bien plus encore !'],
                    ['question' => 'Comment rechercher un événement culturel près de chez moi ?', 'answer' => 'Utilisez la barre de recherche et filtrez par localisation pour voir les événements à proximité.'],
                    ['question' => 'Puis-je enregistrer mes événements favoris ?', 'answer' => 'Oui, vous pouvez enregistrer vos événements préférés dans votre compte utilisateur.'],
                    ['question' => 'Comment être informé des nouvelles activités culturelles ?', 'answer' => 'Activez les notifications dans les paramètres de votre compte pour recevoir des mises à jour.']
                ]
            ],
            [
                'name' => 'Comptes et Abonnements',
                'questions' => [
                    ['question' => 'Dois-je créer un compte pour utiliser GureKultura ?', 'answer' => 'Non, mais un compte vous permet d’accéder à des fonctionnalités supplémentaires comme la sauvegarde des favoris.'],
                    ['question' => 'Comment modifier mes informations personnelles ?', 'answer' => 'Rendez-vous dans les paramètres de votre compte pour modifier vos informations personnelles.'],
                    ['question' => 'Y a-t-il une version premium avec des fonctionnalités supplémentaires ?', 'answer' => 'Oui, une version premium offre des avantages exclusifs comme des réductions sur les billets.'],
                    ['question' => 'Comment supprimer mon compte ?', 'answer' => 'Vous pouvez supprimer votre compte dans les paramètres ou contacter notre support.']
                ]
            ],
            [
                'name' => 'Événements et Billetterie',
                'questions' => [
                    ['question' => 'Comment réserver un billet pour un événement ?', 'answer' => 'Les billets peuvent être réservés directement via l’application en accédant à la page de l’événement.'],
                    ['question' => 'Puis-je annuler ou modifier ma réservation ?', 'answer' => 'Cela dépend des conditions de l’organisateur. Vérifiez les détails sur la page de l’événement.'],
                    ['question' => 'Comment savoir si un événement est complet ?', 'answer' => 'Un indicateur de disponibilité est affiché sur chaque événement.'],
                    ['question' => 'Puis-je proposer un événement sur GureKultura ?', 'answer' => 'Oui, les organisateurs peuvent soumettre leurs événements via notre plateforme dédiée.']
                ]
            ],
            [
                'name' => 'Support et Contact',
                'questions' => [
                    ['question' => 'Que faire si j’ai un problème avec l’application ?', 'answer' => 'Contactez notre support via la section “Aide” de l’application.'],
                    ['question' => 'Comment signaler un bug ou une erreur sur un événement ?', 'answer' => 'Vous pouvez utiliser le bouton “Signaler un problème” sur la page de l’événement concerné.'],
                    ['question' => 'Comment contacter l’équipe de GureKultura ?', 'answer' => 'Nous sommes joignables par email à support@gurekultura.com ou via nos réseaux sociaux.']
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
