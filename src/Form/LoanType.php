<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Loan;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('loanDate', null, [
                'widget' => 'single_text',
            ])
            ->add('returnDate', null, [
                'widget' => 'single_text',
            ])
            
            
            ->add('user', EntityType::class, [
                  'class' => User::class,
                  'choice_label' => function(User $user) {
                   return $user->getName() . ' - ' . $user->getEmail() . ' - ' . $user->getTelephone();},
                  'placeholder' => 'Sélectionner un utilisateur',
                  'attr' => ['class' => 'form-select']
             ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Loan::class,
        ]);
    }
}
