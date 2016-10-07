<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Doctrine\ORM\EntityRepository;

class UtilisateurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Entrez le nom...')))
            ->add('prenom', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Entrez le prénom...')))
            ->add('sexe', ChoiceType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Entrez le nom...'), 'choices' => array('Masculin' => 'M', 'Féminin' => 'F')))
            ->add('email', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Entrez l\'e-mail...')))
            ->add('cni', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Entrez le numéro CNI ou Passeport...')))
            ->add('adresse', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Entrez votre...')))
            ->add('telephone', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Entrez votre numéro ...')))
            ->add('image', FileType::class, array('required'=>false,'label' => 'Photo de profil', 'attr' => array('class' => 'form-control')))
            ->add('poste', EntityType::class, array('multiple'=>false,'required' => true, 'attr' => array('class' => 'form-control select2', 'data-placeholder' => 'Sélectionnez un poste...'), 'class' => 'AppBundle:Poste', 'choice_label' => 'libelle'))
            ->add('password' , RepeatedType::class, array(
                                                    'type' => PasswordType::class,
                                                    'first_options' => array('label' => 'Mot de passe','attr' => array('class' => 'form-control', 'placeholder' => 'Entrez le mot de passe...')),
                                                    'second_options' => array('label' => 'Repéter le mot de passe','attr' => array('class' => 'form-control', 'placeholder' => 'Retapez le mot de passe...')),
                                                    ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Utilisateur'
        ));
    }
}
