<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Editor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // Replace EnumType with ChoiceType
use App\Enum\BookStatus;    // Assuming BookStatus exists in this namespace
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints as Assert;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('isbn', null, [
                'constraints' => [
                    new Assert\Isbn([
                        'type' => null,
                        'message' => 'Ce champ doit contenir un numéro ISBN valide.'
                    ])
                ]
            ])
            ->add('cover')
            ->add('pageNumber', null, [
                'label' => 'Number of Pages',
            ])
            ->add('editedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => BookStatus::cases(), // Assuming PHP 8.1+ Enum cases
                'choice_label' => fn($choice) => $choice->name,
            ])
            ->add('editor', EntityType::class, [
                'class' => Editor::class,
                'choice_label' => 'id',
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('certification', CheckboxType::class, 
            [
                'mapped' => false,
                'label'=> 'Je certifie l\'exactitude des informations fournies',
                'constraints' => [
                    new Assert\IsTrue(['message' => 'Vous devez cocher la case pour ajouter un livre.']),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}