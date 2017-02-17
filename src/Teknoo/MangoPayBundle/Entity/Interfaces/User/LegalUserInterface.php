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

namespace Teknoo\MangoPayBundle\Entity\Interfaces\User;

/**
 * Interface LegalUserInterface.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
interface LegalUserInterface extends UserInterface
{
    /**
     * Value for return of getLegalPersonType();.
     */
    const LEGAL_PERSON_TYPE_BUSINESS = 'BUSINESS';
    const LEGAL_PERSON_TYPE_ORGANIZATION = 'ORGANIZATION';

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getLegalPersonType();

    /**
     * @return AddressInterface
     */
    public function getHeadquartersAddress();

    /**
     * @return AddressInterface
     */
    public function getLegalRepresentativeAddress();

    /**
     * @return string
     */
    public function getLegalRepresentativeFirstName();

    /**
     * @return string
     */
    public function getLegalRepresentativeLastName();

    /**
     * @return string
     */
    public function getLegalRepresentativeEmail();

    /**
     * @return \DateTime
     */
    public function getLegalRepresentativeBirthday();

    /**
     * @return string
     */
    public function getLegalRepresentativeNationality();

    /**
     * @return string
     */
    public function getLegalRepresentativeCountryOfResidence();
}
