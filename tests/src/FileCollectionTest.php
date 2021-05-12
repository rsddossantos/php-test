<?php

namespace Live\Collection;

use PHPUnit\Framework\TestCase;

class FileCollectionTest extends TestCase
{
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function objectCanBeConstructed()
    {
        $collection = new FileCollection();
        return $collection;
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     * @doesNotPerformAssertions
     */
    public function dataCanBeAdded()
    {
        $collection = new FileCollection();
        $collection->set('tests/files/file1', 'some content');
        $collection->set('tests/files/file1', '5000');
        $collection->set('tests/files/file1', 'Some Content !@#$%¨&*()_');
        $collection->set('tests/files/file1', '6.5');
        $collection->set('tests/files/file1', 'some content'.PHP_EOL.'with more line feed');
    }

     /**
     * @test
     * @depends dataCanBeAdded
     */
    public function dataCanBeRetrieved()
    {
        $collection = new FileCollection();
        $collection->set('tests/files/file2', 'value');

        $this->assertEquals('value', $collection->get('tests/files/file2'));
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     */
    public function inexistentIndexShouldReturnDefaultValue()
    {
        $collection = new FileCollection();

        $this->assertNull($collection->get('tests/files/file3'));
        $this->assertEquals('defaultValue', $collection->get('tests/files/file3', 'defaultValue'));
    }

    /**
     * @test
     * @depends objectCanBeConstructed
     */
    public function newCollectionShouldNotContainItems()
    {
        $collection = new FileCollection();
        $this->assertEquals(0, $collection->count());
    }

    /**
     * @test
     * @depends dataCanBeAdded
     */
    public function collectionWithItemsShouldReturnValidCount()
    {
        $collection = new FileCollection();
        $collection->set('tests/files/file4', 'value');
        $collection->set('tests/files/file4', '5');
        $collection->set('tests/files/file4', 'true');

        $this->assertEquals(3, $collection->count());
    }

    /**
     * @test
     * @depends collectionWithItemsShouldReturnValidCount
     */
    public function collectionCanBeCleaned()
    {
        $collection = new FileCollection();
        $collection->set('tests/files/file5', 'value');
        $this->assertEquals(1, $collection->count());

        $collection->clean();
        $this->assertEquals(0, $collection->count());
    }

    /**
     * @test
     * @depends dataCanBeAdded
     */
    public function addedItemShouldExistInCollection()
    {
        $collection = new FileCollection();
        $collection->set('tests/files/file6', 'value');

        $this->assertTrue($collection->has('tests/files/file6'));
    }
}
