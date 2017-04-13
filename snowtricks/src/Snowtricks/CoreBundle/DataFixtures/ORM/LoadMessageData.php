<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 02/04/2017
 * Time: 17:01
 */
namespace Snowtricks\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Snowtricks\CoreBundle\Entity\Message;
use Snowtricks\CoreBundle\Entity\Trick;


class LoadMessageData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** Array DATA
         * =====================================*/
        $messages = array(
            "Super !!!",
            "J'aime bien cette figure, je la pratique tout le temps.",
            "Ah c'est pour les nuls ça !!!",
            "Moi je débute, je trouve ce site super pour apprendre.",
            "Vennez aux championnats du monde de snowboard l'hiver prochain dans les Alpes.",
            "Histoire de savoir, certains ici ont déjà réalisés cette figure ? Je veux dire sans rien se casser :) ?",
            "J'ai fais une vidéo de cette figure je la mettrai bientôt en ligne.",
            "J'ai jamais réussi à faire ça moi :(",
            "Quelle idée à bien pu traverser celui qui à inventé ça...",
            "Comment on fait pour faire ça ?",
            "Facile...",
            "Je fais ça quand je veux un effet qui pette pour impressionner mes potes...",
            "Cette figure est plus difficile qu'il n'y parrait...",
            "Easy :)",
            "Le tout c'est de ce lancer...",
            "Qui à déjà fait ça ?"
        );

        /** Persist DATA
         * =====================================*/
        foreach ($messages as $messageData) {
            $created_at = new \DateTime('NOW');
            $userNbr = rand(0, 2);
            $trickNbr = rand(0, 9);
            $created_by = $this->getReference('user' . $userNbr);
            $trick = $this->getReference('trick' . $trickNbr);
            $message = new Message(NULL, $trick, $created_by, $messageData,$created_at);
            $manager->persist($message);
        }

        /** Flushing DATA
         * =====================================*/
        $manager->flush();
    }
    public function getOrder()
    {
        return 6;
    }
}
