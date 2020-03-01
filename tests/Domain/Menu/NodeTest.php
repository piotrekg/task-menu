<?php

declare(strict_types=1);

namespace Tests\Domain\Menu;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Task\Domain\Menu\Exception\MaxChildrenNonPositive;
use Task\Domain\Menu\Exception\MaxDepthNonPositive;
use Task\Domain\Menu\Exception\ReachedMaxChildrenLimit;
use Task\Domain\Menu\Exception\ReachedMaxDepthLimit;
use Task\Domain\Menu\Node;

class NodeTest extends TestCase
{
    public function testCreate()
    {
        // given
        $nodeId = Uuid::uuid4();
        $name = 'Test one';
        $maxDepth = 1;
        $maxChildren = 1;

        // when
        $node = Node::create($nodeId, $name, $maxDepth, $maxChildren);

        // then
        $this->assertEquals($nodeId, $node->nodeId());
        $this->assertEquals($name, $node->name());
        $this->assertEquals([], $node->children());
        $this->assertEquals($maxDepth, $node->maxDepth());
        $this->assertEquals($maxChildren, $node->maxChildren());
    }

    public function testCreateWithMaxDepthNonPositive()
    {
        // given
        $nodeId = Uuid::uuid4();
        $name = 'Test one';
        $maxDepth = -10;
        $maxChildren = 1;

        // then
        $this->expectException(MaxDepthNonPositive::class);

        // when
        Node::create($nodeId, $name, $maxDepth, $maxChildren);
    }

    public function testCreateWithMaxChildrenNonPositive()
    {
        // given
        $nodeId = Uuid::uuid4();
        $name = 'Test one';
        $maxDepth = 1;
        $maxChildren = -1;

        // then
        $this->expectException(MaxChildrenNonPositive::class);

        // when
        Node::create($nodeId, $name, $maxDepth, $maxChildren);
    }

    public function testAddChildren()
    {
        // given
        $root = 'Test root';
        $children = 'Test children';

        // when
        $node = Node::create(Uuid::uuid4(), $root);
        $node->add(Uuid::uuid4(), $children);

        // then
        $this->assertEquals($root, $node->name());
        $this->assertEquals(1, \count($node->children()));
        $this->assertEquals($children, $node->children()[0]->name());
    }

    public function testAddChildrenWithReachedMaxChildrenLimit()
    {
        // given
        $root = 'Test root';
        $children = 'Test children';

        // then
        $this->expectException(ReachedMaxChildrenLimit::class);

        // when
        $node = Node::create(Uuid::uuid4(), $root, 10, 1);
        $node->add(Uuid::uuid4(), $children);
        $node->add(Uuid::uuid4(), $children);
    }

    public function testAddChildrenWithReachedMaxDepthLimit()
    {
        // given
        $root = 'Test root';
        $children = 'Test children';

        // then
        $this->expectException(ReachedMaxDepthLimit::class);

        // when
        $node = Node::create(Uuid::uuid4(), $root, 1, 10);
        $secNode = $node->add(Uuid::uuid4(), $children);
        $thirdNode = $secNode->add(Uuid::uuid4(), $children);
        $thirdNode->add(Uuid::uuid4(), $children);
    }
}
