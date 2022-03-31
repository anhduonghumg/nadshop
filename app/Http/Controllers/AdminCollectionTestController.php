<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use App\Models\Invoice;
use App\Models\M_user;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;

class AdminCollectionTestController extends Controller
{
    public function test()
    {
        #.===========TẠO COLLECTION ======================

        // $collection = collect(['taylor', 'abigail', null])->map(function ($name) {
        //     return strtoupper($name);
        // })->reject(function ($name) {
        //     return empty($name);
        // });

        // sử dụng helper collect
        // $collection = collect([1, 2, 3]);

        // sử dụng new Collection
        // $collection = new Collection(['số 1' => '1', 'số 2' => '2', 'só 3' => '3']);

        // sử dụng make::collection
        // $collection = Collection::make([1, 2, 3]);

        #.=========== METHODS COLLECTION ===============
        // all()
        // $collection = collect(['no 1' => '1', 'no 2' => '2', 'no 3' => '3']);
        // $collection->all();

        // avg()
        // 1 chiều
        // $average = collect(['no 1' => 1, 'no 2' => 2, 'no 3' => 3])->avg();
        // đa chiều
        // $average_2 = collect([
        //     ['foo' => 10],
        //     ['foo' => 10],
        //     ['foo' => 20],
        //     ['foo' => 40]
        // ])->avg('foo');

        // chuck()
        // $collection = collect([1, 2, 3, 4, 5, 6, 7]);
        // $chunks = $collection->chunk(2);
        // $chunks->all();

        // chuckWhile()
        // $collection = collect(str_split('AABBCCCD'));
        // $chunks = $collection->chunkWhile(function ($value, $key, $chunk) {
        //     return $value === $chunk->last();
        // });
        // $chunks->all();

        //collapse()
        // $collection = collect([
        //     [1, 2, 3],
        //     [4, 5, 6],
        //     [7, 8, 9],
        // ]);
        // $collapse = $collection->collapse();

        //combine()
        // $collection = collect(['name', 'age']);
        // $combined = $collection->combine(['George', 29]);
        // $combined->all();

        // concat()
        // $collection = collect(['name' => 'John Doe']);
        // $concatenated = $collection->concat(['age' => 18]);
        // $concatenated->all();

        // contains()
        // $collection = collect(['name' => 'Desk', 'price' => 100]);
        // if ($collection->contains('Desk')) {
        //     return 'hello';
        // } else {
        //     return 'No data';
        // }

        // countBy()
        // $collection = collect([1, 2, 2, 2, 3]);
        // $counted = $collection->countBy();
        // $counted->all();

        // $collection = collect(['alice@gmail.com', 'bob@yahoo.com', 'carlos@gmail.com']);
        // $counted = $collection->countBy(function ($email) {
        //     return substr(strrchr($email, "@"), 1);
        // });
        // $counted->all();

        // diff()
        // $collection_1 = collect([1, 2, 3, 4, 5]);
        // $collection_2 = collect([2, 3, 4]);
        // $diff = $collection_1->diff($collection_2);
        // $diff->all();

        // every()
        // $students = collect([2, 4, 1]);
        // $pointGreatThanFive = $students->every(function ($student, $key) {
        //     return  $student % 2 == 0;
        // });

        // except()
        // $collection = collect(['product_id' => 1, 'price' => 100, 'discount' => false]);
        // $filtered = $collection->except(['price', 'discount']);
        // $filtered->all();

        // filter()
        // $collection = collect([1, 2, 3, 4]);
        // $filtered = $collection->filter(function ($value, $key) {
        //     return $value > 2;
        // });

        // first()
        // $collection = collect([1, 2, 3, 4])->first(function ($value, $key) {
        //     return $value > 2;
        // });

        // $collection = collect([
        //     'name' => 'taylor',
        //     'languages' => [
        //         'php', 'javascript'
        //     ]
        // ]);

        // $flattened = $collection->flatten();
        // $flattened->all();

        // forget()
        // $collection = collect(['name' => 'taylor', 'framework' => 'laravel']);
        // $collection->forget('name');
        // $collection->all();

        // groupBy
        // $collection = collect([
        //     ['account_id' => 'account-x10', 'product' => 'Chair'],
        //     ['account_id' => 'account-x10', 'product' => 'Bookcase'],
        //     ['account_id' => 'account-x11', 'product' => 'Desk'],
        // ]);
        // $grouped = $collection->groupBy('account_id');
        // $grouped->all();
        // $grouped = $collection->groupBy(function ($item, $key) {
        //     return substr($item['account_id'], -3);
        // });

        // $data = new Collection([
        //     10 => ['user' => 1, 'skill' => 1, 'roles' => ['Role_1', 'Role_3']],
        //     20 => ['user' => 2, 'skill' => 1, 'roles' => ['Role_1', 'Role_2']],
        //     30 => ['user' => 3, 'skill' => 2, 'roles' => ['Role_1']],
        //     40 => ['user' => 4, 'skill' => 2, 'roles' => ['Role_2']],
        // ]);
        // $result = $data->groupBy(['skill', function ($item) {
        //     return $item['roles'];
        // }], $preserveKeys = true);


        // map
        // $collection = collect([1, 2, 3, 4, 5]);
        // $multiplied = $collection->map(function ($item, $key) {
        //     return $item * 2;
        // });

        // $multiplied->all();

        // mapSpread
        // $collection = collect([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
        // $chunks = $collection->chunk(2);
        // $sequence = $chunks->mapSpread(function ($even, $odd) {
        //     return $even + $odd;
        // });
        // $sequence->all();

        // $collection = collect([2, 4, 6, 8])->search(function ($item, $key) {
        //     return $item > 5;
        // });

        // $collection = collect(['taylor', 'abigail', null])->map(function ($name) {
        //     return strtoupper($name);
        // })->reject(function ($name) {
        //     return empty($name);
        // });

        #.========================Lazy Collection================
        // $lazyCollection = LazyCollection::times(INF)
        //     ->takeUntilTimeout(now()->addMinute());
        // $lazyCollection->each(function ($number) {
        //     dump($number);

        //     sleep(1);
        // });

        // $lazyCollection = LazyCollection::times(INF)->tapEach(function ($value) {
        //     dump($value);
        // });
        // $users = M_User::cursor()->remember();


        // $users->take(5)->all();

        // First 5 users come from the collection's cache...
        // The rest are hydrated from the database...
        // $users->take(20)->all();
        // dd($users);
        // echo $collection_1;
        // print_r($chunks);

        $array = Arr::add(['name' => 'Desk', 'price' => '123'], 'price', 100);
        dd($array);
    }
}
