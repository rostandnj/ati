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
use AppBundle\Entity\File;
use AppBundle\Form\UtilisateurType;


/**
 * Article controller.
 *
 */
class ArticleController extends Controller
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

        if(is_null($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        $em = $this->getDoctrine()->getManager();
        
        
        $articles = $em->getRepository('AppBundle:Article')->findByActif(true);

        foreach ($articles as $key => $article) 
        {
            $articles[$key] =  $article->toArray($this->container);
            
        }

        return new JsonResponse(array('code' => 0, "message" => count($articles)." Article(s) récupéré(s)", "data" => array("entities" => $articles)));

        
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
        
        $articles = $em->getRepository('AppBundle:Article')->findAll();

        foreach ($articles as $key => $article) 
        {
            $articles[$key] =  $article->toArray($this->container);
            
        }

        
        if(!is_null($data))
        {

            $article = new Article();

            $article->setNom($data["nom"]);
            $article->setCaracteristique($data["caracteristique"]);
            $article->setUtilisation($data["utilisation"]);
            $article->setPrix($data["prix"]);
            $article->setStocka($data["stocka"]);
            $article->setQuantite(0);
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
                    $img->setType("profil");
                    $article->setImage($img);


                }
            }

            if(array_key_exists("file", $data))
            {

                $file= substr($data["file"], strpos( $data["file"],';')+1);
                list($type, $file) = explode(';', $file);
                list(, $file)      = explode(',', $file);
                list(, $type)      = explode(':', $type);
                $file = base64_decode($file);
                $filepath = __DIR__.'/../../../web/uploads/';
                $base = $filepath;
                $baseok = " C:\\xampp\htdocs\apprest\\web\\uploads\\";
                $filename = uniqid();
                
                
                $filename .= '.pdf';
                $ext='.pdf';
                $filepath = $base.$filename;
                $re = file_put_contents($filepath, $file);

                $f = new File();
                $f->setNom($filename);
                $f->setSize($re);
                $f->setPath($filename);
                $f->setExtension($ext);
                $f->setType("article");
                $article->setFile($f);
                            
            }
                
                    
            

            try
            {   
                    
                    $em->persist($article);
                    $em->flush();
            }
            catch(\Exception $e)
            {
                return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
            }

            return new JsonResponse(array('code' => 0, "message" =>" article enregistré ", "data" => array("entities" => $articles)));
        }

        return new JsonResponse(array('code' => 0, "message" => " Formulaire d article", "data" => array("entity"=>null)));
    }

    public function editAction(Request $request, Article $article)
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

        if(!is_null($article))
        {
        
        if(!is_null($data))
        {

            $article->setNom($data["nom"]);
            $article->setCaracteristique($data["caracteristique"]);
            $article->setUtilisation($data["utilisation"]);
            $article->setPrix($data["prix"]);
            $article->setStocka($data["stocka"]);
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
                    $img->setType("article");
                    $article->setImage($img);


                }
            }

            try
            {   
                    
                    $em->persist($article);
                    $em->flush();
            }
            catch(\Exception $e)
            {
                return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
            }
            $articles = $em->getRepository('AppBundle:Article')->findAll();

            foreach ($articles as $key => $article) 
            {
                $articles[$key] =  $article->toArray($this->container);
                
            }

            return new JsonResponse(array('code' => 0, "message" =>" article enregistré ", "data" => array("entities" => $articles)));
        }

        return new JsonResponse(array('code' => 0, "message" => " Formulaire de modif d'un article", "data" => array("entity"=>$article->toArray($this->container))));
    }

        return new JsonResponse(array('code' => 2, "message" => " article inexistant", "data" => array("entity"=>null)));
    }


    public function delAction(Request $request, Article $article)
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

        if(!is_null($article))
        {
            if(!is_null($data))
            {
                
                    $article->setActif(false);
                    $em->persist($article);
                    $em->flush();
                
                
                

                return new JsonResponse(array('code' => 0, "message" =>"article suprime", "data" => array("entity"=>$article->toArray($this->container))));

            }
            return new JsonResponse(array('code' => 0, "message" =>"form ", "data" => array("entity"=>$article->toArray($this->container))));

        }
        return new JsonResponse(array('code' => 2, "message" =>"article inexistant ", "data" => array("entity"=>null)));

    }

    public function apilistAction(Request $request)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAll();

        foreach ($articles as $key => $article) 
        {
            $articles[$key] =  $article->toArray($this->container);
            
        }

        return new JsonResponse($articles);

        
    }



   
}
