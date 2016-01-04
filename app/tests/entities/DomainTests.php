<?php
/**
 * User: mcsere
 * Date: 9/4/14
 * Time: 10:59 AM
 * Contact: miki@softwareengineer.ro
 */

namespace Test\Entities;


use Test\TestCase;
use Transp\Entities\enums\Domain;

class DomainTests extends TestCase
{


    public function testDomainIs()
    {
        $this->assertTrue(Domain::is(Domain::ADMIN));
        $this->assertFalse(Domain::is(Domain::ADMIN . " asd"));
    }

    public function testDomainHasSame()
    {
        $this->assertTrue(Domain::hasSame(Domain::ADMIN . "/test", Domain::ADMIN . "/ceva"));
        $this->assertFalse(Domain::hasSame(Domain::TEST . "/test", Domain::ADMIN . "/ceva"));
        $this->assertFalse(Domain::hasSame(Domain::TEST, Domain::ADMIN));
    }

    public function testGetDomain()
    {
        $this->assertEquals(Domain::DOMAINEONE, Domain::getDomain(Domain::DOMAINEONE . "/ceva/cu/altceva"));
    }

} 