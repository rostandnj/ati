<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Antenne;
use AppBundle\Entity\Poste;
use AppBundle\Entity\Magasin;
use AppBundle\Entity\Image;
use AppBundle\Entity\Role;
use AppBundle\Entity\Article;
use AppBundle\Entity\File;

class LoadUserData extends Controller implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        
        
    	
    	$poste1 = new Poste();
    	$poste1->setLibelle("Poste 1");
    	$poste1->setAttribution("Attribution1");

    	$poste2 = new Poste();
    	$poste2->setLibelle("Poste 2");
    	$poste2->setAttribution("Attribution2");

    	$poste3 = new Poste();
    	$poste3->setLibelle("Poste 3");
    	$poste3->setAttribution("Attribution3");

        $poste4 = new Poste();
        $poste4->setLibelle("Poste 4");
        $poste4->setAttribution("Attribution4");





    	$antenne1= new Antenne();
		$antenne1->setLibelle("Antenne 1");
        $antenne1->setVille("Yaounde");
        $antenne1->setPays("Cameroun");
        $antenne1->setContact("00237698547895");
        $antenne1->setEmail("atiyaounde@ati.cm");

        $antenne2= new Antenne();
		$antenne2->setLibelle("Antenne 2");
        $antenne2->setVille("Douala");
        $antenne2->setPays("Cameroun");
        $antenne2->setContact("00237698547896");
        $antenne2->setEmail("atidouala@ati.cm");

        $antenne3= new Antenne();
        $antenne3->setLibelle("Antenne 3");
        $antenne3->setVille("Buea");
        $antenne3->setPays("Cameroun");
        $antenne3->setContact("00237698547897");
        $antenne3->setEmail("atibuea@ati.cm");

        $manager->persist($poste1);
    	$manager->persist($poste2);
    	$manager->persist($poste3);
        $manager->persist($poste4);
    	$manager->persist($antenne1);
    	$manager->persist($antenne2);
        $manager->persist($antenne3);
    	$manager->flush();

        $img1 = new Image();
        $img1->setNom("otdr.jpg");
        $img1->setSize(199746);
        $img1->setPath("otdr.jpg");
        $img1->setExtension(".jpg");
        $img1->setType("article");

        $img2 = new Image();
        $img2->setNom("powermeter.jpg");
        $img2->setSize(85841);
        $img2->setPath("powermeter.jpg");
        $img2->setExtension(".jpg");
        $img2->setType("article");

        $img3 = new Image();
        $img3->setNom("fibre.jpg");
        $img3->setSize(68570);
        $img3->setPath("fibre.jpg");
        $img3->setExtension(".jpg");
        $img3->setType("article");

        $img = new Image();
        $img->setNom("nj.jpg");
        $img->setSize(70996);
        $img->setPath("nj.jpg");
        $img->setExtension(".jpg");
        $img->setType("profile");

        $manager->persist($img1);
    	$manager->persist($img2);
    	$manager->persist($img3);
    	$manager->persist($img);
    	$manager->flush();

        $file1 = new File();
        $file1->setNom("fiche_otdr.pdf");
        $file1->setSize(109584);
        $file1->setPath("fiche_otdr.pdf");
        $file1->setExtension(".pdf");
        $file1->setType("article");

        $file2 = new File();
        $file2->setNom("fiche_fibre.pdf");
        $file2->setSize(767298);
        $file2->setPath("fiche_fibre.pdf");
        $file2->setExtension(".pdf");
        $file2->setType("article");

        $file3 = new File();
        $file3->setNom("fiche_power.pdf");
        $file3->setSize(1101627);
        $file3->setPath("fiche_power.pdf");
        $file3->setExtension(".pdf");
        $file3->setType("article");

        $manager->persist($file1);
        $manager->persist($file3);
        $manager->persist($file2);
        $manager->flush();


        $article1 = new Article();
        $article1->setNom("OTDR");
        $article1->setCaracteristique("see the manual");
        $article1->setUtilisation("use for measure signal test on fiber");
        $article1->setPrix("1500000");
        $article1->setQuantite(0);
        $article1->setImage($img1);
        $article1->setFile($file1);

        $article2 = new Article();
        $article2->setNom("powermeter");
        $article2->setCaracteristique("see the manual");
        $article2->setUtilisation("use for power test on fiber");
        $article2->setPrix("500000");
        $article2->setQuantite(0);
        $article2->setImage($img2);
        $article1->setFile($file3);

        $article3 = new Article();
        $article3->setNom("Fiber");
        $article3->setCaracteristique("see the manual");
        $article3->setUtilisation("use for network");
        $article3->setPrix("1000000");
        $article3->setQuantite(0);
        $article3->setImage($img3);
        $article1->setFile($file2);




        $magasin1= new Magasin();
		$magasin1->setNom("Magasin 1");
        $magasin1->setLocalisation("Hotel de ville");
        $magasin1->setAntenne($antenne1);

        $magasin2= new Magasin();
		$magasin2->setNom("Magasin 2");
        $magasin2->setLocalisation("Biyem assi");
        $magasin2->setAntenne($antenne1);

        $magasin3= new Magasin();
		$magasin3->setNom("Magasin 3");
        $magasin3->setLocalisation("Deido");
        $magasin3->setAntenne($antenne2);

        $magasin4= new Magasin();
		$magasin4->setNom("Magasin 4");
        $magasin4->setLocalisation("Village");
        $magasin4->setAntenne($antenne2);

        $manager->persist($article1);
    	$manager->persist($article2);
    	$manager->persist($article3);
    	$manager->persist($magasin1);
    	$manager->persist($magasin2);
    	$manager->persist($magasin3);
    	$manager->flush();





        $roles[]= 'ROLE_MANAGER';
        $utilisateur = new Utilisateur();
        $utilisateur->setRoles($roles);
        $utilisateur->setNom("Njomo Njampou");
        $utilisateur->setPrenom("Rostand Marlone");
        $utilisateur->setSexe("Man");
        $utilisateur->setCni("469857648915642");
        $utilisateur->setTelephone("00237694864251");
        $utilisateur->setEmail("njomorostand@gmail.com");
        $utilisateur->setUsername("njomorostand@gmail.com");
        $utilisateur->setPoste($poste1);
        $utilisateur->setAntenne($antenne1);
        $utilisateur->setPassword("123456");
        $utilisateur->setAdresse("Titi Garage");
        $utilisateur->setLogin("njomorostand@gmail.com");
        $utilisateur->setImage($img);
        $utilisateur->setIsActive(true);

        
        $password = $this->get('security.password_encoder')
                        ->encodePassword($utilisateur, $utilisateur->getPassword());
        $utilisateur->setPassword($password);

        $manager->persist($utilisateur);
    	$manager->flush();

    }
}