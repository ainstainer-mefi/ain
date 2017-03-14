<?php
/**
 * Created by PhpStorm.
 * User: ausenko
 * Date: 14.03.17
 * Time: 11:55
 */
namespace Usenko\TestImageBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Usenko\TestImageBundle\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder

            ->add('image', FileType::class, array('label' => 'image'))
            ->add('save', SubmitType::class, ['label' => 'Upload Image'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Image::class,
        ));
    }
}