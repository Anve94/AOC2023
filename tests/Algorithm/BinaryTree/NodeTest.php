<?php

declare(strict_types=1);

namespace App\Test\Algorithm\BinaryTree;

use Algorithm\BinaryTree\Node;
use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    public function testNodeValue(): void
    {
        $node = new Node(5);
        $this->assertEquals(5, $node->data);
    }

    public function testNodeLeftChild(): void
    {
        $node = new Node(5);
        $child = new Node(3);
        $node->left = $child;
        $this->assertSame($child, $node->left);
    }

    public function testNodeRightChild(): void
    {
        $node = new Node(5);
        $child = new Node(7);
        $node->right = $child;
        $this->assertSame($child, $node->right);
    }
}