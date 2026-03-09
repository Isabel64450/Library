<?php

namespace App\Form;


use App\Entity\Loan;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoanType extends AbstractType
{  private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var User|null $user */
        $user = $this->security->getUser();
        $builder
            ->add('loanDate', null, [
                'widget' => 'single_text',
            ])
            ->add('returnDate', null, [
                'widget' => 'single_text',
            ]);
            
            
         
           if ($user instanceof User && $this->security->isGranted('ROLE_ADMIN')) {

        $builder->add('user', EntityType::class, [
            'class' => User::class,
            'choice_label' => function(User $user) {
                    return $user->getName() . ' - ' . $user->getEmail() . ' - ' . $user->getTelephone();
                },
            'placeholder' => 'Sélectionner un utilisateur',
        ]);

            } else {

        $builder->add('userDisplay', TextType::class, [
                'mapped' => false,
                'data' => $user
                ? $user->getName().' - ' .$user->getEmail(). ' - ' .$user->getTelephone()
                : '',
                'disabled' => true,
                'label' => 'Utilisateur'
            ]);


    }

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Loan::class,
        ]);
    }
}
