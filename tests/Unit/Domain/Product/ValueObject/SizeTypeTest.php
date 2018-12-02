<?php

namespace Tests\Unit\Domain\Product\ValueObject;

use Lash\Domain\Product\ValueObject\Size;
use Tests\TestCase;

class SizeTypeTest extends TestCase
{
    /**
     * @expectedException \Lash\Domain\Product\Exception\WrongSizeException
     */
    public function testExceptionOnWrongSize(): void
    {
        new Size('123wefsd11@$%ˆ');
    }

    public function testVOEquality(): void
    {
        $size1 = new Size(Size::L);
        $size2 = new Size(Size::L);

        self::assertTrue($size1->equals($size2));
    }

    public function testVONotEqual(): void
    {
        $size1 = new Size(Size::XS);
        $size2 = new Size(Size::S);

        self::assertFalse($size1->equals($size2));
    }

    public function testStringValue(): void
    {
        $size = new Size(Size::XS);

        self::assertSame(Size::XS, $size->toString());
    }

    public function testSizeIsValid(): void
    {
        $this->assertTrue(Size::isValid(Size::XXL));
    }

    public function testSizeIsInvalid(): void
    {
        $this->assertFalse(Size::isValid('1234dghfyh%ˆˆ'));
    }

    public function testAllSizedCount(): void
    {
        $this->assertCount(8, Size::getAll());
    }
}
