<?php

declare(strict_types=1);

namespace Algorithm\BinaryTree;

class Node {
    public $data;
    public $left;
    public $right;

    public function __construct(int $data = NULL, ?Node $left = NULL, ?Node $right = NULL) {
        $this->data = $data;
        $this->left = $left;
        $this->right = $right;
    }
}