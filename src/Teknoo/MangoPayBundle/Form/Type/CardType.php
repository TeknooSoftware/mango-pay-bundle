<?php

/**
 * MangoPayBundle.
 *
 * LICENSE
 *
 * This source file is subject to the MIT license and the version 3 of the GPL3
 * license that are bundled with this package in the folder licences
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to richarddeloge@gmail.com so we can send you a copy immediately.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
namespace Teknoo\MangoPayBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class CardType.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class CardType extends AbstractType
{
    /**
     * Configure the form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     * @SuppressWarnings(PHPMD)
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('data', HiddenType::class, ['mapped' => true])
            ->add('accessKeyRef', HiddenType::class, ['mapped' => true])
            ->add('returnURL', HiddenType::class, ['mapped' => true])
            ->add('cardNumber', TextType::class, ['mapped' => false])
            ->add(
                'cardExpirationDate',
                TextType::class,
                ['mapped' => false, 'attr' => ['pattern' => '[0-1]{1}[0-9]{1}[0-9]{2}']]
            )
            ->add('cardCvx', TextType::class, ['mapped' => false]);
    }

    /**
     * Returns null to not prepend input's name.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return;
    }
}
