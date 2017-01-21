<?php

namespace App\GraphQL\Type;

use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class ExpType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Exp',
        'description' => 'An work experience'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The unique identifier'
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the owning user'
            ],
            'parent_id' => [
                'type' => Type::int(),
                'description' => 'The parent exp id'
            ],
            'next_id' => [
                'type' => Type::int(),
                'description' => 'The next exp id'
            ],
            'type' => [
                'type' => Type::string(),
                'description' => 'Project or contribution'
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title of the work experience'
            ],
            'subtitle' => [
                'type' => Type::string(),
                'description' => 'A concise, descriptive phrase'
            ],
            'summary' => [
                'type' => Type::string(),
                'description' => 'A summary paragraph'
            ],
        ];
    }
}