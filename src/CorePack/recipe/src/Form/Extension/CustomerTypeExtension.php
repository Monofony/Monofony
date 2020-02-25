<?php



namespace App\Form\Extension;

use App\Form\EventSubscriber\AddUserFormSubscriber;
use App\Form\Type\User\AppUserType;
use Sylius\Bundle\CustomerBundle\Form\Type\CustomerType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class CustomerTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new AddUserFormSubscriber(AppUserType::class));
    }

    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes(): iterable
    {
        return [CustomerType::class];
    }
}
