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
namespace Teknoo\MangoPayBundle\Tests\Transcriber;

use Teknoo\MangoPayBundle\Entity\Interfaces\User\AddressInterface;
use Teknoo\MangoPayBundle\Entity\Interfaces\User\FullNaturalUserInterface;
use Teknoo\MangoPayBundle\Entity\Interfaces\User\LegalUserInterface;
use Teknoo\MangoPayBundle\Entity\Interfaces\User\NaturalUserInterface;
use Teknoo\MangoPayBundle\Entity\Interfaces\User\UserInterface;
use Teknoo\MangoPayBundle\Transcriber\UserTranscriber;

/**
 * Class UserTranscriberTest.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 *
 * @covers \Teknoo\MangoPayBundle\Transcriber\UserTranscriber
 */
class UserTranscriberTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return UserTranscriber
     */
    public function buildService()
    {
        return new UserTranscriber();
    }

    /**
     * @expectedException \Teknoo\MangoPayBundle\Exception\BadTypeException
     */
    public function testToMangoNonSupported()
    {
        $this->buildService()
            ->toMango(
                $this->createMock(UserInterface::class)
            );
    }

    public function testToMangoNaturalUser()
    {
        $user = $this->createMock(NaturalUserInterface::class);
        $user->expects(self::once())->method('getMangoPayId')->willReturn(12345);
        $user->expects(self::once())->method('getFirstName')->willReturn('first name value');
        $user->expects(self::once())->method('getLastName')->willReturn('last name value');
        $date = new \DateTime('1989-03-19');
        $user->expects(self::once())->method('getBirthday')->willReturn($date);
        $user->expects(self::once())->method('getEmail')->willReturn('email@address.com');
        $user->expects(self::once())->method('getNationality')->willReturn('nationality value');
        $user->expects(self::once())->method('getCountryOfResidence')->willReturn('country value');

        $result = $this->buildService()->toMango($user);
        self::assertInstanceOf('MangoPay\UserNatural', $result);
        self::assertEquals(12345, $result->Id);
        self::assertEquals('first name value', $result->FirstName);
        self::assertEquals('last name value', $result->LastName);
        self::assertEquals($date->getTimestamp(), $result->Birthday);
        self::assertEquals('email@address.com', $result->Email);
        self::assertEquals('nationality value', $result->Nationality);
        self::assertEquals('country value', $result->CountryOfResidence);
        self::assertNull($result->Address);
    }

    public function testToMangoFullNaturalUserWithoutAddress()
    {
        $user = $this->createMock(FullNaturalUserInterface::class);
        $user->expects(self::once())->method('getMangoPayId')->willReturn(12345);
        $user->expects(self::once())->method('getFirstName')->willReturn('first name value');
        $user->expects(self::once())->method('getLastName')->willReturn('last name value');
        $date = new \DateTime('1989-03-19');
        $user->expects(self::once())->method('getBirthday')->willReturn($date);
        $user->expects(self::once())->method('getEmail')->willReturn('email@address.com');
        $user->expects(self::once())->method('getNationality')->willReturn('nationality value');
        $user->expects(self::once())->method('getCountryOfResidence')->willReturn('country value');
        $user->expects(self::once())->method('getOccupation')->willReturn('occupaton value');
        $user->expects(self::once())->method('getIncomeRange')->willReturn('income range value');
        $user->expects(self::once())->method('getProofOfAddress')->willReturn('proof address value');
        $user->expects(self::once())->method('getProofOfIdentity')->willReturn('proof identity value');

        $result = $this->buildService()->toMango($user);
        self::assertInstanceOf('MangoPay\UserNatural', $result);
        self::assertEquals(12345, $result->Id);
        self::assertEquals('first name value', $result->FirstName);
        self::assertEquals('last name value', $result->LastName);
        self::assertEquals($date->getTimestamp(), $result->Birthday);
        self::assertEquals('email@address.com', $result->Email);
        self::assertEquals('nationality value', $result->Nationality);
        self::assertEquals('country value', $result->CountryOfResidence);
        self::assertEquals('occupaton value', $result->Occupation);
        self::assertEquals('income range value', $result->IncomeRange);
        self::assertEquals('proof address value', $result->ProofOfAddress);
        self::assertEquals('proof identity value', $result->ProofOfIdentity);
        self::assertNull($result->Address);
    }

    public function testToMangoFullNaturalUserWithAddress()
    {
        $address = $this->createMock(AddressInterface::class);
        $address->expects(self::once())->method('getAddress1')->willReturn('address 1 value');
        $address->expects(self::once())->method('getAddress2')->willReturn('address 2 value');
        $address->expects(self::once())->method('getPostalCode')->willReturn('zip value');
        $address->expects(self::once())->method('getCity')->willReturn('city value');
        $address->expects(self::once())->method('getRegion')->willReturn('region value');
        $address->expects(self::once())->method('getCountry')->willReturn('country value');

        $user = $this->createMock(FullNaturalUserInterface::class);
        $user->expects(self::once())->method('getMangoPayId')->willReturn(12345);
        $user->expects(self::once())->method('getFirstName')->willReturn('first name value');
        $user->expects(self::once())->method('getLastName')->willReturn('last name value');
        $date = new \DateTime('1989-03-19');
        $user->expects(self::once())->method('getBirthday')->willReturn($date);
        $user->expects(self::once())->method('getEmail')->willReturn('email@address.com');
        $user->expects(self::once())->method('getNationality')->willReturn('nationality value');
        $user->expects(self::once())->method('getCountryOfResidence')->willReturn('country value');
        $user->expects(self::once())->method('getOccupation')->willReturn('occupaton value');
        $user->expects(self::once())->method('getIncomeRange')->willReturn('income range value');
        $user->expects(self::once())->method('getProofOfAddress')->willReturn('proof address value');
        $user->expects(self::once())->method('getProofOfIdentity')->willReturn('proof identity value');
        $user->expects(self::once())->method('getAddressObject')->willReturn($address);

        $result = $this->buildService()->toMango($user);
        self::assertInstanceOf('MangoPay\UserNatural', $result);
        self::assertEquals(12345, $result->Id);
        self::assertEquals('first name value', $result->FirstName);
        self::assertEquals('last name value', $result->LastName);
        self::assertEquals($date->getTimestamp(), $result->Birthday);
        self::assertEquals('email@address.com', $result->Email);
        self::assertEquals('nationality value', $result->Nationality);
        self::assertEquals('country value', $result->CountryOfResidence);
        self::assertEquals('occupaton value', $result->Occupation);
        self::assertEquals('income range value', $result->IncomeRange);
        self::assertEquals('proof address value', $result->ProofOfAddress);
        self::assertEquals('proof identity value', $result->ProofOfIdentity);
        self::assertInstanceOf('MangoPay\Address', $result->Address);
        $address = $result->Address;
        self::assertEquals('address 1 value', $address->AddressLine1);
        self::assertEquals('address 2 value', $address->AddressLine2);
        self::assertEquals('zip value', $address->PostalCode);
        self::assertEquals('city value', $address->City);
        self::assertEquals('region value', $address->Region);
        self::assertEquals('country value', $address->Country);
    }

    public function testToMangoLegalUserWithoutAddress()
    {
        $user = $this->createMock(LegalUserInterface::class);
        $user->expects(self::once())->method('getMangoPayId')->willReturn(12345);
        $user->expects(self::once())->method('getName')->willReturn('name value');
	$user->expects(self::once())->method('getLegalPersonType')->willReturn(LegalUserInterface::LEGAL_PERSON_TYPE_BUSINESS);
        $user->expects(self::once())->method('getLegalRepresentativeFirstName')->willReturn('first name value');
        $user->expects(self::once())->method('getLegalRepresentativeLastName')->willReturn('last name value');
        $date = new \DateTime('1989-03-19');
        $user->expects(self::once())->method('getLegalRepresentativeBirthday')->willReturn($date);
        $user->expects(self::once())->method('getEmail')->willReturn('email@address.com');
        $user->expects(self::once())->method('getLegalRepresentativeEmail')->willReturn('email2@address.com');
        $user->expects(self::once())->method('getLegalRepresentativeNationality')->willReturn('nationality value');
        $user->expects(self::once())->method('getLegalRepresentativeCountryOfResidence')->willReturn('country value');

        $result = $this->buildService()->toMango($user);
        self::assertInstanceOf('MangoPay\UserLegal', $result);
        self::assertEquals(12345, $result->Id);
        self::assertEquals('name value', $result->Name);
	self::assertEquals(LegalUserInterface::LEGAL_PERSON_TYPE_BUSINESS, $result->LegalPersonType);
        self::assertEquals('first name value', $result->LegalRepresentativeFirstName);
        self::assertEquals('last name value', $result->LegalRepresentativeLastName);
        self::assertEquals($date->getTimestamp(), $result->LegalRepresentativeBirthday);
        self::assertEquals('email@address.com', $result->Email);
        self::assertEquals('email2@address.com', $result->LegalRepresentativeEmail);
        self::assertEquals('nationality value', $result->LegalRepresentativeNationality);
        self::assertEquals('country value', $result->LegalRepresentativeCountryOfResidence);
        self::assertNull($result->HeadquartersAddress);
        self::assertNull($result->LegalRepresentativeAddress);
    }

    public function testToMangoLegalUserWithAddressHeadQuarter()
    {
        $address = $this->createMock(AddressInterface::class);
        $address->expects(self::once())->method('getAddress1')->willReturn('address 1 value');
        $address->expects(self::once())->method('getAddress2')->willReturn('address 2 value');
        $address->expects(self::once())->method('getPostalCode')->willReturn('zip value');
        $address->expects(self::once())->method('getCity')->willReturn('city value');
        $address->expects(self::once())->method('getRegion')->willReturn('region value');
        $address->expects(self::once())->method('getCountry')->willReturn('country value');

        $user = $this->createMock(LegalUserInterface::class);
        $user->expects(self::once())->method('getMangoPayId')->willReturn(12345);
        $user->expects(self::once())->method('getName')->willReturn('name value');
	$user->expects(self::once())->method('getLegalPersonType')->willReturn(LegalUserInterface::LEGAL_PERSON_TYPE_BUSINESS);
        $user->expects(self::once())->method('getLegalRepresentativeFirstName')->willReturn('first name value');
        $user->expects(self::once())->method('getLegalRepresentativeLastName')->willReturn('last name value');
        $date = new \DateTime('1989-03-19');
        $user->expects(self::once())->method('getLegalRepresentativeBirthday')->willReturn($date);
        $user->expects(self::once())->method('getEmail')->willReturn('email@address.com');
        $user->expects(self::once())->method('getLegalRepresentativeEmail')->willReturn('email2@address.com');
        $user->expects(self::once())->method('getLegalRepresentativeNationality')->willReturn('nationality value');
        $user->expects(self::once())->method('getLegalRepresentativeCountryOfResidence')->willReturn('country value');
        $user->expects(self::once())->method('getHeadquartersAddress')->willReturn($address);

        $result = $this->buildService()->toMango($user);
        self::assertInstanceOf('MangoPay\UserLegal', $result);
        self::assertEquals(12345, $result->Id);
        self::assertEquals('name value', $result->Name);
	self::assertEquals(LegalUserInterface::LEGAL_PERSON_TYPE_BUSINESS, $result->LegalPersonType);
        self::assertEquals('first name value', $result->LegalRepresentativeFirstName);
        self::assertEquals('last name value', $result->LegalRepresentativeLastName);
        self::assertEquals($date->getTimestamp(), $result->LegalRepresentativeBirthday);
        self::assertEquals('email@address.com', $result->Email);
        self::assertEquals('email2@address.com', $result->LegalRepresentativeEmail);
        self::assertEquals('nationality value', $result->LegalRepresentativeNationality);
        self::assertEquals('country value', $result->LegalRepresentativeCountryOfResidence);
        self::assertInstanceOf('MangoPay\Address', $result->HeadquartersAddress);
        self::assertNull($result->LegalRepresentativeAddress);
        $address = $result->HeadquartersAddress;
        self::assertEquals('address 1 value', $address->AddressLine1);
        self::assertEquals('address 2 value', $address->AddressLine2);
        self::assertEquals('zip value', $address->PostalCode);
        self::assertEquals('city value', $address->City);
        self::assertEquals('region value', $address->Region);
        self::assertEquals('country value', $address->Country);
    }

    public function testToMangoLegalUserWithAddressLegal()
    {
        $address = $this->createMock(AddressInterface::class);
        $address->expects(self::once())->method('getAddress1')->willReturn('address 1 value');
        $address->expects(self::once())->method('getAddress2')->willReturn('address 2 value');
        $address->expects(self::once())->method('getPostalCode')->willReturn('zip value');
        $address->expects(self::once())->method('getCity')->willReturn('city value');
        $address->expects(self::once())->method('getRegion')->willReturn('region value');
        $address->expects(self::once())->method('getCountry')->willReturn('country value');

        $user = $this->createMock(LegalUserInterface::class);
        $user->expects(self::once())->method('getMangoPayId')->willReturn(12345);
        $user->expects(self::once())->method('getName')->willReturn('name value');
	$user->expects(self::once())->method('getLegalPersonType')->willReturn(LegalUserInterface::LEGAL_PERSON_TYPE_BUSINESS);
        $user->expects(self::once())->method('getLegalRepresentativeFirstName')->willReturn('first name value');
        $user->expects(self::once())->method('getLegalRepresentativeLastName')->willReturn('last name value');
        $date = new \DateTime('1989-03-19');
        $user->expects(self::once())->method('getLegalRepresentativeBirthday')->willReturn($date);
        $user->expects(self::once())->method('getEmail')->willReturn('email@address.com');
        $user->expects(self::once())->method('getLegalRepresentativeEmail')->willReturn('email2@address.com');
        $user->expects(self::once())->method('getLegalRepresentativeNationality')->willReturn('nationality value');
        $user->expects(self::once())->method('getLegalRepresentativeCountryOfResidence')->willReturn('country value');
        $user->expects(self::once())->method('getLegalRepresentativeAddress')->willReturn($address);

        $result = $this->buildService()->toMango($user);
        self::assertInstanceOf('MangoPay\UserLegal', $result);
        self::assertEquals(12345, $result->Id);
        self::assertEquals('name value', $result->Name);
	self::assertEquals(LegalUserInterface::LEGAL_PERSON_TYPE_BUSINESS, $result->LegalPersonType);
        self::assertEquals('first name value', $result->LegalRepresentativeFirstName);
        self::assertEquals('last name value', $result->LegalRepresentativeLastName);
        self::assertEquals($date->getTimestamp(), $result->LegalRepresentativeBirthday);
        self::assertEquals('email@address.com', $result->Email);
        self::assertEquals('email2@address.com', $result->LegalRepresentativeEmail);
        self::assertEquals('nationality value', $result->LegalRepresentativeNationality);
        self::assertEquals('country value', $result->LegalRepresentativeCountryOfResidence);
        self::assertInstanceOf('MangoPay\Address', $result->LegalRepresentativeAddress);
        self::assertNull($result->HeadquartersAddress);
        $address = $result->LegalRepresentativeAddress;
        self::assertEquals('address 1 value', $address->AddressLine1);
        self::assertEquals('address 2 value', $address->AddressLine2);
        self::assertEquals('zip value', $address->PostalCode);
        self::assertEquals('city value', $address->City);
        self::assertEquals('region value', $address->Region);
        self::assertEquals('country value', $address->Country);
    }
}
