<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2016 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWord\Shared;

/**
 * Test class for PhpOffice\PhpWord\Shared\Converter
 *
 * @coversDefaultClass \PhpOffice\PhpWord\Shared\Converter
 */
class ConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test unit conversion functions with various numbers
     */
    public function testUnitConversions()
    {
        $values[] = 0; // zero value
        $values[] = rand(1, 100) / 100; // fraction number
        $values[] = rand(1, 100); // integer

        foreach ($values as $value) {
            $result = Converter::cmToTwip($value);
            $this->assertEquals($value / 2.54 * 1440, $result);

            $result = Converter::cmToInch($value);
            $this->assertEquals($value / 2.54, $result);

            $result = Converter::cmToPixel($value);
            $this->assertEquals($value / 2.54 * 96, $result);

            $result = Converter::cmToPoint($value);
            $this->assertEquals($value / 2.54 * 72, $result);

            $result = Converter::cmToEmu($value);
            $this->assertEquals(round($value / 2.54 * 96 * 9525), $result);

            $result = Converter::inchToTwip($value);
            $this->assertEquals($value * 1440, $result);

            $result = Converter::inchToCm($value);
            $this->assertEquals($value * 2.54, $result);

            $result = Converter::inchToPixel($value);
            $this->assertEquals($value * 96, $result);

            $result = Converter::inchToPoint($value);
            $this->assertEquals($value * 72, $result);

            $result = Converter::inchToEmu($value);
            $this->assertEquals(round($value * 96 * 9525), $result);

            $result = Converter::pixelToTwip($value);
            $this->assertEquals($value / 96 * 1440, $result);

            $result = Converter::pixelToCm($value);
            $this->assertEquals($value / 96 * 2.54, $result);

            $result = Converter::pixelToPoint($value);
            $this->assertEquals($value / 96 * 72, $result);

            $result = Converter::pixelToEMU($value);
            $this->assertEquals(round($value * 9525), $result);

            $result = Converter::pointToTwip($value);
            $this->assertEquals($value * 20, $result);

            $result = Converter::pointToPixel($value);
            $this->assertEquals($value / 72 * 96, $result);

            $result = Converter::pointToEMU($value);
            $this->assertEquals(round($value / 72 * 96 * 9525), $result);

            $result = Converter::emuToPixel($value);
            $this->assertEquals(round($value / 9525), $result);

            $result = Converter::degreeToAngle($value);
            $this->assertEquals((int)round($value * 60000), $result);

            $result = Converter::angleToDegree($value);
            $this->assertEquals(round($value / 60000), $result);
        }
    }

    /**
     * Test htmlToRGB()
     */
    public function testHtmlToRGB()
    {
        // Prepare test values [ original, expected ]
        $values[] = array('#FF99DD', array(255, 153, 221)); // With #
        $values[] = array('FF99DD', array(255, 153, 221)); // 6 characters
        $values[] = array('F9D', array(255, 153, 221)); // 3 characters
        $values[] = array('0F9D', false); // 4 characters
        // Conduct test
        foreach ($values as $value) {
            $result = Converter::htmlToRGB($value[0]);
            $this->assertEquals($value[1], $result);
        }
    }

    /**
     * @covers ::cssToPixel
     * @test
     */
    public function testCssToPixel()
    {
        // Prepare test values [ original, expected ]
        $values[] = array('1pt', (1 / 72) * 96);
        $values[] = array('10.5pc', (10.5 / (72 * 12)) * 96);
        $values[] = array('4cm', (4 / 2.54) * 96);
        $values[] = array('1', (1 / 2.54) * 96);
        $values[] = array('2mm', (0.2 / 2.54) * 96);
        $values[] = array('.1', (0.1 / 2.54) * 96);
        $values[] = array('2in', 2 * 96);
        foreach ($values as $value) {
            $result = Converter::cssToPixel($value[0]);
            $this->assertEquals($value[1], $result);
        }
    }

    /**
     * @covers ::cssToEmu
     * @test
     */
    public function testCssToEmu()
    {
        // Prepare test values [ original, expected ]
        $values[] = array('1pt', (1 / 72) * 96 * 9525);
        $values[] = array('10.5pc', (10.5 / (72 * 12)) * 96 * 9525);
        $values[] = array('4cm', (4 / 2.54) * 96 * 9525);
        $values[] = array('1', (1 / 2.54) * 96 * 9525);
        $values[] = array('2mm', (0.2 / 2.54) * 96 * 9525);
        $values[] = array('.1', (0.1 / 2.54) * 96 * 9525);
        $values[] = array('2in', 2 * 96 * 9525);
        foreach ($values as $value) {
            $result = Converter::cssToEmu($value[0]);
            $this->assertEquals($value[1], $result);
        }
    }

    /**
     * @covers ::cssToCm
     * @test
     */
    public function testCssToCm()
    {
        // Prepare test values [ original, expected ]
        $values[] = array('1pt', (1 / 72) * 2.54);
        $values[] = array('10.5pc', (10.5 / (72 * 12)) * 2.54);
        $values[] = array('4cm', 4);
        $values[] = array('1', 1);
        $values[] = array('2mm', 2 / 10);
        $values[] = array('.1', 1 / 10);
        $values[] = array('2in', 2 * 2.54);
        foreach ($values as $value) {
            $result = Converter::cssToCm($value[0]);
            $this->assertEquals($value[1], $result);
        }
    }

    /**
     * @covers ::cssToTwip
     * @test
     */
    public function testCssToTwip()
    {
        // Prepare test values [ original, expected ]
        $values[] = array('1pt', (1 / 72) * 1440);
        $values[] = array('10.5pc', (10.5 / (72 * 12)) * 1440);
        $values[] = array('4cm', (4 / 2.54) * 1440);
        $values[] = array('1', (1 / 2.54) * 1440);
        $values[] = array('2mm', (0.2 / 2.54) * 1440);
        $values[] = array('.1', (0.1 / 2.54) * 1440);
        $values[] = array('2in', 2 * 1440);
        foreach ($values as $value) {
            $result = Converter::cssToTwip($value[0]);
            $this->assertEquals($value[1], $result);
        }
    }
}
