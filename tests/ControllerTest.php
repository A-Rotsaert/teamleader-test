<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * @covers DefaultController
 *
 * @author <andy.rotsaert@live.be>
 */
final class ControllerTest extends TestCase
{
    /**
     * @covers DefaultController::index
     *
     * Actually the only thing it covers is phpunit "working",
     * it actually doesn't test anything at all, sorry :)
     */
    public function testIndex(): void
    {
        $stack = [];
        $this->assertSame(0, count($stack));

        array_push($stack, 'foo');
        $this->assertSame('foo', $stack[count($stack) - 1]);
        $this->assertSame(1, count($stack));

        $this->assertSame('foo', array_pop($stack));
        $this->assertSame(0, count($stack));
    }
}
