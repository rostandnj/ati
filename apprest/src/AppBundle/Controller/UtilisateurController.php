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
use AppBundle\Entity\Paye;
use AppBundle\Entity\File;
use AppBundle\Entity\Presence;
use AppBundle\Entity\Convert;

/**
 * Utilisateur controller.
 *
 */
class UtilisateurController extends Controller
{
    
    /**
     * Cette fonction retourne tous les utilisateurs
     * @ApiDoc(
     *  resource=true,
     *  description="Retourne les utilisateurs"
     * )
     *
     * @return array
     */

    public function testAction()
    {
        return $this->render('AppBundle::index2.html.twig');
    }

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
        return $this->render('AppBundle::index.html.twig');
    }

    public function homeAction(Request $request)
    {
        $user = $this->getUser();
        $user = $user->toArray($this->container);

        if(is_object($user))
        {
            return $this->redirect('http://localhost/a/mindex.html');
        }

        //return $this->render('AppBundle:ati:index.html.twig',array("user" => $user)); 
        
        return new JsonResponse(array('code' => 0, "message" =>" ok", "data" => array("entity" => $user)));
        
    }

    public function loaginAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        //if(!is_object($user))
        //{
          // return $this->render('AppBundle::index.html.twig',array('error'=>'null')); 
        //}
        return $this->render('AppBundle::home.html.twig'); 
        return new JsonResponse(array('code' => 0, "message" => " ok", "data" => array("entities" => null)));
        
    }

    

    public function allAction(Request $request)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $em = $this->getDoctrine()->getManager();
        
        $users = $em->getRepository('AppBundle:Utilisateur')->findByIsActive(true);

        foreach ($users as $key => $user) 
        {
            $users[$key] =  $user->toArray($this->container);
            
        }

        return new JsonResponse(array('code' => 0, "message" => count($users)." Article(s) récupéré(s)", "data" => array("entities" => $users)));

        
    }


    
    /**
     * Cette fonction permet de creer un utilisateur
     * @ApiDoc(
     *  resource=true,
     *  description="Retourne un nouvel utilisateur"
     * )
     *
     * @return array
     */
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
        
        $utilisateurs = $em->getRepository('AppBundle:Utilisateur')->findAll();
        $postes = $em->getRepository('AppBundle:Poste')->findAll();
        $antennes = $em->getRepository('AppBundle:Antenne')->findAll();

        foreach ($antennes as $key => $antenne) 
        {
            $antennes[$key] =  $antenne->getLibelle();
            
        }

        foreach ($postes as $key => $poste) 
        {
            $postes[$key] =  $poste->getLibelle();
            
        }
        
        foreach ($utilisateurs as $key => $user) 
        {
            $utilisateurs[$key] =  $user->toArray($this->container);
            
        }
        

        if(!is_null($data))
        {

            $utilisateur = new Utilisateur();
            
        
            $post = $em->getRepository("AppBundle:Poste")->findOneByLibelle($data["poste"]);
            $ant = $em->getRepository("AppBundle:Antenne")->findOneByLibelle($data["antenne"]);

            $utilisateur->setNom($data["nom"]);
            $utilisateur->setPrenom($data["prenom"]);
            $utilisateur->setSexe($data["sexe"]);
            $utilisateur->setCni($data["cni"]);
            $utilisateur->setTelephone($data["telephone"]);
            $utilisateur->setEmail($data["email"]);
            $utilisateur->setPoste($post);
            $utilisateur->setAntenne($ant);
            $pass = uniqid();
            $utilisateur->setPassword($pass);
            $utilisateur->setAdresse($data["adresse"]);
            $utilisateur->setLogin($data["email"]);
            $utilisateur->setUsername($data["email"]);
            $utilisateur->setIsActive(true);

            if($data["role"] =="ROLE_USER")
            {
                $roles[]= 'ROLE_USER';
            }
            else
            {
                $roles[]= 'ROLE_MANAGER';
            }
            
            $utilisateur->setRoles($roles);
            
            $password = $this->get('security.password_encoder')
                            ->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($password);

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
                    $img->setType("profil");

                    $utilisateur->setImage($img);

                }
            }

            try
            {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Welcome on ATI')
                    ->setFrom('njomorostand@gmail.com')
                    ->setTo($utilisateur->getEmail())
                    ->setBody(
                       $this->renderView('test.html.twig',array('password' => $pass),'text/html'))
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
            catch(\Exception $e)
            {
                return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
            }


            try
            {   
                    
                    $em->persist($utilisateur);
                    $em->flush();
            }
            catch(\Exception $e)
            {
                return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
            }

            return new JsonResponse(array('code' => 0, "message" =>" utilisateur enregistré ", "data" => array("entity" => $utilisateur->toArray($this->container))));
        }

        return new JsonResponse(array('code' => 0, "message" => " Formulaire d utilisateur", "data" => array("postes"=>$postes,"antennes"=>$antennes)));
    }




    public function editAction( Request $request,Utilisateur $utilisateur)
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
        
        $utilisateurs = $em->getRepository('AppBundle:Utilisateur')->findAll();
        $postes = $em->getRepository('AppBundle:Poste')->findAll();
        $antennes = $em->getRepository('AppBundle:Antenne')->findAll();

        foreach ($antennes as $key => $antenne) 
        {
            $antennes[$key] =  $antenne->getLibelle();
            
        }

        foreach ($postes as $key => $poste) 
        {
            $postes[$key] =  $poste->getLibelle();
            
        }
        

        if(!is_null($utilisateur))
        {

            
            

            if(!is_null($data))
            {
                $post = $em->getRepository("AppBundle:Poste")->findOneByLibelle($data["poste"]);
                $ant = $em->getRepository("AppBundle:Antenne")->findOneByLibelle($data["antenne"]);
               
                $utilisateur->setPoste($post);
                $utilisateur->setAntenne($ant);
                

                if($data["role"] =="ROLE_USER")
                {
                    $roles[]= 'ROLE_USER';
                }
                else
                {
                    $roles[]= 'ROLE_MANAGER';
                }
            
                $utilisateur->setRoles($roles);

                 try
                {
                    $em->persist($utilisateur);
                    $em->flush();
                }
                catch(\Exception $e)
                {
                    return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
                }

        return new JsonResponse(array('code' => 0, "message" =>" utilisateur modifie ", "data" => array("entity" => $utilisateur->toArray($this->container))));

        }

            
    }

        return new JsonResponse(array('code' => 0, "message" => " Formulaire d utilisateur", "data" => array("postes"=>$postes,"antennes"=>$antennes,"entity"=>$utilisateur->toArray($this->container))));
}



     /**
     * Cette fonction d afficher les informations d'un utilisateur
     * @ApiDoc(
     *  resource=true,
     *  description="Retourne un nouvel utilisateur"
     * )
     *
     * @return array
     */

    public function showAction(Request $request)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $data = json_decode($request->getContent(), true);


        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository('AppBundle:Utilisateur')->findOneById($data["id"]);
        

        
        return new JsonResponse(array('code' => 0, "message" => count($utilisateur)." Utilisateur non trouvé", "data" => array("entity" => $utilisateur->toArray($this->container))));
    }

     

    

    public function grant(Utilisateur $utilisateur) 
    {
        $roles = $utilisateur->getRoles();

        if($utilisateur->getAttribution()->getNiveau() == 1){
            $roles[] = 'ROLE_MANAGER';
        }

        if($utilisateur->getAttribution()->getNiveau() == 2){
            $roles[] = 'ROLE_MAJOR';
        }

        if($utilisateur->getAttribution()->getNiveau() == 3){
            $roles[] = 'ROLE_CHEF';
        }

        if($utilisateur->getAttribution()->getType() == 5){
            $roles[] = 'ROLE_PEV';
        }

        if($utilisateur->getAttribution()->getType() == 6){
            $roles[] = 'ROLE_OMS';
        }

        $utilisateur->setRoles($roles);

        return $utilisateur;
    }



    public function apilistAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($request->isMethod('GET'))
        {
            $users = $em->getRepository('AppBundle:Utilisateur')->findAll();

            foreach ($users as $key => $user) 
            {
                $users[$key] =  $user->toArray($this->container);
                
            }

            return new JsonResponse($users);
        }

        $data = $request->files->get('file');

       // $data = json_decode($request->getContent(), true);
        return new JsonResponse($data);

        
        
        

        
    }

    public function apiposteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $users = $em->getRepository('AppBundle:Poste')->findAll();

        foreach ($users as $key => $user) 
        {
            $users[$key] =  $user->toArray($this->container);
            
        }

        return new JsonResponse($users);

        
    }

    public function apiposteoneAction(Request $request,Poste $poste)
    {
        if(!is_object($poste))
        {
            return new JsonResponse(array('data'=>'not found')); 
        }

       
        return new JsonResponse($poste->toArray($this->container)); 

          
    }

    public function apicreateAction(Request $request)
    {
        
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        
        $utilisateurs = $em->getRepository('AppBundle:Utilisateur')->findAll();
        $postes = $em->getRepository('AppBundle:Poste')->findAll();

        foreach ($postes as $key => $poste) 
        {
            $postes[$key] =  $poste->getLibelle();
            
        }
        
        foreach ($utilisateurs as $key => $user) 
        {
            $utilisateurs[$key] =  $user->toArray($this->container);
            
        }
        

        if(!is_null($data))
        {

            $utilisateur = new Utilisateur();
            $roles[]= 'ROLE_USER';
            $utilisateur->setRoles($roles);
        
            $post = $em->getRepository("AppBundle:Poste")->findOneByLibelle($data["poste"]);
            $ant = $em->getRepository("AppBundle:Antenne")->findOneById(1);

            $utilisateur->setNom($data["nom"]);
            $utilisateur->setPrenom($data["prenom"]);
            $utilisateur->setSexe($data["sexe"]);
            $utilisateur->setCni($data["cni"]);
            $utilisateur->setTelephone($data["telephone"]);
            $utilisateur->setEmail($data["email"]);
            $utilisateur->setPoste($post);
            $utilisateur->setAntenne($ant);
            $utilisateur->setPassword($data["password"]);
            $utilisateur->setAdresse($data["adresse"]);
            $utilisateur->setLogin($data["email"]);
            $utilisateur->setUsername($data["email"]);
            
            $password = $this->get('security.password_encoder')
                            ->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($password);

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
                    $img->setType("profil");

                    $utilisateur->setImage($img);

                }
            }

            try
            {   
                    
                    $em->persist($utilisateur);
                    $em->flush();
            }
            catch(\Exception $e)
            {
                return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
            }

            return new JsonResponse($utilisateur->toArray($this->container));
        }

        return new JsonResponse(array('code' => 0, "message" => " Formulaire d utilisateur", "data" => array("postes"=>$postes)));
    }

    public function uploadAction(Request $request)
    {
        $data=$request->files->get('image');
                
                $image = substr($data, strpos( $data,';')+1);
                //list($type, $image) = explode(';', $image);
                //list(, $image)      = explode(',', $image);
                //list(, $type)      = explode(':', $type);
                $image = base64_decode($image);
                $types = array('image/jpg','image/jpeg','image/png','image/gif');
                $resourceDir = realpath(__DIR__.'/../../../web/uploads/');
                //$filepath = __DIR__.'/../../../web/uploads/';
                //$base = $filepath;
                $baseok = " C:\\xampp\htdocs\apprest\\web\\uploads\\";
                $filename = uniqid();
                
                $r = false;
               /* if($key = array_search($type, $types))
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
                }*/
                if(file_put_contents($resourceDir, $image))
                {
                    return new JsonResponse(array('title'=>'ok'));

                }
                return new JsonResponse(array('title'=>'no'));
            
    }

    public function deleteAction(Request $request, Utilisateur $user)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        if(!is_null($user))
        {
            if(!is_null($data))
            {
                
                    $user->setIsActive(false);
                    $em->persist($user);
                    $em->flush();
                
                
                

                return new JsonResponse(array('code' => 0, "message" =>"utilisateur suprime", "data" => array("entity"=>$user->toArray($this->container))));

            }
            return new JsonResponse(array('code' => 0, "message" =>"form ", "data" => array("entity"=>$user->toArray($this->container))));

        }
        return new JsonResponse(array('code' => 2, "message" =>"utilisateur inexistant ", "data" => array("entity"=>null)));

    }

    public function profileAction(Request $request, Utilisateur $user)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        if(is_object($user))
        {
            return new JsonResponse(array('code'=>0,"message"=>"profile ","data"=>array("entity"=>$user->toArray($this->container))));
        }
        return new JsonResponse(array('code' => 2, "message" =>"utilisateur inexistant ", "data" => array("entity"=>null)));
    }

    public function profileeditAction( Request $request,Utilisateur $utilisateur)
    {
        
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        
        if(!is_null($utilisateur))
        {


            if(!is_null($data))
            {
                $utilisateur->setCni($data["cni"]);
                $utilisateur->setTelephone($data["telephone"]);
                $utilisateur->setEmail($data["email"]);
                $utilisateur->setAdresse($data["adresse"]);

                 $code = new Convert();

                 $pass = $code->cryptoJsAesDecrypt($data["email"], $data["password"]);

                $utilisateur->setPassword($pass);
                $password = $this->get('security.password_encoder')
                            ->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($password);
               
                $utilisateur->setLogin($data["email"]);
                $utilisateur->setUsername($data["email"]);

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

                        $utilisateur->setImage($img);

                    }
                }


                 try
                {
                    $em->persist($utilisateur);
                    $em->flush();
                }
                catch(\Exception $e)
                {
                    return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
                }

                 try
                {
                    $message = \Swift_Message::newInstance()
                        ->setSubject('New Password')
                        ->setFrom('njomorostand@gmail.com')
                        ->setTo($utilisateur->getEmail())
                        ->setBody(
                           $this->renderView('test.html.twig',array('password' => $pass ),'text/html'));
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
                    
                    $this->get('mailer')->send($message);

                }
                catch(\Exception $e)
                {
                    return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
                }

        return new JsonResponse(array('code' => 0, "message" =>" utilisateur modifie ", "data" => array("entity" => $utilisateur->toArray($this->container))));

        }
        return new JsonResponse(array('code' => 0, "message" => " Formulaire d utilisateur", "data" => array("entity"=>$utilisateur->toArray($this->container))));
    }

}

public function billAction( Request $request,Utilisateur $utilisateur)
    {
        
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();
        
        if(!is_null($utilisateur))
        {

            if(!is_null($data))
            {
                $fiche = new Paye();
                $fiche->setMessage($data["message"]);
                $fiche->setDate(new \Datetime($data["date"]));
                $fiche->setUtilisateur($utilisateur);

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

                        $fiche->setImage($img);

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
                        $fiche->setFile($f);
                                    
                    }
                }


                 try
                {
                    $em->persist($fiche);
                    $em->flush();
                }
                catch(\Exception $e)
                {
                    return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
                }

        return new JsonResponse(array('code' => 0, "message" =>"fiche enregistrée ", "data" => array("entity" => $utilisateur->toArray($this->container))));

        }
        return new JsonResponse(array('code' => 0, "message" => " Formulaire de paye", "data" => array("entity"=>$utilisateur->toArray($this->container))));
    }

    }

    public function billallAction(Request $request, Utilisateur $utilisateur)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        if(is_object($utilisateur))
        {
            $em = $this->getDoctrine()->getManager();
            $bills = $em->getRepository('AppBundle:Paye')->findByUtilisateur($utilisateur);

            foreach ($bills as $key => $bill) 
            {
                $bills[$key] = $bill->toArray($this->container);
            }

            return new JsonResponse(array('code'=>0,"message"=>"bills ","data"=>array("entities"=>$bills)));
        }
    }

    public function enddayAction(Request $request,Utilisateur $utilisateur)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $data = json_decode($request->getContent(), true);
        $ad = file_get_contents("https://api.ipify.org?format=json");
        
        $adip = substr($ad, 7,-2);
        if(is_object($utilisateur))
        {
            $ip = $request->getClientIp();
            $em = $this->getDoctrine()->getManager();
            $pre = $em->getRepository('AppBundle:Presence')->findOneBy(array("utilisateur"=>$utilisateur),array("id"=>"DESC"));
            $date = new \Datetime();
            $pre->setDepart($date->format("h:i:sa"));
            $pre->setLogoutip($ip);
            $pre->setLogoutplace($adip);
            $pre->setCloseby("user");


            try
            {
                $em->persist($pre);
                $em->flush();
            }
            catch(\Exception $e)
            {
                return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
            }
            return new JsonResponse(array('code' => 0, "message" => "successfully end day","data"=>array("depart"=>$pre->getDepart(),"entity"=>$utilisateur->toArray($this->container))));

        }
    }
    public function presenceAction(Request $request, Utilisateur $utilisateur)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        if(is_object($utilisateur))
        {
            $em= $this->getDoctrine()->getManager();

            $all = $em->getRepository('AppBundle:Presence')->findByUtilisateur($utilisateur);
            $tab =[];
            $curr = [];
            $date = new \Datetime();

            foreach ($all as $key => $pre) 
            {
                $tab[$pre->getDate()->format('m')][] = $pre->toArray($this->container);

                if($pre->getDate()->format('m') == $date->format('m'))
                {
                    $curr[]= $pre->toArray($this->container);
                }
            }

            return new JsonResponse(array("code"=>0,"message"=>"historique ok","data"=>array("all"=>$tab,"current"=>$curr)));
        }
        return new JsonResponse(array("code"=>2,"message"=>"utilisateur non existant","data"=>array("entity"=>null)));
    }




   
}

