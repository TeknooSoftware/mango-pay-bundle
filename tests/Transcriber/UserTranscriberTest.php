<?php

namespace UniAlteri\MangoPayBundle\Tests\Transcriber;

use UniAlteri\MangoPayBundle\Transcriber\UserTranscriber;

/**
 * Class UserTranscriberTest
 * @package UniAlteri\MangoPayBundle\Tests\Transcriber
 * @covers UniAlteri\MangoPayBundle\Transcriber\UserTranscriber
 */
class UserTranscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return UserTranscriber
     */
    public function buildService()
    {
        return new UserTranscriber();
    }

    /**
     * @expectedException \UniAlteri\MangoPayBundle\Exception\BadTypeException
     */
    public function testToMangoNonSupported()
    {
        $this->buildService()
            ->toMango(
                $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\UserInterface')
            );
    }

    public function testToMangoNaturalUser()
    {
        $user = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\NaturalUserInterface');
        $user->expects($this->once())->method('getMangoPayId')->willReturn(12345);
        $user->expects($this->once())->method('getFirstName')->willReturn('first name value');
        $user->expects($this->once())->method('getLastName')->willReturn('last name value');
        $date = new \DateTime('1989-03-19');
        $user->expects($this->once())->method('getBirthday')->willReturn($date);
        $user->expects($this->once())->method('getEmail')->willReturn('email@address.com');
        $user->expects($this->once())->method('getNationality')->willReturn('nationality value');
        $user->expects($this->once())->method('getCountryOfResidence')->willReturn('country value');


        $result = $this->buildService()->toMango($user);
        $this->assertInstanceOf('MangoPay\UserNatural',$result);
        $this->assertEquals(12345, $result->Id);
        $this->assertEquals('first name value', $result->FirstName);
        $this->assertEquals('last name value', $result->LastName);
        $this->assertEquals($date->getTimestamp(), $result->Birthday);
        $this->assertEquals('email@address.com', $result->Email);
        $this->assertEquals('nationality value', $result->Nationality);
        $this->assertEquals('country value', $result->CountryOfResidence);
        $this->assertNull($result->Address);
    }

    public function testToMangoFullNaturalUserWithoutAddress()
    {
        $user = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\FullNaturalUserInterface');
        $user->expects($this->once())->method('getMangoPayId')->willReturn(12345);
        $user->expects($this->once())->method('getFirstName')->willReturn('first name value');
        $user->expects($this->once())->method('getLastName')->willReturn('last name value');
        $date = new \DateTime('1989-03-19');
        $user->expects($this->once())->method('getBirthday')->willReturn($date);
        $user->expects($this->once())->method('getEmail')->willReturn('email@address.com');
        $user->expects($this->once())->method('getNationality')->willReturn('nationality value');
        $user->expects($this->once())->method('getCountryOfResidence')->willReturn('country value');
        $user->expects($this->once())->method('getOccupation')->willReturn('occupaton value');
        $user->expects($this->once())->method('getIncomeRange')->willReturn('income range value');
        $user->expects($this->once())->method('getProofOfAddress')->willReturn('proof address value');
        $user->expects($this->once())->method('getProofOfIdentity')->willReturn('proof identity value');


        $result = $this->buildService()->toMango($user);
        $this->assertInstanceOf('MangoPay\UserNatural',$result);
        $this->assertEquals(12345, $result->Id);
        $this->assertEquals('first name value', $result->FirstName);
        $this->assertEquals('last name value', $result->LastName);
        $this->assertEquals($date->getTimestamp(), $result->Birthday);
        $this->assertEquals('email@address.com', $result->Email);
        $this->assertEquals('nationality value', $result->Nationality);
        $this->assertEquals('country value', $result->CountryOfResidence);
        $this->assertEquals('occupaton value', $result->Occupation);
        $this->assertEquals('income range value', $result->IncomeRange);
        $this->assertEquals('proof address value', $result->ProofOfAddress);
        $this->assertEquals('proof identity value', $result->ProofOfIdentity);
        $this->assertNull($result->Address);
    }

    public function testToMangoFullNaturalUserWithAddress()
    {
        $address = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\AddressInterface');
        $address->expects($this->once())->method('getAddress1')->willReturn('address 1 value');
        $address->expects($this->once())->method('getAddress2')->willReturn('address 2 value');
        $address->expects($this->once())->method('getPostalCode')->willReturn('zip value');
        $address->expects($this->once())->method('getCity')->willReturn('city value');
        $address->expects($this->once())->method('getRegion')->willReturn('region value');
        $address->expects($this->once())->method('getCountry')->willReturn('country value');

        $user = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\FullNaturalUserInterface');
        $user->expects($this->once())->method('getMangoPayId')->willReturn(12345);
        $user->expects($this->once())->method('getFirstName')->willReturn('first name value');
        $user->expects($this->once())->method('getLastName')->willReturn('last name value');
        $date = new \DateTime('1989-03-19');
        $user->expects($this->once())->method('getBirthday')->willReturn($date);
        $user->expects($this->once())->method('getEmail')->willReturn('email@address.com');
        $user->expects($this->once())->method('getNationality')->willReturn('nationality value');
        $user->expects($this->once())->method('getCountryOfResidence')->willReturn('country value');
        $user->expects($this->once())->method('getOccupation')->willReturn('occupaton value');
        $user->expects($this->once())->method('getIncomeRange')->willReturn('income range value');
        $user->expects($this->once())->method('getProofOfAddress')->willReturn('proof address value');
        $user->expects($this->once())->method('getProofOfIdentity')->willReturn('proof identity value');
        $user->expects($this->once())->method('getAddressObject')->willReturn($address);


        $result = $this->buildService()->toMango($user);
        $this->assertInstanceOf('MangoPay\UserNatural',$result);
        $this->assertEquals(12345, $result->Id);
        $this->assertEquals('first name value', $result->FirstName);
        $this->assertEquals('last name value', $result->LastName);
        $this->assertEquals($date->getTimestamp(), $result->Birthday);
        $this->assertEquals('email@address.com', $result->Email);
        $this->assertEquals('nationality value', $result->Nationality);
        $this->assertEquals('country value', $result->CountryOfResidence);
        $this->assertEquals('occupaton value', $result->Occupation);
        $this->assertEquals('income range value', $result->IncomeRange);
        $this->assertEquals('proof address value', $result->ProofOfAddress);
        $this->assertEquals('proof identity value', $result->ProofOfIdentity);
        $this->assertInstanceOf('MangoPay\Address', $result->Address);
        $address = $result->Address;
        $this->assertEquals('address 1 value', $address->AddressLine1);
        $this->assertEquals('address 2 value', $address->AddressLine2);
        $this->assertEquals('zip value', $address->PostalCode);
        $this->assertEquals('city value', $address->City);
        $this->assertEquals('region value', $address->Region);
        $this->assertEquals('country value', $address->Country);
    }

    public function testToMangoLegalUserWithoutAddress()
    {
        $user = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\LegalUserInterface');
        $user->expects($this->once())->method('getMangoPayId')->willReturn(12345);
        $user->expects($this->once())->method('getName')->willReturn('name value');
        $user->expects($this->once())->method('getLegalRepresentativeFirstName')->willReturn('first name value');
        $user->expects($this->once())->method('getLegalRepresentativeLastName')->willReturn('last name value');
        $date = new \DateTime('1989-03-19');
        $user->expects($this->once())->method('getLegalRepresentativeBirthday')->willReturn($date);
        $user->expects($this->once())->method('getEmail')->willReturn('email@address.com');
        $user->expects($this->once())->method('getLegalRepresentativeEmail')->willReturn('email2@address.com');
        $user->expects($this->once())->method('getLegalRepresentativeNationality')->willReturn('nationality value');
        $user->expects($this->once())->method('getLegalRepresentativeCountryOfResidence')->willReturn('country value');


        $result = $this->buildService()->toMango($user);
        $this->assertInstanceOf('MangoPay\UserLegal',$result);
        $this->assertEquals(12345, $result->Id);
        $this->assertEquals('name value', $result->Name);
        $this->assertEquals('first name value', $result->LegalRepresentativeFirstName);
        $this->assertEquals('last name value', $result->LegalRepresentativeLastName);
        $this->assertEquals($date->getTimestamp(), $result->LegalRepresentativeBirthday);
        $this->assertEquals('email@address.com', $result->Email);
        $this->assertEquals('email2@address.com', $result->LegalRepresentativeEmail);
        $this->assertEquals('nationality value', $result->LegalRepresentativeNationality);
        $this->assertEquals('country value', $result->LegalRepresentativeCountryOfResidence);
        $this->assertNull($result->HeadquartersAddress);
        $this->assertNull($result->LegalRepresentativeAddress);
    }

    public function testToMangoLegalUserWithAddressHeadQuarter()
    {
        $address = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\AddressInterface');
        $address->expects($this->once())->method('getAddress1')->willReturn('address 1 value');
        $address->expects($this->once())->method('getAddress2')->willReturn('address 2 value');
        $address->expects($this->once())->method('getPostalCode')->willReturn('zip value');
        $address->expects($this->once())->method('getCity')->willReturn('city value');
        $address->expects($this->once())->method('getRegion')->willReturn('region value');
        $address->expects($this->once())->method('getCountry')->willReturn('country value');

        $user = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\LegalUserInterface');
        $user->expects($this->once())->method('getMangoPayId')->willReturn(12345);
        $user->expects($this->once())->method('getName')->willReturn('name value');
        $user->expects($this->once())->method('getLegalRepresentativeFirstName')->willReturn('first name value');
        $user->expects($this->once())->method('getLegalRepresentativeLastName')->willReturn('last name value');
        $date = new \DateTime('1989-03-19');
        $user->expects($this->once())->method('getLegalRepresentativeBirthday')->willReturn($date);
        $user->expects($this->once())->method('getEmail')->willReturn('email@address.com');
        $user->expects($this->once())->method('getLegalRepresentativeEmail')->willReturn('email2@address.com');
        $user->expects($this->once())->method('getLegalRepresentativeNationality')->willReturn('nationality value');
        $user->expects($this->once())->method('getLegalRepresentativeCountryOfResidence')->willReturn('country value');
        $user->expects($this->once())->method('getHeadquartersAddress')->willReturn($address);


        $result = $this->buildService()->toMango($user);
        $this->assertInstanceOf('MangoPay\UserLegal',$result);
        $this->assertEquals(12345, $result->Id);
        $this->assertEquals('name value', $result->Name);
        $this->assertEquals('first name value', $result->LegalRepresentativeFirstName);
        $this->assertEquals('last name value', $result->LegalRepresentativeLastName);
        $this->assertEquals($date->getTimestamp(), $result->LegalRepresentativeBirthday);
        $this->assertEquals('email@address.com', $result->Email);
        $this->assertEquals('email2@address.com', $result->LegalRepresentativeEmail);
        $this->assertEquals('nationality value', $result->LegalRepresentativeNationality);
        $this->assertEquals('country value', $result->LegalRepresentativeCountryOfResidence);
        $this->assertInstanceOf('MangoPay\Address', $result->HeadquartersAddress);
        $this->assertNull($result->LegalRepresentativeAddress);
        $address = $result->HeadquartersAddress;
        $this->assertEquals('address 1 value', $address->AddressLine1);
        $this->assertEquals('address 2 value', $address->AddressLine2);
        $this->assertEquals('zip value', $address->PostalCode);
        $this->assertEquals('city value', $address->City);
        $this->assertEquals('region value', $address->Region);
        $this->assertEquals('country value', $address->Country);
    }

    public function testToMangoLegalUserWithAddressLegal()
    {
        $address = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\AddressInterface');
        $address->expects($this->once())->method('getAddress1')->willReturn('address 1 value');
        $address->expects($this->once())->method('getAddress2')->willReturn('address 2 value');
        $address->expects($this->once())->method('getPostalCode')->willReturn('zip value');
        $address->expects($this->once())->method('getCity')->willReturn('city value');
        $address->expects($this->once())->method('getRegion')->willReturn('region value');
        $address->expects($this->once())->method('getCountry')->willReturn('country value');

        $user = $this->getMock('UniAlteri\MangoPayBundle\Entity\Interfaces\User\LegalUserInterface');
        $user->expects($this->once())->method('getMangoPayId')->willReturn(12345);
        $user->expects($this->once())->method('getName')->willReturn('name value');
        $user->expects($this->once())->method('getLegalRepresentativeFirstName')->willReturn('first name value');
        $user->expects($this->once())->method('getLegalRepresentativeLastName')->willReturn('last name value');
        $date = new \DateTime('1989-03-19');
        $user->expects($this->once())->method('getLegalRepresentativeBirthday')->willReturn($date);
        $user->expects($this->once())->method('getEmail')->willReturn('email@address.com');
        $user->expects($this->once())->method('getLegalRepresentativeEmail')->willReturn('email2@address.com');
        $user->expects($this->once())->method('getLegalRepresentativeNationality')->willReturn('nationality value');
        $user->expects($this->once())->method('getLegalRepresentativeCountryOfResidence')->willReturn('country value');
        $user->expects($this->once())->method('getLegalRepresentativeAddress')->willReturn($address);


        $result = $this->buildService()->toMango($user);
        $this->assertInstanceOf('MangoPay\UserLegal',$result);
        $this->assertEquals(12345, $result->Id);
        $this->assertEquals('name value', $result->Name);
        $this->assertEquals('first name value', $result->LegalRepresentativeFirstName);
        $this->assertEquals('last name value', $result->LegalRepresentativeLastName);
        $this->assertEquals($date->getTimestamp(), $result->LegalRepresentativeBirthday);
        $this->assertEquals('email@address.com', $result->Email);
        $this->assertEquals('email2@address.com', $result->LegalRepresentativeEmail);
        $this->assertEquals('nationality value', $result->LegalRepresentativeNationality);
        $this->assertEquals('country value', $result->LegalRepresentativeCountryOfResidence);
        $this->assertInstanceOf('MangoPay\Address', $result->LegalRepresentativeAddress);
        $this->assertNull($result->HeadquartersAddress);
        $address = $result->LegalRepresentativeAddress;
        $this->assertEquals('address 1 value', $address->AddressLine1);
        $this->assertEquals('address 2 value', $address->AddressLine2);
        $this->assertEquals('zip value', $address->PostalCode);
        $this->assertEquals('city value', $address->City);
        $this->assertEquals('region value', $address->Region);
        $this->assertEquals('country value', $address->Country);
    }
}