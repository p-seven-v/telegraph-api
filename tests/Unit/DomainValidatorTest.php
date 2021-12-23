<?php

declare(strict_types=1);

namespace Tests\Unit;

use Assert\AssertionFailedException;
use P7v\TelegraphApi\DomainValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \P7v\TelegraphApi\DomainValidator
 */
class DomainValidatorTest extends TestCase
{
    private DomainValidator $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new DomainValidator();
    }

    /**
     * @test
     *
     * @dataProvider validShortNames
     */
    public function it_validates_short_name(string $name): void
    {
        $this->sut->validateShortName($name);

        $this->addToAssertionCount(1);
    }

    /**
     * @test
     *
     * @dataProvider invalidShortNames
     */
    public function it_throws_exception_on_invalid_short_name(string $name): void
    {
        $this->expectException(AssertionFailedException::class);

        $this->sut->validateShortName($name);
    }
    
    /**
     * @test
     *
     * @dataProvider validAuthorNames
     */
    public function it_validates_author_name(string $name): void
    {
        $this->sut->validateAuthorName($name);

        $this->addToAssertionCount(1);
    }

    /**
     * @test
     *
     * @dataProvider invalidAuthorNames
     */
    public function it_throws_exception_on_invalid_author_name(string $name): void
    {
        $this->expectException(AssertionFailedException::class);

        $this->sut->validateAuthorName($name);
    }

    public function validShortNames(): array
    {
        return [
            '1 character' => ['1'],
            '12 characters' => ['12characters'],
            '32 characters' => ['32characters short name abcdefgh'],
        ];
    }

    public function invalidShortNames(): array
    {
        return [
            'empty short name' => [''],
            '33 characters' => ['aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'],
        ];
    }

    public function validAuthorNames(): array
    {
        return [
            '1 character' => ['1'],
            '12 characters' => ['12characters'],
            '128 characters' => ['bf8e57b40f16819fae2439593a83600a43ed040295004dd4725c4326d580419c9f502ed00f4e82df6690dbe1584f7f5c9f09bbc6fe5297eca6c5408d8eaf7681'],
        ];
    }

    public function invalidAuthorNames(): array
    {
        return [
            'empty author name' => [''],
            '129 characters' => ['bf8e57b40f16819fae2439593a83600a43ed040295004dd4725c4326d580419c9f502ed00f4e82df6690dbe1584f7f5c9f09bbc6fe5297eca6c5408d8eaf76810'],
        ];
    }
}
