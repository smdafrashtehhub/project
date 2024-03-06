<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MongoDB\Client as Mongo;

class MongoDbController extends Controller
{
    public function mongodb()
    {
        $mongo=new Mongo;
        $empcollection=$mongo->laravel->ok;
        $empcollection->updateOne(
           ['age'=>'38'],
            ['$set'=>['name'=>'samad','age'=>'34']]
        );
//        $empcollection->find([
//           'age'=>'34',
//        ]);
//        var_dump($empcollection);
        $insertOneResult=$empcollection->insertOne([
           'name'=>'bahram',
            'family'=>'sari',
            'age'=>34
        ]);
//        dd($insertOneResult->getInsertedId());
//        $mongo->p;
//        $connection=$mongo->homestead->dropCollection('ok');
//        foreach ($mongo->homestead->listCollections() as $collect);
//        print_r($collect->getName());
//        dd($connection->find()->toArray());
    }
}
