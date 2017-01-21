<?php

namespace App\GraphQL\Query;

use App\Models\Exp;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;

class ExpsQuery extends Query
{
    protected $attributes = [
        'name' => 'exps'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Exp'));
    }

    public function args()
    {
        return [
            'user_id' => ['name' => 'user_id', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return Exp::where('id', $args['id'])->get();
        } else {
            return Exp::all();
        }
    }

}


//    /**
//     * @var ExpService
//     */
//    protected $service;
//
//    /**
//     * ExpsQuery constructor.
//     * @param array $attributes
//     * @param ExpService $service
//     */
//    public function __construct($attributes = [], ExpService $service)
//    {
//        parent::__construct($attributes);
//
//        $this->service = $service;
//    }
