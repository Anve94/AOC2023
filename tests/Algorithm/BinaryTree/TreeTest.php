<?php

namespace App\Test\Algorithm\BinaryTree;

use Algorithm\BinaryTree\Tree;
use Algorithm\BinaryTree\Node;
use PHPUnit\Framework\TestCase;

class TreeTest extends TestCase
{
    public function testInsertAndFindFromRoot(): void
    {
        $tree = new Tree();
        // insert the root
        $tree->insert(5);

        // insert other nodes
        $tree->insert(1, 'left');
        $tree->insert(8, 'right');
        $tree->insert(3, 'left');
        $tree->insert(7, 'right');

        // assertions
        $this->assertEquals(5, $tree->root->data);
        $this->assertEquals(1, $tree->root->left->data);
        $this->assertEquals(8, $tree->root->right->data);

        // check if the findFromRoot function works
        $foundNode = $tree->findFromRoot(3);
        $this->assertNotNull($foundNode);
        $this->assertEquals(3, $foundNode->data);

        // check for a non-existent node
        $foundNode = $tree->findFromRoot(10);
        $this->assertNull($foundNode);
    }

    public function testDepthFourTreeAndFindNode(): void
    {
        $root = new Node(8);
        $tree = new Tree($root);

        // create nodes in unranked order
        $tree->insert(1, 'left');
        $tree->insert(2, 'right');
        $tree->insert(3, 'left');
        $tree->insert(4, 'right');
        $tree->insert(5, 'left');
        $tree->insert(6, 'right');

        // check for nodes
        $foundNode = $tree->findFromRoot(6);
        $this->assertNotNull($foundNode);
        $this->assertEquals(6, $foundNode->data);

        // check for a non-existent node
        $foundNode = $tree->findFromRoot(24);
        $this->assertNull($foundNode);
    }
}