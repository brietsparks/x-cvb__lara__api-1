<?php

namespace App\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Models\Exp;

class ExpsMutation extends Mutation
{

    protected $attributes = [
        'name' => 'createExp'
    ];

    public function type()
    {
        return GraphQL::type('Exp');
    }

    public function args()
    {
        return [
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::nonNull(Type::int())
            ],

            'title' => [
                'name' => 'title',
                'type' => Type::nonNull(Type::string())
            ],

            'subtitle' => [
                'name' => 'subtitle',
                'type' => Type::nonNull(Type::string())
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return 1;
    }

}