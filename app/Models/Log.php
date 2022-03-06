<?php


namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Log extends Model
{


    protected $fillable = ['error'];

    protected $connection = 'mongodb';
    protected $collection = 'my_books_collection';
}
