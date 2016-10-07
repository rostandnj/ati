<?php

namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\FOSRestController;



use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Courrier;
use AppBundle\Entity\Poste;
use AppBundle\Entity\Image;
use AppBundle\Entity\File;


/**
 * Mail controller.
 *
 */
class MailController extends Controller
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
        $now = new \Datetime('first day of');
        
        $mails = $em->getRepository('AppBundle:Courrier')->findAll();
        $ok = [];
        foreach ($mails as $key => $mail) 
        {
            if($mail->getDate() >= $now)
            {
                $ok[$key] =  $mail->toArray($this->container);
            }
            
            
        }

        return new JsonResponse(array('code' => 0, "message" => count($mails)." Mail(s) récupéré(s)", "data" => array("entities" => $ok)));

        
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

            $mail = new Courrier();
            $user = $this->auth($request);
            $mail->setUtilisateur($user);

            $mail->setLibelle($data["libelle"]);
            $mail->setType($data["type"]);
            $mail->setEmetteur($data["emetteur"]);
            $mail->setRecepteur($data["recepteur"]);
            $mail->setDate(new \Datetime($data["date"]));
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
                    $img->setType("mail");
                    $mail->setImage($img);


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
                $f->setType("mail");
                $mail->setFile($f);
                            
            }
               

            try
            {   
                    
                    $em->persist($mail);
                    $em->flush();
            }
            catch(\Exception $e)
            {
                return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
            }

            return new JsonResponse(array('code' => 0, "message" =>" mail enregistré ", "data" => array("entity" => $mail)));
        }

        return new JsonResponse(array('code' => 0, "message" => " Formulaire de mail", "data" => array("entity"=>null)));
    }

    public function archiveAction(Request $request)
    {   
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        $mails = $em->getRepository('AppBundle:Courrier')->findAll();
        $all=[];

        foreach ($mails as $key => $mail) 
        {
            $all[$mail->getDate()->format('m')][] = $mail->toArray($this->container);
        }


       return new JsonResponse(array('code' => 0, "message" =>" stat recuperes ", "data" => array("entities"=>$all)));
            
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
        $date2 = new \Datetime();
        $firstday = $date2->modify('first day of');

        $query = $em->getRepository('AppBundle:Courrier')->createQueryBuilder('c')
                    ->select('c')
                    
                    ->where('c.date > :now')
                    ->setParameter('now', $firstday) 
                    ->getQuery();

                $r = $query->getResult();

        



        $html = $this->renderView('AppBundle:ati:doc_mail.html.twig', array('date'=>$date,'stat'=>$r));

        $html2pdf = $this->get('html2pdf_factory')->create('P','A4','fr', false, 'ISO-8859-15', array(10, 10, 10, 5));

        $html2pdf->pdf->SetDisplayMode('fullpage');

        $html2pdf->writeHTML($html,isset($_GET['vuehtml']));



        $nom = 'mail_'.uniqid().'.pdf';

        //$file = base64_encode($html2pdf->Output($nom));

        //$filepath = __DIR__.'/../../../web/uploads/'.$nom;

        $html2pdf->Output('../../user/'.$nom, 'F');

       

       
        //$re = file_put_contents($filepath, $html2pdf);

        return new JsonResponse(array("code"=>0,"data"=>$nom));

    }



   
}
