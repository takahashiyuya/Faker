<?php

namespace Faker\Test\Provider\ja_JP;

use Faker\Generator;
use Faker\Provider\ja_JP\Address;

class AddressTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Address($faker));
        $this->faker = $faker;
    }

    public function testPostCode1IsValid()
    {
        $main = '[0-9]{3}';
        $pattern = "/^($main)$/";
        $postcode = $this->faker->postcode1();
        $this->assertSame(preg_match($pattern, $postcode), 1, $postcode);
    }

    public function testBeforePost2CodeIsValid()
    {
        $main = '[0-9]{4}';
        $pattern = "/^($main)$/";
        $postcode = $this->faker->postcode2();
        $this->assertSame(preg_match($pattern, $postcode), 1, $postcode);
    }

    public function testPostCodeIsValid()
    {
        $main = '[0-9]{7}';
        $pattern = "/^($main)$/";
        $postcode = $this->faker->postcode();
        $this->assertSame(preg_match($pattern, $postcode), 1, $postcode);
    }

    public function testPrefectureIsValid()
    {
        $prefectureProp = (new \ReflectionClass('\Faker\Provider\ja_JP\Address'))->getProperty('prefecture');
        $prefectureProp->setAccessible(true);
        $prefectures = $prefectureProp->getValue();
        $prefecture = $this->faker->prefecture();
        $this->assertTrue(in_array($prefecture, $prefectures));
    }

    public function testWardIsValid()
    {
        $wardProp = (new \ReflectionClass('\Faker\Provider\ja_JP\Address'))->getProperty('ward');
        $wardProp->setAccessible(true);
        $wardSuffixProp = (new \ReflectionClass('\Faker\Provider\ja_JP\Address'))->getProperty('wardSuffix');
        $wardSuffixProp->setAccessible(true);
        $wardSuffix = $wardSuffixProp->getValue()[0];
        $wards = array_map(function ($ward) use ($wardSuffix) {
            return $ward . $wardSuffix; // Example: return '中央' . '区'
        }, $wardProp->getValue());
        $ward = $this->faker->ward();
        $this->assertTrue(in_array($ward, $wards));
    }

    public function testAreaNumberIsValid()
    {
        $areaNumber = $this->faker->areaNumber();
        $this->assertTrue(is_int($areaNumber));
    }

    public function testBuildingNumberIsValid()
    {
        $buildingNumber = $this->faker->buildingNumber();
        $this->assertTrue(is_int($buildingNumber));
    }

    public function testSecondaryAddressIsValid()
    {
        $secondaryAddress = $this->faker->secondaryAddress();
        $this->assertTrue(is_string($secondaryAddress));
    }

}
