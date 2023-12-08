<?php

declare(strict_types=1);

namespace Algorithm\BinaryTree;

class Tree {
    public $root;

    public function __construct(Node $root = null) {
        $this->root = $root;
    }

    public function insert($data, string $direction = null) {
        if ($this->root === null) {
            $this->root = new Node($data);
        } else {
            $this->insertNode($data, $this->root, $direction);
        }
    }

    protected function insertNode($data, Node &$node, string $direction = null) {
        if ($direction === 'left') {
            if ($node->left === null) {
                $node->left = new Node($data);
            } else {
                $this->insertNode($data, $node->left, $direction);
            }
        } elseif ($direction === 'right') {
            if ($node->right === null) {
                $node->right = new Node($data);
            } else {
                $this->insertNode($data, $node->right, $direction);
            }
        } else {
            if ($data < $node->data) {
                if ($node->left === null) {
                    $node->left = new Node($data);
                } else {
                    $this->insertNode($data, $node->left, $direction);
                }
            } elseif ($data > $node->data) {
                if ($node->right === null) {
                    $node->right = new Node($data);
                } else {
                    $this->insertNode($data, $node->right, $direction);
                }
            }
        }
    }

    public function findFromRoot($data)
    {
        return $this->findNode($data, $this->root);
    }

    protected function findNode($data, Node $node = null)
    {
        if ($node === null) {
            return null;
        }

        if ($data == $node->data) {
            return $node;
        }

        $left = $this->findNode($data, $node->left);
        if ($left !== null) {
            return $left;
        }

        $right = $this->findNode($data, $node->right);
        if ($right !== null) {
            return $right;
        }

        return null;
    }
}