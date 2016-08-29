<?php
/**
 * MIT License
 *
 * Copyright (c) 2016 Constantin Galbenu gica.galbenu@gmail.com
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace tests\Gica\Xss;


class ObjectDecoratorTest extends \PHPUnit_Framework_TestCase
{

    public function test_dataIsNotModified()
    {
        $objVal = new \stdClass();
        $objVal->a = 'b';

        $date = new \DateTime();

        $object = new SomeObject("a1 b2", 11, $objVal, $date);

        /** @var SomeObject $decorated */
        $decorated = new \Gica\Xss\ObjectDecorator($object);

        $this->assertSame("a1 b2", $decorated->getStrVal());
        $this->assertSame(11, $decorated->getIntVal());
        $this->assertSame($objVal, $decorated->getObjVal());
        $this->assertSame($date, $decorated->getDate());
    }

    public function test_withForbiddenData()
    {
        $objVal = new \stdClass();
        $objVal->a = 'b';

        $date = new \DateTime();

        $object = new SomeObject("a1 b2<script>", 11, $objVal, $date);

        /** @var SomeObject $decorated */
        $decorated = new \Gica\Xss\ObjectDecorator($object);

        $this->assertSame("a1 b2&lt;script&gt;", $decorated->getStrVal());
        $this->assertSame(11, $decorated->getIntVal());
        $this->assertSame($objVal, $decorated->getObjVal());
        $this->assertSame($date, $decorated->getDate());
    }
}

class SomeObject
{
    /** @var  string */
    private $strVal;
    /** @var  int */
    private $intVal;
    /** @var object */
    private $objVal;
    /** @var  \DateTime */
    private $date;

    /**
     * SomeObject constructor.
     * @param string $strVal
     * @param int $intVal
     * @param object $objVal
     * @param \DateTime $date
     */
    public function __construct(string $strVal, int $intVal, $objVal, \DateTime $date)
    {
        $this->strVal = $strVal;
        $this->intVal = $intVal;
        $this->objVal = $objVal;
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getStrVal(): string
    {
        return $this->strVal;
    }

    /**
     * @return int
     */
    public function getIntVal(): int
    {
        return $this->intVal;
    }

    /**
     * @return object
     */
    public function getObjVal()
    {
        return $this->objVal;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }


}