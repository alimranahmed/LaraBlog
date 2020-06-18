<?php

return [
    'roles' => ['owner', 'admin', 'author', 'reader'],

    'permissions' => [
        'article-read' => ['admin'],
        'article-create' => ['admin'],
        'article-edit' => ['admin'],
        'article-delete' => ['admin'],
        'category-read' => ['admin'],
        'category-create' => ['admin'],
        'category-edit' => ['admin'],
        'category-delete' => ['admin'],
        'comment-read' => ['admin'],
        'comment-create' => ['admin'],
        'comment-edit' => ['admin'],
        'comment-delete' => ['admin'],
        'keyword-read' => ['admin'],
        'keyword-create' => ['admin'],
        'keyword-edit' => ['admin'],
        'keyword-delete' => ['admin'],
    ]
];
