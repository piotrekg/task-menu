<?php

declare(strict_types=1);

namespace Task\Domain\Menu;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Ramsey\Uuid\UuidInterface;
use Task\Domain\Menu\Exception\MaxChildrenNonPositive;
use Task\Domain\Menu\Exception\MaxDepthNonPositive;
use Task\Domain\Menu\Exception\ReachedMaxChildrenLimit;
use Task\Domain\Menu\Exception\ReachedMaxDepthLimit;

class Node
{
    private UuidInterface $nodeId;

    private string $name;

    /**
     * @var Node[]
     */
    private array $children;

    private int $depth;

    private int $maxDepth;

    private int $maxChildren;

    private function __construct(
        UuidInterface $nodeId,
        string $name,
        array $children,
        int $depth,
        int $maxDepth,
        int $maxChildren
    ) {
        $this->nodeId = $nodeId;
        $this->name = $name;
        $this->children = $children;
        $this->depth = $depth;
        $this->maxDepth = $maxDepth;
        $this->maxChildren = $maxChildren;
    }

    /**
     * @throws MaxDepthNonPositive
     * @throws MaxChildrenNonPositive
     */
    private static function new(
        UuidInterface $nodeId,
        string $name,
        int $depth,
        int $maxDepth,
        int $maxChildren
    ): self {
        try {
            Assertion::min($maxDepth, 0);
        } catch (AssertionFailedException $e) {
            throw new MaxDepthNonPositive($nodeId, $maxDepth);
        }

        try {
            Assertion::min($maxChildren, 0);
        } catch (AssertionFailedException $e) {
            throw new MaxChildrenNonPositive($nodeId, $maxChildren);
        }

        return new self($nodeId, $name, [], $depth, $maxDepth, $maxChildren);
    }

    /**
     * @throws MaxDepthNonPositive
     * @throws MaxChildrenNonPositive
     */
    public static function create(
        UuidInterface $nodeId,
        string $name,
        int $maxDepth = 5,
        int $maxChildren = 5
    ): self {
        return Node::new($nodeId, $name, 0, $maxDepth, $maxChildren);
    }

    /**
     * @throws ReachedMaxChildrenLimit
     */
    public function add(
        UuidInterface $nodeId,
        string $name,
        int $maxDepth = null,
        int $maxChildren = null
    ): self {
        try {
            Assertion::maxCount($this->children(), $this->maxChildren() - 1);
        } catch (AssertionFailedException $e) {
            throw new ReachedMaxChildrenLimit($nodeId, $this->maxChildren());
        }

        try {
            Assertion::lessOrEqualThan($this->depth, $this->maxDepth());
        } catch (AssertionFailedException $e) {
            throw new ReachedMaxDepthLimit($nodeId, $this->maxDepth());
        }

        // check depth
        $node = Node::new(
            $nodeId,
            $name,
            $this->depth + 1,
            $maxDepth ?? $this->maxDepth() - 1,
            $maxChildren ?? $this->maxChildren()
        );

        $this->children[] = $node;

        return $node;
    }

    public function nodeId(): UuidInterface
    {
        return $this->nodeId;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return Node[]
     */
    public function children(): array
    {
        return $this->children;
    }

    public function maxDepth(): int
    {
        return $this->maxDepth;
    }

    public function maxChildren(): int
    {
        return $this->maxChildren;
    }
}
