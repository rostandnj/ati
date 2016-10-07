<?php

namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\FOSRestController;



use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Article;
use AppBundle\Entity\Antenne;
use AppBundle\Entity\Poste;
use AppBundle\Entity\Image;
use AppBundle\Entity\StockProduit;
use AppBundle\Entity\Magasin;
use AppBundle\Entity\Entree;
use AppBundle\Entity\Sortie;
use AppBundle\Entity\StatStock;
use AppBundle\Entity\Sms;
use Symfony\Component\HttpFoundation\Response;


/**
 * Antenne controller.
 *
 */
class AntenneController extends Controller
{
    

     private function auth(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $apikey = $request->headers->get('Authorization');

        $apikey = substr($apikey,6);
        $apikey= base64_decode($apikey);
        $apikey = substr($apikey, strpos($apikey, ":") + 1); 

        $user = $em->getRepository('AppBundle:Utilisateur')->findOneByApiKey($apikey);
        return $user;
    }

    public function indexAction(Request $request)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        
        

        

        $em = $this->getDoctrine()->getManager();
        
        $antennes = $em->getRepository('AppBundle:Antenne')->findByActif(true);

        foreach ($antennes as $key => $antenne) 
        {
            $antennes[$key] =  $antenne->toArray($this->container);
            
        }

        return new JsonResponse(array('code' => 0, "message" => count($antennes)." Antenne(s) récupéré(s)", "data" => array("entities" => $antennes)));

        
    }



   
    public function newAction(Request $request)
    {
        
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        


        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        
        if(!is_null($data))
        {

            $antenne= new Antenne();

            $antenne->setLibelle($data["libelle"]);
            $antenne->setVille($data["ville"]);
            $antenne->setPays($data["pays"]);
            $antenne->setContact($data["contact"]);
            $antenne->setEmail($data["email"]);
            

            try
            {   
                    
                    $em->persist($antenne);
                    $em->flush();
            }
            catch(\Exception $e)
            {
                return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
            }

            $antennes = $em->getRepository('AppBundle:Antenne')->findAll();

            foreach ($antennes as $key => $antenne) 
            {
                $antennes[$key] =  $antenne->toArray($this->container);
                
            }

            return new JsonResponse(array('code' => 0, "message" =>" antenne enregistré ", "data" => array("entities" => $antennes)));
        }

        return new JsonResponse(array('code' => 0, "message" => " Formulaire d antenne", "data" => array("entity"=>null)));
    }


    public function stockAction(Request $request,Antenne $antenne)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        
        
        
        if(!is_null($antenne))
        {

            $em = $this->getDoctrine()->getManager();
            
            //$magasins = $em->getRepository('AppBundle:Magasin')->getActiveMagasin($antenne);
            $magasins = $em->getRepository('AppBundle:Magasin')->findBy(array('antenne'=>$antenne,'actif'=>true));


            
            foreach ($magasins as $key => $magasin) 
            {
                $magasins[$key] =  $magasin->toArray($this->container);
                
            }
            

            return new JsonResponse(array('code' => 0, "message" =>" magasins recuperes ", "data" => array("entities" => $magasins,"antenne"=>$antenne->toArray($this->container))));
        }

        return new JsonResponse(array('code' => 2, "message" => " aucune donnee recue", "data" => array("entity"=>null)));
    }

    public function shopaddAction(Request $request,Antenne $antenne)
    {
        
       $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        

       if(!is_null($antenne))
       {
            $data = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();

            
            if(!is_null($data))
            {

                $magasin= new Magasin();

                $magasin->setNom($data["nom"]);
                $magasin->setLocalisation($data["localisation"]);
                $magasin->setAntenne($antenne);

               
                try
                {   
                        
                        $em->persist($magasin);
                        $em->flush();
                }
                catch(\Exception $e)
                {
                    return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
                }

                $magasins = $em->getRepository('AppBundle:Magasin')->findAll();

                foreach ($magasins as $key => $magasin) 
                {
                    $magasins[$key] =  $magasin->toArray($this->container);
                    
                }

                return new JsonResponse(array('code' => 0, "message" =>" magasin enregistré ", "data" => array("entity"=>$antenne->toArray($this->container))));
            }
            return new JsonResponse(array('code' => 1, "message" => " Formulaire d ajout de magasin", "data" => array("entity"=>$antenne->toArray($this->container))));

       }
       return new JsonResponse(array('code' => 2, "message" => "antenne non existante", "data" => array("entity"=>null)));

        
        
    }



    public function shopAction(Request $request,Magasin $magasin)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

       
        
        if(!is_null($magasin))
        {

            
            $em = $this->getDoctrine()->getManager();
            
            
            $stocks = $em->getRepository('AppBundle:StockProduit')->findBy(array("magasin"=>$magasin,"actif"=>true));
            
            foreach ( $stocks as $key =>  $stock) 
            {
                 $stocks[$key] =   $stock->toArray($this->container);
                
            }
          
            return new JsonResponse(array('code' => 0, "message" =>" article recuperes ", "data" => array("entities" => $stocks,"magasin"=>$magasin->toArray($this->container))));
        }

        return new JsonResponse(array('code' => 2, "message" => " magasin non trouvé", "data" => array("entity"=>null)));
    }

    public function stockaddAction(Request $request,Magasin $magasin)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        

       if(!is_null($magasin))
       {
            $data = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();

            
            if(!is_null($data))
            {
                $date = new \Datetime();
                $article = $em->getRepository('AppBundle:Article')->findOneByNom($data["article"]);
                $stock = new StockProduit();

                $stock->setMagasin($magasin);
                $stock->setArticle($article);

                $old = $em->getRepository('AppBundle:StockProduit')->findOneBy(array("article"=>$article,"magasin"=>$magasin));
                if(is_object($old))
                {
                    $old->setActif(true);
                    $em->persist($old);

                    $em->flush();

                    $statold = $em->getRepository('AppBundle:StatStock')->findOneBy(array('stock'=>$old,'month'=>$date->format('m'),'year'=>$date->format('Y')));

                    if(!is_null($statold))
                    {
                        $statold->setEntree(0);
                        $statold->setSortie(0);
                        $statold->setFreqEntree(0);
                        $statold->setFreqSortie(0);
                        $em->persist($statold);

                        $em->flush();
                    }
                    else
                    {
                        $statn = new StatStock();
                        $statn->setStock($old);
                        $statn->setEntree(0);
                        $statn->setSortie(0);
                        $statn->setFreqEntree(0);
                        $statn->setFreqSortie(0);
                        $statn->setMonth($date->format('m'));
                        $statn->setYear($date->format('Y'));
                        $em->persist($statn);
                        $em->flush();
                    }


                    return new JsonResponse(array('code' => 0, "message" =>" stock enregistré ", "data" => array("entity"=>$magasin->toArray($this->container))));

                }
                $stock->setQuantite(0);

               
                try
                {   
                        
                        $em->persist($stock);
                        $em->flush();
                        
                        $stat = new StatStock();
                        $stat->setStock($stock);
                        $stat->setEntree(0);
                        $stat->setSortie(0);
                        $stat->setFreqEntree(0);
                        $stat->setFreqSortie(0);
                        $stat->setMonth($date->format('m'));
                        $stat->setYear($date->format('Y'));
                        $em->persist($stat);
                        $em->flush();


                }
                catch(\Exception $e)
                {
                    return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
                }

                return new JsonResponse(array('code' => 0, "message" =>" stock enregistré ", "data" => array("entity"=>$magasin->toArray($this->container))));
            }

            $produits = $em->getRepository('AppBundle:Article')->findAll();
            $stockmagasin = $em->getRepository('AppBundle:StockProduit')->findBy(array("magasin"=>$magasin,"actif"=>true));
            $produitok =[];

            foreach ($stockmagasin as $stock) 
            {
               $produitok[] = $stock->getArticle()->getNom();
            }

            foreach ($produits as $produit)
            {
                if(!in_array($produit->getNom(), $produitok))
                {
                    $finals[] = $produit->getNom();
                }
            }

            

            return new JsonResponse(array('code' => 0, "message" => " Formulaire d ajout d un stock", "data" => array("entity"=>$magasin->toArray($this->container),"produits"=>$finals)));

       }
       return new JsonResponse(array('code' => 2, "message" => "magasin non existant", "data" => array("entity"=>null)));
    }

    public function stockremoveAction(Request $request,StockProduit $stock)
    {
        
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        if($data["actif"])
        {
            $stock->setActif(false);
            try
            {   
                    
                    $stats = $em->getRepository('AppBundle:StatStock')->findByStock($stock);
                    foreach ($stats as $key => $value) 
                    {
                        $value->setActif(false);
                        $em->persist($value);
                    }
                    $em->persist($stock);
                    $em->flush();
            }
            catch(\Exception $e)
            {
                return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
            }
            return new JsonResponse(array('code' => 0, "message" =>" stock supprime ", "data" => array("entity"=>$stock->toArray($this->container))));
        }

        return new JsonResponse(array('code' => 0, "message" =>" formulaire ", "data" => array("entity"=>$stock->toArray($this->container))));
        
    }
    
    

       
   



    public function entreeAction(Request $request,StockProduit $stock)
    {
        
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        
       if(!is_null($stock))
       {
            $data = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();

            
            if(!is_null($data))
            {

                
                

                $user = $this->auth($request);
            
                $entree = new Entree();
                $entree->setStock($stock);
                $entree->setLibelle($data["libelle"]);
                $entree->setQuantite($data["quantite"]);
                $entree->setUtilisateur($user);
                $entree->setMagasin($stock->getMagasin());

                if(array_key_exists("image", $data))
                {

                    $image = substr($data["image"], strpos( $data["image"],';')+1);
                    list($type, $image) = explode(';', $image);
                    list(, $image)      = explode(',', $image);
                    list(, $type)      = explode(':', $type);
                    $image = base64_decode($image);
                    $types = array('image/jpg','image/jpeg','image/png','image/gif');
                    $filepath = __DIR__.'/../../../web/uploads/';
                    $base = $filepath;
                    $baseok = " C:\\xampp\htdocs\apprest\\web\\uploads\\";
                    $filename = uniqid();
                    
                    $r = false;
                    if($key = array_search($type, $types))
                    {
                        switch ($key) 
                        {
                            case 0:
                                $filename .= '.jpg';
                                $ext='.jpg';
                                $filepath = $base.$filename;
                                $r = file_put_contents($filepath, $image);
                                break;
                            case 1:
                                $filename .= '.jpeg';
                                $ext='.jpeg';
                                $filepath = $base.$filename;
                                $r = file_put_contents($filepath, $image);
                               
                                break;
                            case 2:
                                $filename .= '.png';
                                $ext='.png';
                                $filepath = $base.$filename;
                                $r = file_put_contents($filepath, $image);
                                break;
                            case 3:
                                $filename .= '.gif';
                                $ext='.gif';
                                $filepath = $base.$filename;
                                $r = file_put_contents($filepath, $image);
                                break;
                            
                            default:
                                # code...
                                break;
                        }
                    }
                    if($r)
                    {
                        $img = new Image();
                        $img->setNom($filename);
                        $img->setSize($r);
                        $img->setPath($filename);
                        $img->setExtension($ext);
                        $img->setType("entree");

                        $entree->setImage($img);

                    }
                }
                $stock->setQuantite($stock->getQuantite() + $entree->getQuantite());

               
                try
                {       
                        $date = new \Datetime();
                        $date2 = new \Datetime();
                        $firstday = $date2->modify('first day of');
                        $nb = $firstday->diff($date);
                        $nb = $nb->format('%d');


                        $em->persist($entree);
                        $em->persist($stock);
                        

                       $stat = $em->getRepository('AppBundle:StatStock')
                       ->findOneBy(array('stock'=>$stock,'month'=>$date->format('m'),'year'=>$date->format('Y')));

                       if(!is_null($stat))
                       {
                            $stat->setEntree($stat->getEntree()+$entree->getQuantite());
                            if($nb != 0)
                            {
                                $stat->setFreqEntree($stat->getEntree() / $nb);
                            }
                            else
                            {
                                $stat->setFreqEntree($stat->getEntree());
                            }
                            
                            $em->persist($stat);
                       }
                       else
                       {
                            $statn = new StatStock();
                            $statn->setStock($stock);
                            $statn->setEntree($entree->getQuantite());
                            $statn->setSortie(0);
                            if($nb !=0)
                            {
                               $statn->setFreqEntree($entree->getQuantite() / $nb); 
                            }
                            else
                            {
                                $statn->setFreqEntree($entree->getQuantite());
                            }
                            
                            $statn->setFreqSortie(0);
                            $statn->setMonth($date->format('m'));
                            $statn->setYear($date->format('Y'));
                            $em->persist($statn);
                       }


                        $em->flush();
                }
                catch(\Exception $e)
                {
                    return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
                }

                return new JsonResponse(array('code' => 0, "message" =>" stock approvisionne ", "data" => array("entity"=>$stock->toArray($this->container))));
            }
            

            return new JsonResponse(array('code' => 0, "message" => " Formulaire d entree d un stock", "data" => array("entity"=>$stock->toArray($this->container))));

       }
       return new JsonResponse(array('code' => 2, "message" => "stock non existant", "data" => array("entity"=>null)));

        
        
    }


    public function sortieAction(Request $request,StockProduit $stock)
    {
        
       $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        
       if(!is_null($stock))
       {
            $data = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();

            
            if(!is_null($data))
            {

                
                $user = $this->auth($request);
                $sortie = new Sortie();
                $sortie->setStock($stock);
                $sortie->setLibelle($data["libelle"]);
                $sortie->setQuantite($data["quantite"]);
                $sortie->setUtilisateur($user);
                $sortie->setMagasin($stock->getMagasin());

                if(array_key_exists("image", $data))
                {

                    $image = substr($data["image"], strpos( $data["image"],';')+1);
                    list($type, $image) = explode(';', $image);
                    list(, $image)      = explode(',', $image);
                    list(, $type)      = explode(':', $type);
                    $image = base64_decode($image);
                    $types = array('image/jpg','image/jpeg','image/png','image/gif');
                    $filepath = __DIR__.'/../../../web/uploads/';
                    $base = $filepath;
                    $baseok = " C:\\xampp\htdocs\apprest\\web\\uploads\\";
                    $filename = uniqid();
                    
                    $r = false;
                    if($key = array_search($type, $types))
                    {
                        switch ($key) 
                        {
                            case 0:
                                $filename .= '.jpg';
                                $ext='.jpg';
                                $filepath = $base.$filename;
                                $r = file_put_contents($filepath, $image);
                                break;
                            case 1:
                                $filename .= '.jpeg';
                                $ext='.jpeg';
                                $filepath = $base.$filename;
                                $r = file_put_contents($filepath, $image);
                               
                                break;
                            case 2:
                                $filename .= '.png';
                                $ext='.png';
                                $filepath = $base.$filename;
                                $r = file_put_contents($filepath, $image);
                                break;
                            case 3:
                                $filename .= '.gif';
                                $ext='.gif';
                                $filepath = $base.$filename;
                                $r = file_put_contents($filepath, $image);
                                break;
                            
                            default:
                                # code...
                                break;
                        }
                    }
                    if($r)
                    {
                        $img = new Image();
                        $img->setNom($filename);
                        $img->setSize($r);
                        $img->setPath($baseok.$filename);
                        $img->setExtension($ext);
                        $img->setType("entree");

                        $sortie->setImage($img);

                    }
                }
                $stock->setQuantite($stock->getQuantite() - $sortie->getQuantite());

                if($stock->getQuantite() < 0)
                {
                    return new JsonResponse(array('code' => 1, "message" => " stock insuffisant", "data" => array("entity"=>$stock->toArray($this->container))));
                }

               
                try
                {   
                        
                        $em->persist($sortie);
                        $em->persist($stock);

                        $date = new \Datetime();
                        $date2 = new \Datetime();
                        $firstday = $date2->modify('first day of');
                        $nb = $firstday->diff($date);
                        $nb = $nb->format('%d');

                        $statn = $em->getRepository('AppBundle:StatStock')->findOneBy(array('stock'=>$stock,'month'=>$date->format('m'),'year'=>$date->format('Y')));
                       if(!is_null($statn))
                       {
                            $statn->setSortie($statn->getSortie() + $sortie->getQuantite());
                            if($nb != 0)
                            {
                                $statn->setFreqSortie($statn->getSortie() / $nb);
                            }
                            else
                            {
                                $statn->setFreqSortie($statn->getSortie());
                            }
                            
                            $em->persist($statn);
                       }
                       else
                       {
                            $statn = new StatStock();
                            $statn->setStock($stock);
                            $statn->setSortie($sortie->getQuantite());
                            $statn->setEntree(0);
                            if($nb != 0)
                            {
                                $statn->setFreqSortie($sortie->getQuantite() / $nb);
                            }
                            else
                            {
                                $statn->setFreqSortie($sortie->getQuantite());
                            }
                            
                            $statn->setFreqEntree(0);
                            $statn->setMonth($date->format('m'));
                            $statn->setYear($date->format('Y'));
                            $em->persist($statn);
                       }


                        $em->flush();
                }
                catch(\Exception $e)
                {
                    return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
                }

                if($stock->getQuantite() <= $stock->getArticle()->getStocka())
                {
                    $Username = "njomorostand@gmail.com";
                    $Password = "2qp60";
                    $MsgSender = "+237679487888";
                    $DestinationAddress = "+237694864251";
                    $Message = "Hello World!";

                    // Create ViaNettSMS object with params $Username and $Password
                    $ViaNettSMS = new Sms($Username, $Password);
                    try
                    {
                        // Send SMS through the HTTP API
                        $Result = $ViaNettSMS->SendSMS($MsgSender, $DestinationAddress, $Message);
                        // Check result object returned and give response to end user according to success or not.
                        if ($Result->Success == true)
                            $Message = "Message successfully sent!";
                        else
                            $Message = "Error occured while sending SMS<br />Errorcode: " . $Result->ErrorCode . "<br />Errormessage: " . $Result->ErrorMessage;
                    }
                    catch (Exception $e)
                    {
                        //Error occured while connecting to server.
                        $Message = $e->getMessage();
                    }


                    try
                    {
                        $users = $em->getRepository('AppBundle:Utilisateur')->findByAntenne($stock->getMagasin()->getAntenne());

                        foreach ($users as $key => $value) 
                        {
                            $message = \Swift_Message::newInstance()
                            ->setSubject('Alerte Stock')
                            ->setFrom('njomorostand@gmail.com')
                            ->setTo($value->getEmail())
                            ->setBody(
                               $this->renderView('alerte.html.twig',array('stock' => $stock) ),'text/html')
                            /*
                             * If you also want to include a plaintext version of the message
                            ->addPart(
                                $this->renderView(
                                    'Emails/registration.txt.twig',
                                    array('name' => $name)
                                ),
                                'text/plain'
                            )
                            */
                        ;
                        $this->get('mailer')->send($message);
                        }

                        

                    }
                    catch(\Exception $e)
                    {
                        return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
                    }
                }

                return new JsonResponse(array('code' => 0, "message" =>" stock approvisionne ", "data" => array("entity"=>$stock->toArray($this->container))));
            }
            

            return new JsonResponse(array('code' => 0, "message" => " Formulaire d entree d un stock", "data" => array("entity"=>$stock->toArray($this->container))));

       }
       return new JsonResponse(array('code' => 2, "message" => "stock non existant", "data" => array("entity"=>null)));

        
        
    }

    public function delAction(Request $request, Antenne $antenne)
    {
        
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        if(!is_null($antenne))
        {
            if(!is_null($data))
            {
                
                    $antenne->setActif(false);
                    $em->persist($antenne);
                    $em->flush();
                
                
                

                return new JsonResponse(array('code' => 0, "message" =>"antenne suprime", "data" => array("entity"=>$antenne->toArray($this->container))));

            }
            return new JsonResponse(array('code' => 0, "message" =>"form ", "data" => array("entity"=>$antenne->toArray($this->container))));

        }
        return new JsonResponse(array('code' => 2, "message" =>"antenne inexistant ", "data" => array("entity"=>null)));

    }

    public function editAction(Request $request, Antenne $antenne)
    {
        
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        if(!is_null($antenne))
        {
        
        if(!is_null($data))
        {


            $antenne->setLibelle($data["libelle"]);
            $antenne->setVille($data["ville"]);
            $antenne->setPays($data["pays"]);
            $antenne->setContact($data["contact"]);
            $antenne->setEmail($data["email"]);
            

            try
            {   
                    
                    $em->persist($antenne);
                    $em->flush();
            }
            catch(\Exception $e)
            {
                return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
            }


            return new JsonResponse(array('code' => 0, "message" =>" antenne modifie ", "data" => array("entity" => $antenne->toArray($this->container))));
        }

        return new JsonResponse(array('code' => 0, "message" => " Formulaire d antenne", "data" => array("entity"=>$antenne->toArray($this->container))));
    }

        return new JsonResponse(array('code' => 2, "message" => " antenne inexistant", "data" => array("entity"=>null)));
    }

    public function shopeditAction(Request $request,Magasin $magasin)
    {
        
       $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        
       if(!is_null($magasin))
       {
            $data = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();

            
            if(!is_null($data))
            {

                $magasin->setNom($data["nom"]);
                $magasin->setLocalisation($data["localisation"]);
                

               
                try
                {   
                        
                        $em->persist($magasin);
                        $em->flush();
                }
                catch(\Exception $e)
                {
                    return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
                }


                return new JsonResponse(array('code' => 0, "message" =>" magasin modifie ", "data" => array("entity"=>$magasin->toArray($this->container))));
            }
            return new JsonResponse(array('code' => 1, "message" => " Formulaire de modif de magasin", "data" => array("entity"=>$magasin->toArray($this->container))));

       }
       return new JsonResponse(array('code' => 2, "message" => "antenne non existante", "data" => array("entity"=>null)));

        
        
    }

    public function shopdelAction(Request $request, Magasin $magasin)
    {
        
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        if(!is_null($magasin))
        {
            if(!is_null($data))
            {
                
                    $magasin->setActif(false);
                    $em->persist($magasin);
                    $em->flush();
                
                
                

                return new JsonResponse(array('code' => 0, "message" =>"magasin suprime", "data" => array("entity"=>$magasin->toArray($this->container))));

            }
            return new JsonResponse(array('code' => 0, "message" =>"form ", "data" => array("entity"=>$magasin->toArray($this->container))));

        }
        return new JsonResponse(array('code' => 2, "message" =>"antenne inexistant ", "data" => array("entity"=>null)));

    }

    public function statmAction(Request $request, Magasin $magasin)
    {   
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        if(!is_null($magasin))
        {   

            
            $date = new \Datetime();

            $entreesm=[];
            $sortiesm=[];
            $all=[];
            $allstat=[];

            foreach ($magasin->getStocks() as $key => $stock) 
            {
                $nom = $stock->getArticle()->getNom();
                $stat = $em->getRepository('AppBundle:StatStock')->findOneBy(array('stock'=>$stock,'month'=>$date->format('m'),'year'=>$date->format('Y')));

                if(is_object($stat))
                {
                    $all[$nom] = $stat->toArray($this->container);
                }
            }

            foreach ($magasin->getStocks() as $key => $stock) 
            {
                $stats = $em->getRepository('AppBundle:StatStock')->findByStock($stock);

                foreach ($stats as $key => $value) 
                {
                     $allstat[$value->getMonth()][] = $value->toArray($this->container);
                    
                }

                
            }

            
            
            
            
            foreach ($magasin->getEntrees() as $entree) 
            {
                $entreesm[] = $entree->toArray($this->container);
                    
            }

            foreach ($magasin->getSorties() as $sortie) 
            {
                $sortiesm[] = $sortie->toArray($this->container);
                    
            }




            return new JsonResponse(array('code' => 0, "message" =>" stat recuperes ", "data" => array("magasin"=>$magasin->toArray($this->container),'entreesm'=>$entreesm,'sortiesm'=>$sortiesm,"all"=>$all,"archive"=>$allstat)));
            
        }
        return new JsonResponse(array('code' => 2, "message" =>"antenne inexistante ", "data" => array("entity"=>null)));
    }

    public function apilistAction(Request $request)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $antennes = $em->getRepository('AppBundle:Antenne')->findAll();

        foreach ($antennes as $key => $antenne) 
        {
            $antennes[$key] =  $antenne->toArray($this->container);
            
        }

        return new JsonResponse($antennes);

        
    }

    public function apimagasinlistAction(Request $request)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $magasins = $em->getRepository('AppBundle:Magasin')->findAll();

        foreach ($magasins as $key => $magasin) 
        {
            $magasins[$key] =  $magasin->toArray($this->container);
            
        }

        return new JsonResponse($magasins);

        
    }

    public function alerteAction(Request $request)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $em = $this->getDoctrine()->getManager();

        $stocks=[];

        foreach ($u->getAntenne()->getMagasins() as $key => $value) 
        {
            $all = $em->getRepository('AppBundle:StockProduit')->findByMagasin($value);

            foreach ($all as $key => $s) 
            {
                if($s->getQuantite() <= $s->getArticle()->getStocka())
                {
                    $stocks[]=$s->toArray($this->container);
                }
            }
            
        }

        return new JsonResponse(array('code'=>0,"message"=>"stock alert","entities"=>$stocks,"user"=>$u->toArray($this->container)));

        
    }

    public function statgeneraleAction(Request $request)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $em = $this->getDoctrine()->getManager();

        $antennes = $em->getRepository('AppBundle:Antenne')->findByActif(true);
        $ant=[];

        foreach ($antennes as $key => $value) 
        {
            $ant[]=$value->toArray($this->container);
        }

        return new JsonResponse(array('code'=>0,"message"=>"general stat","data"=>array("entities"=>$ant)));
    }

    public function statantAction(Request $request,Antenne $antenne)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $em = $this->getDoctrine()->getManager();

        if(!is_null($antenne))
        {
            $presences = [];

            $date = new \Datetime();
            $date2 = new \Datetime();
            $firstday = $date2->modify('first day of');

            foreach ($antenne->getUtilisateurs() as $key => $value) 
            {
                $query = $em->getRepository('AppBundle:Presence')->createQueryBuilder('p')
                    ->select('p')
                    ->leftjoin('p.utilisateur','u')
                    ->addSelect('u')
                    ->where('p.date > :now')
                    ->andWhere('u = :user')
                    ->setParameter('now', $firstday)
                    ->setParameter('user',$value)
                    
                    ->getQuery();

                $r = $query->getResult();
                if(!is_null($r))
                {
                    foreach ($r as $key => $va) 
                    {
                        $nom =str_replace(' ', '_', $value->getNom());
                        $presences[$nom][]=$va->toArray($this->container);
                    }
                }

                $date = new \Datetime();

            
            $all=[];

            $id=[];

            foreach ($antenne->getMagasins() as $key => $magasin) 
            {
                foreach ($magasin->getStocks() as $key => $stock) 
                {
                    $nom = $stock->getArticle()->getNom();
                    $id[$nom]=$stock->getId();

                    $query = $em->getRepository('AppBundle:Entree')->createQueryBuilder('e')
                    ->select('e')
                    ->leftjoin('e.stock','s')
                    ->addSelect('s')
                    ->where('e.date > :now')
                    ->andWhere('s = :st')
                    ->setParameter('now', $firstday)
                    ->setParameter('st',$stock)
                    
                    ->getQuery();

                    $statin = $query->getResult();

                    $query2 = $em->getRepository('AppBundle:Sortie')->createQueryBuilder('s')
                        ->select('s')
                        ->leftjoin('s.stock','k')
                        ->addSelect('k')
                        ->where('s.date > :now')
                        ->andWhere('k = :sto')
                        ->setParameter('now', $firstday)
                        ->setParameter('sto',$stock)
                        
                        ->getQuery();

                    $statout = $query2->getResult();

                        

                        if(!is_null($statin))
                        {
                            $nom = $stock->getArticle()->getNom();
                            foreach ($statin as $key => $stat) 
                            {
                                $all[$nom]["entree"][] = $stat->toArray($this->container);
                            }

                            
                        }

                        if(!is_null($statout))
                        {
                            $nom = $stock->getArticle()->getNom();
                            foreach ($statout as $key => $sta) 
                            {
                                $all[$nom]["sortie"][] = $sta->toArray($this->container);
                            }

                            
                        }
                }

                
            }

            
   
                            
            }
            return new JsonResponse(array('code'=>0,"message"=>"stat","data"=>array("ids"=>$id,"entities"=>$presences,"antenne"=>$antenne->toArray($this->container),"stocks"=>$all)));

        }

        

    }

    function printAction(Request $request)
    {


        
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $em = $this->getDoctrine()->getManager();

        $date = new \Datetime();

        $html = $this->renderView('AppBundle:ati:doc.html.twig', array('date'=>$date));

        $html2pdf = $this->get('html2pdf_factory')->create('P','A4','fr', false, 'ISO-8859-15', array(10, 10, 10, 5));

        $html2pdf->pdf->SetDisplayMode('fullpage');

        $html2pdf->writeHTML($html,isset($_GET['vuehtml']));



        $nom = 'file_'.uniqid().'.pdf';

        //$file = base64_encode($html2pdf->Output($nom));

        //$filepath = __DIR__.'/../../../web/uploads/'.$nom;

        $html2pdf->Output('../../user/'.$nom, 'F');

       

       
        //$re = file_put_contents($filepath, $html2pdf);

        return new JsonResponse(array("code"=>0,"data"=>$nom));

    }


    function printstatAction(Request $request,Magasin $magasin)
    {


        
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $em = $this->getDoctrine()->getManager();

        $all=[];
        $date = new \Datetime();

        foreach ($magasin->getStocks() as $key => $stock) 
        {
            $nom = $stock->getArticle()->getNom();
            $stat = $em->getRepository('AppBundle:StatStock')->findOneBy(array('stock'=>$stock,'month'=>$date->format('m'),'year'=>$date->format('Y')));

            if(is_object($stat))
            {
                $all[$nom] = $stat;
            }
        }


        

        $html = $this->renderView('AppBundle:ati:doc_mag.html.twig', array('date'=>$date,"stat"=>$all,"magasin"=>$magasin));

        $html2pdf = $this->get('html2pdf_factory')->create('P','A4','fr', false, 'ISO-8859-15', array(10, 10, 10, 5));

        $html2pdf->pdf->SetDisplayMode('fullpage');

        $html2pdf->writeHTML($html,isset($_GET['vuehtml']));



        $nom = 'shop_'.uniqid().'.pdf';

        //$file = base64_encode($html2pdf->Output($nom));

        //$filepath = __DIR__.'/../../../web/uploads/'.$nom;

        $html2pdf->Output('../../user/'.$nom, 'F');

       

       
        //$re = file_put_contents($filepath, $html2pdf);

        return new JsonResponse(array("code"=>0,"data"=>$nom));

    }

    function printpreAction(Request $request,Utilisateur $utilisateur)
    {


        
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $em = $this->getDoctrine()->getManager();



        $all=[];
        $date = new \Datetime();
        $date2 = new \Datetime();
        $firstday = $date2->modify('first day of');



        $query = $em->getRepository('AppBundle:Presence')->createQueryBuilder('p')
                    ->select('p')
                    ->leftjoin('p.utilisateur','u')
                    ->addSelect('u')
                    ->where('p.date > :now')
                    ->andWhere('u = :user')
                    ->setParameter('now', $firstday)
                    ->setParameter('user',$utilisateur)
                    
                    ->getQuery();

                $r = $query->getResult();


        

        $html = $this->renderView('AppBundle:ati:doc_pre.html.twig', array('date'=>$date,"stat"=>$r,"user"=>$utilisateur));

        $html2pdf = $this->get('html2pdf_factory')->create('P','A4','fr', false, 'ISO-8859-15', array(10, 10, 10, 5));

        $html2pdf->pdf->SetDisplayMode('fullpage');

        $html2pdf->writeHTML($html,isset($_GET['vuehtml']));



        $nom = 'pre_'.uniqid().'.pdf';

        //$file = base64_encode($html2pdf->Output($nom));

        //$filepath = __DIR__.'/../../../web/uploads/'.$nom;

        $html2pdf->Output('../../user/'.$nom, 'F');

       

       
        //$re = file_put_contents($filepath, $html2pdf);

        return new JsonResponse(array("code"=>0,"data"=>$nom));

    }


    function printstockAction(Request $request,StockProduit $stock)
    {


        
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $em = $this->getDoctrine()->getManager();



        $all=[];
        //$all["entree"]="";
        //$all["sortie"]="";
        $date = new \Datetime();
        $date2 = new \Datetime();
        $firstday = $date2->modify('first day of');


            $nom = $stock->getArticle()->getNom();

            $query = $em->getRepository('AppBundle:Entree')->createQueryBuilder('e')
            ->select('e')
            ->leftjoin('e.stock','s')
            ->addSelect('s')
            ->where('e.date > :now')
            ->andWhere('s = :st')
            ->setParameter('now', $firstday)
            ->setParameter('st',$stock)
            
            ->getQuery();

            $statin = $query->getResult();

            $query2 = $em->getRepository('AppBundle:Sortie')->createQueryBuilder('s')
                ->select('s')
                ->leftjoin('s.stock','k')
                ->addSelect('k')
                ->where('s.date > :now')
                ->andWhere('k = :sto')
                ->setParameter('now', $firstday)
                ->setParameter('sto',$stock)
                
                ->getQuery();

            $statout = $query2->getResult();

                

                if(!is_null($statin))
                {
                    $nom = $stock->getArticle()->getNom();
                    foreach ($statin as $key => $stat) 
                    {
                        $all["entree"][] = $stat->toArray($this->container);
                    }

                    
                }

                if(!is_null($statout))
                {
                    $nom = $stock->getArticle()->getNom();
                    foreach ($statout as $key => $sta) 
                    {
                        $all["sortie"][] = $sta->toArray($this->container);
                    }

                    
                }
               


        

        $html = $this->renderView('AppBundle:ati:doc_stock.html.twig', array('date'=>$date,"stat"=>$all,"stock"=>$stock));

        $html2pdf = $this->get('html2pdf_factory')->create('P','A4','fr', false, 'ISO-8859-15', array(10, 10, 10, 5));

        $html2pdf->pdf->SetDisplayMode('fullpage');

        $html2pdf->writeHTML($html,isset($_GET['vuehtml']));



        $nom = 'stock_'.uniqid().'.pdf';

        //$file = base64_encode($html2pdf->Output($nom));

        //$filepath = __DIR__.'/../../../web/uploads/'.$nom;

        $html2pdf->Output('../../user/'.$nom, 'F');

       

       
        //$re = file_put_contents($filepath, $html2pdf);

        return new JsonResponse(array("code"=>0,"data"=>$nom));

    }

    function printarticleAction(Request $request)
    {


        
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $em = $this->getDoctrine()->getManager();

        $all=[];
        $date = new \Datetime();

        $articles = $em->getRepository('AppBundle:Article')->findByActif(true);
        foreach ($articles as $key => $value) 
        {
            $art[] = $value->toArray($this->container);
        }

        foreach ($articles as $key => $article) 
        {
            $stocks = $em->getRepository('AppBundle:StockProduit')->findByArticle($article);

            

            foreach ($stocks as $key => $stock) 
            {
               // $all[$article->getNom()] = $all[$article->getNom()] + $stock->getQuantite();

                 $all[$article->getNom()][$stock->getMagasin()->getAntenne()->getLibelle()][$stock->getMagasin()->getNom()][0]
                 = $stock->getQuantite();
            }
        }

       


        

        $html = $this->renderView('AppBundle:ati:doc_article.html.twig', array('date'=>$date,"stat"=>$all));

        $html2pdf = $this->get('html2pdf_factory')->create('P','A4','fr', false, 'ISO-8859-15', array(10, 10, 10, 5));

        $html2pdf->pdf->SetDisplayMode('fullpage');

        $html2pdf->writeHTML($html,isset($_GET['vuehtml']));



        $nom = 'article_'.uniqid().'.pdf';

        //$file = base64_encode($html2pdf->Output($nom));

        //$filepath = __DIR__.'/../../../web/uploads/'.$nom;

        $html2pdf->Output('../../user/'.$nom, 'F');

       

       
        //$re = file_put_contents($filepath, $html2pdf);

        return new JsonResponse(array("code"=>0,"data"=>$nom,"tab"=>$all,"art"=>$art));

    }



   
}
