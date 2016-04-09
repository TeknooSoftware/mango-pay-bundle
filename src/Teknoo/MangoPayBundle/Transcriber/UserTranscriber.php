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
 * to contact@uni-alteri.com so we can send you a copy immediately.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
namespace Teknoo\MangoPayBundle\Transcriber;

use MangoPay\Address;
use MangoPay\UserLegal;
use MangoPay\UserNatural;
use Teknoo\MangoPayBundle\Exception\BadTypeException;
use Teknoo\MangoPayBundle\Entity\Interfaces\User\AddressInterface;
use Teknoo\MangoPayBundle\Entity\Interfaces\User\FullNaturalUserInterface;
use Teknoo\MangoPayBundle\Entity\Interfaces\User\LegalUserInterface;
use Teknoo\MangoPayBundle\Entity\Interfaces\User\NaturalUserInterface;
use Teknoo\MangoPayBundle\Entity\Interfaces\User\UserInterface;

/**
 * Class UserTranscriber.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
class UserTranscriber
{
    /**
     * @param NaturalUserInterface $user
     *
     * @return UserNatural
     */
    protected function toMangoNaturalUser(NaturalUserInterface $user)
    {
        $naturalUser = new UserNatural();
        $naturalUser->Id = $user->getMangoPayId();
        $naturalUser->FirstName = $user->getFirstName();
        $naturalUser->LastName = $user->getLastName();
        $naturalUser->Birthday = $user->getBirthday()->getTimestamp();
        $naturalUser->Email = $user->getEmail();
        $naturalUser->Nationality = $user->getNationality();
        $naturalUser->CountryOfResidence = $user->getCountryOfResidence();

        if ($user instanceof FullNaturalUserInterface) {
            $address = $user->getAddressObject();
            if ($address instanceof AddressInterface) {
                $mangoAddress = new Address();
                $mangoAddress->AddressLine1 = $address->getAddress1();
                $mangoAddress->AddressLine2 = $address->getAddress2();
                $mangoAddress->PostalCode = $address->getPostalCode();
                $mangoAddress->City = $address->getCity();
                $mangoAddress->Region = $address->getRegion();
                $mangoAddress->Country = $address->getCountry();
                $naturalUser->Address = $mangoAddress;
            }

            $naturalUser->Occupation = $user->getOccupation();
            $naturalUser->IncomeRange = $user->getIncomeRange();
            $naturalUser->ProofOfAddress = $user->getProofOfAddress();
            $naturalUser->ProofOfIdentity = $user->getProofOfIdentity();
        }

        return $naturalUser;
    }

    /**
     * @param LegalUserInterface $user
     *
     * @return UserLegal
     */
    protected function toMangoLegalUser(LegalUserInterface $user)
    {
        $legalUser = new UserLegal();
        $legalUser->Id = $user->getMangoPayId();
        $legalUser->Email = $user->getEmail();
        $legalUser->Name = $user->getName();

        $headquartersAddress = $user->getHeadquartersAddress();
        if ($headquartersAddress instanceof AddressInterface) {
            $mangoAddress = new Address();
            $mangoAddress->AddressLine1 = $headquartersAddress->getAddress1();
            $mangoAddress->AddressLine2 = $headquartersAddress->getAddress2();
            $mangoAddress->PostalCode = $headquartersAddress->getPostalCode();
            $mangoAddress->City = $headquartersAddress->getCity();
            $mangoAddress->Region = $headquartersAddress->getRegion();
            $mangoAddress->Country = $headquartersAddress->getCountry();
            $legalUser->HeadquartersAddress = $mangoAddress;
        }

        $legalUser->LegalRepresentativeFirstName = $user->getLegalRepresentativeFirstName();
        $legalUser->LegalRepresentativeLastName = $user->getLegalRepresentativeLastName();
        $legalUser->LegalRepresentativeEmail = $user->getLegalRepresentativeEmail();
        $legalUser->LegalRepresentativeBirthday = $user->getLegalRepresentativeBirthday()->getTimestamp();
        $legalUser->LegalRepresentativeNationality = $user->getLegalRepresentativeNationality();
        $legalUser->LegalRepresentativeCountryOfResidence = $user->getLegalRepresentativeCountryOfResidence();

        $legalRepresentativeAddress = $user->getLegalRepresentativeAddress();
        if ($legalRepresentativeAddress instanceof AddressInterface) {
            $mangoAddress = new Address();
            $mangoAddress->AddressLine1 = $legalRepresentativeAddress->getAddress1();
            $mangoAddress->AddressLine2 = $legalRepresentativeAddress->getAddress2();
            $mangoAddress->PostalCode = $legalRepresentativeAddress->getPostalCode();
            $mangoAddress->City = $legalRepresentativeAddress->getCity();
            $mangoAddress->Region = $legalRepresentativeAddress->getRegion();
            $mangoAddress->Country = $legalRepresentativeAddress->getCountry();
            $legalUser->LegalRepresentativeAddress = $mangoAddress;
        }

        return $legalUser;
    }

    /**
     * @param UserInterface $user
     *
     * @return UserLegal|UserNatural
     */
    public function toMango(UserInterface $user)
    {
        if ($user instanceof NaturalUserInterface) {
            return $this->toMangoNaturalUser($user);
        } elseif ($user instanceof LegalUserInterface) {
            return $this->toMangoLegalUser($user);
        }

        throw new BadTypeException('The class user '.get_class($user).' has not been recognised');
    }
}
