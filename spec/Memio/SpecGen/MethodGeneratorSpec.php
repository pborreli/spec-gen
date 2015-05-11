<?php

/*
 * This file is part of the memio/spec-gen package.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Memio\SpecGen;

use Memio\SpecGen\CommandBus\CommandBus;
use PhpSpec\Locator\ResourceInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MethodGeneratorSpec extends ObjectBehavior
{
    const FILE_NAME = 'src/Vendor/Project/MyClass.php';
    const CLASS_NAME = 'MyClass';
    const METHOD_NAME = 'myMethod';

    function let(CommandBus $commandBus)
    {
        $this->beConstructedWith($commandBus);
    }

    function it_is_a_generator()
    {
        $this->shouldImplement('PhpSpec\CodeGenerator\Generator\GeneratorInterface');
    }

    function it_supports_method_generation(ResourceInterface $resource)
    {
        $this->supports($resource, 'method', array())->shouldBe(true);
    }

    function it_calls_the_command_bus(CommandBus $commandBus, ResourceInterface $resource)
    {
        $resource->getSrcFilename()->willReturn(self::FILE_NAME);
        $resource->getSrcClassname()->willReturn(self::CLASS_NAME);
        $data = array(
            'name' => self::METHOD_NAME,
            'arguments' => array(),
        );

        $command = Argument::type('Memio\SpecGen\GenerateMethod\GenerateMethod');
        $commandBus->handle($command)->shouldbeCalled();

        $this->generate($resource, $data);
    }
}