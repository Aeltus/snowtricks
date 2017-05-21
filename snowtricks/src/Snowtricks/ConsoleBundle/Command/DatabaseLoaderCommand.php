<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 30/04/2017
 * Time: 11:09
 */
namespace Snowtricks\ConsoleBundle\Command;

use Snowtricks\CoreBundle\Entity\Group;
use Snowtricks\CoreBundle\Entity\Message;
use Snowtricks\CoreBundle\Entity\Picture;
use Snowtricks\CoreBundle\Entity\Trick;
use Snowtricks\CoreBundle\Entity\User;
use Snowtricks\CoreBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class DatabaseLoaderCommand extends ContainerAwareCommand
{
    private $em;
    
    protected function configure()
    {
        $this->setName('snowtricks:database:load')
             ->setDescription('Vide et regenere la base de donnees')
             ->setHelp('Cette commande vous permet de facilement generer les fixtures de la base de donnees.')
        ;
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->em = $this->getContainer()->get('doctrine')->getManager();

        $this->picturesFoldersClear($output);
        $this->databaseLoad($output);
        $this->picturesLoader($output);

        return 0;
    }

    private function databaseLoad($output){
        /*==============================================================================================================
        |                                                                                                              |
        |                                    Loading fixtures in database                                              |
        |                                                                                                              |
        ==============================================================================================================*/

        /* Groups loading
        ==================================================================*/
        $output->writeln('Insertion des groupes.');
        $groups = Yaml::parse(file_get_contents(__DIR__.'/../../CoreBundle/DataFixtures/Datas/GroupDatas.yml'));

        foreach ($groups['Groups']['name'] as $groupName){
            $group = new Group();
            $group->setName($groupName);
            $this->em->persist($group);
        }
        $this->em->flush();
        $listGroups = $this->em->getRepository('SnowtricksCoreBundle:Group')->findAll();

        /* Users loading
        ==================================================================*/
        $output->writeln('Insertion des utilisateurs.');
        $users = Yaml::parse(file_get_contents(__DIR__.'/../../CoreBundle/DataFixtures/Datas/UsersDatas.yml'));
        foreach ($users['Users'] as $key => $userData){
            $user = new User();
            foreach ($userData as $data => $value){
                $method = 'set'.ucfirst($data);
                $user->$method($value);
            }
            $this->em->persist($user);
        }
        $this->em->flush();
        $listUsers = $this->em->getRepository('SnowtricksCoreBundle:User')->findAll();

        /* Tricks loading
        ==================================================================*/
        $output->writeln('Insertion des Figures.');
        $tricks = Yaml::parse(file_get_contents(__DIR__.'/../../CoreBundle/DataFixtures/Datas/TricksDatas.yml'));
        foreach ($tricks['Tricks'] as $key => $trickData){
            $trick = new Trick();
            foreach ($trickData as $data => $value){
                $method = 'set'.ucfirst($data);
                $trick->$method($value);
                $trick->setCreatedBy($listUsers[rand(0, (count($listUsers)-1))]);
                $trick->setGroup($listGroups[rand(0, (count($listGroups)-1))]);
            }
            $this->em->persist($trick);
        }
        $this->em->flush();
        $listTricks = $this->em->getRepository('SnowtricksCoreBundle:Trick')->findAll();

        /* videos loading
        ==================================================================*/
        $output->writeln('Insertion des videos.');
        $videos = Yaml::parse(file_get_contents(__DIR__.'/../../CoreBundle/DataFixtures/Datas/VideosDatas.yml'));
        foreach ($videos['Videos'] as $videoAddress){
            $video = new Video();
            $video->setAddress($videoAddress);
            $video->setCreatedBy($listUsers[rand(0, (count($listUsers)-1))]);
            $video->setTrick($listTricks[rand(0, (count($listTricks)-1))]);

            $this->em->persist($video);
        }

        /* Messages loading
        ==================================================================*/
        $output->writeln('Insertion des messages.');
        $messages = Yaml::parse(file_get_contents(__DIR__.'/../../CoreBundle/DataFixtures/Datas/MessagesDatas.yml'));
        foreach ($messages['Messages'] as $messageContent){
            $message = new Message();
            $message->setMessage($messageContent);
            $message->setCreatedBy($listUsers[rand(0, (count($listUsers)-1))]);
            $message->setTrick($listTricks[rand(0, (count($listTricks)-1))]);

            $this->em->persist($message);
        }

        $this->em->flush();
        $output->writeln('Fin des insertions.');
    }

    private function picturesLoader($output){
        if (!$folder = opendir(__DIR__.'/../../CoreBundle/DataFixtures/Pictures/tricks')){
            return;
        }
        $output->writeln('Début du traitement des images.');
        $tricks = $this->em->getRepository('SnowtricksCoreBundle:Trick')->findAll();
        $users = $this->em->getRepository('SnowtricksCoreBundle:User')->findAll();
        $output->writeln('Images des figures.');
        $x = 1;
        while(false !== ($file = readdir($folder))) {


            if ($file != '.' && $file != '..'){
                $output->writeln('Image '.$x);
                $x++;
                $picture = $this->uploadPicture($file, 'tricks');
                $picture->createThumbnail(308, 173);
                $picture->setTrick($tricks[rand(0, (count($tricks)-1))]);
                $picture->setCreatedBy($users[rand(0, (count($users)-1))]);
                $this->em->persist($picture);
            }
        }

        $output->writeln('Images des utilisateurs.');
        $x=1;
        if (!$folder = opendir(__DIR__.'/../../CoreBundle/DataFixtures/Pictures/users')){
            return;
        }

        while(false !== ($file = readdir($folder))) {

            if ($file != '.' && $file != '..'){
                $output->writeln('Image '.$x);
                $picture = $this->uploadPicture($file, 'users');
                $picture->createThumbnail(115, 115);
                $picture->setCreatedBy($users[$x-1]);
                $users[$x-1]->setPicture($picture);
                $this->em->persist($picture);
                $x++;
            }
        }

        $this->em->flush();
    }

    private function uploadPicture($file, $dir){

        $ext = substr(strrchr($file,'.'),1);
        $newName = uniqid(rand(), true).'.'.$ext;
        $picture = new Picture();
        $picture->setAddress($newName);

        copy(__DIR__.'/../../CoreBundle/DataFixtures/Pictures/'.$dir.'/'.$file, __DIR__.'/../../../../web/'.$picture->getFullSize());

        return $picture;
    }

    private function picturesFoldersClear($output){
        $currentFolders = [__DIR__.'/../../../../web/uploads/tmp', __DIR__.'/../../../../web/uploads/fullSize',__DIR__.'/../../../../web/uploads/thumbnail'];
        foreach ($currentFolders as $currentFolder){
            $output->writeln('Debut de purge du dossier :'.$currentFolder);
            if (!$folder = opendir($currentFolder)){
                return;
            }
            while(false !== ($file = readdir($folder))) {
                if ($file != '.' && $file != '..'){
                    unlink($currentFolder.'/'.$file);
                }
            }
        }
        return 0;
    }

}
