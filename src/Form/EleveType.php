<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EleveType extends AbstractType
{
    private UserRepository $userRepo;
    
    public function __construct(UserRepository $repo)
    {
        $this->userRepo = $repo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder
        //     ->add('nom')
        //     ->add('prenom')
        //     ->add('parent', EntityType::class, [
        //         "class" => User::class,
        //         "query_builder" => function(EntityRepository $entityRepo){
        //             return $entityRepo->createQueryBuilder("qb")
        //             ->where("qb.isParent =: isP")->andWhere("qd.isActif =:isA")
        //             ->setParameters(["isP" => true, "isA" => true]);
        //         }
        //     ])
        //     ->add('classe')
        //     ->add('Enregistrer', SubmitType::class)
        // ;

        $builder
        ->add('matricule')
        ->add('nom')
        ->add('prenom')
        ->add('parent', EntityType::class, [
            "class" => User::class,
            "query_builder" => $this->userRepo->findParentQb()
        ])
        ->add('classe')
        ->add('photoFile', FileType::class, [
            "label"=> "Photo de l'eleve",
            "mapped" => false,
            "constraints" => [
                new File([
                    "maxSize" => "2M",
                    "mimeTypes" =>[
                        "image/jpeg",
                        "image/png"
                    ]
                ])
            ]
        ])
        ->add('Enregistrer', SubmitType::class)
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
            'csrf_protection' => false
        ]);
    }
}
