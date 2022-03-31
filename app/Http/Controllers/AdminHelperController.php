<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;


class AdminHelperController extends Controller

{
    public function array()
    {
        #. array_add
        // $array = Arr::add(['name' => 'Desk'], 'price', 100);
        // $array = Arr::add(['name' => 'Desk', 'price' => null], 'price', 50);

        #. array_collapse
        // $array_1 = [1, 2, 3];
        // $array_2 = [4, 5, 6];
        // $array = Arr::collapse([$array_1, $array_2]);

        #. array_divide
        // $divide =  list($keys, $values) = Arr::divide(['name' => 'Desk']);

        #. array_dot
        // $array = ['products' => ['desk' => ['price' => 100]]];
        // $flattened = Arr::dot($array);

        #.array_except
        // $array = ['name' => 'Desk', 'price' => 100];
        // $filtered = Arr::except($array, ['price']);

        #.array_first
        // $array = [100, 200, 300];
        // $first = Arr::first($array, function ($item) {
        //     return $item >= 150;
        // });

        #.array_exists
        // $array = ['name' => 'John Doe', 'age' => 17];
        // $exists = Arr::exists($array, 'salary'); // false
        // $exists = Arr::exists($array, 'name'); // true

        #.array_flatten
        // $array = ['name' => 'Joe', 'languages' => ['PHP', 'Ruby']];
        // $array = Arr::flatten($array);

        #. array_forget
        // $array = ['products' => ['desk' => ['price' => 100]]];
        // Arr::forget($array, 'products.desk');

        #. array_get
        // $array = ['products' => ['desk' => ['price' => 100]]];
        // $price = Arr::get($array, 'products.desk.price');

        #.array_has
        // $array = ['product' => ['name' => 'Desk', 'price' => 100]];
        // $contains = Arr::has($array, 'product.name');   // true
        // $contains = Arr::has($array, ['product.price', 'product.discount']);  // false

        #. array_isAssoc
        // $isAssoc = Arr::isAssoc(['product' => ['name' => 'Desk', 'price' => 100]]); // true
        // $isAssoc = Arr::isAssoc([1, 2, 3]); // false

        #.array_last
        // $array = [100, 200, 300, 110];
        // $last = Arr::last($array, function ($value, $key) {
        //     return $value >= 150;
        // });

        #. array_only
        // $array = ['name' => 'Desk', 'price' => 100, 'orders' => 10];
        // $slice = Arr::only($array, ['name', 'orders']);

        #. array_pluck
        // $array = [
        //     ['developer' => ['id' => 1, 'name' => 'Taylor']],
        //     ['developer' => ['id' => 2, 'name' => 'Abigail']],
        // ];
        // $names = Arr::pluck($array, 'developer.name', 'developer.id');

        #. array_prepend
        // $array = ['one', 'two', 'three', 'four'];
        // $array = Arr::prepend($array, 'zero');

        #. array_pull
        // $array = ['name' => 'Desk', 'price' => 100];
        // $name = Arr::pull($array, 'name');

        #. array_set
        // $array = ['products' => ['desk' => ['price' => 100]]];
        // $array = Arr::set($array, 'products.desk.price', 500);

        #. array_sort
        // $array = [
        //     ['name' => 'Desk'],
        //     ['name' => 'Table'],
        //     ['name' => 'Chair'],
        // ];
        // $sorted = array_values(Arr::sort($array, function ($value) {
        //     return $value['name'];
        // }));

        #. array_sortRecursive
        // $array = [
        //     ['Roman', 'Taylor', 'Li'],
        //     ['PHP', 'Ruby', 'JavaScript'],
        //     ['one' => 1, 'two' => 2, 'three' => 3],
        // ];
        // $sorted = Arr::sortRecursive($array);

        #array_where
        // $array = [100, '200', 300, '400', 500];
        // $filtered = Arr::where($array, function ($item) {
        //     return is_string($item);
        // });

        #. array_head
        // $array = [100, 200, 300];
        // $first = head($array);

        #. array_whereNotNull
        // $array = [0, null];
        // $filtered = Arr::whereNotNull($array);

        #. array_wrap
        // $string = 'Laravel';
        // $string_2 = 'php';
        // $array = Arr::wrap([$string,$string_2]);

        #. array_data_fill
        // $data = ['products' => ['desk' => ['price' => 100]]];
        // $array = data_fill($data, 'products.desk.discount', 10);

        // dd($array);
    }


    public function string()
    {
        #. __()
        // echo __('Welcome to our application');
        // echo __('auth.failed');

        #. class_basename()
        // $class = class_basename('Foo\Bar\Baz');

        #.e()
        // echo e('<html>foo</html>');

        #.preg_replace_array()
        // $string = 'The event will take place between :start and :end';
        // $replaced = preg_replace_array('/:[a-z_]+/', ['8:30', '9:00'], $string);

        #.after
        // $slice = Str::after('This is my name', 'my');

        #.afterLast
        // $slice = Str::afterLast('App\Http\Controllers\Controller', '\\');

        #ascii
        // $slice = Str::ascii('xin chào');

        #. before
        // $slice = Str::before('This is my name', 'name');

        #.beforeLast
        // $slice = Str::beforeLast('This is my name', 'name');

        #.between
        // $slice = Str::between('This is my name', 'This', 'name');

        #.camel
        // $converted = Str::camel('foo_bar');

        #.constains
        // $contains = Str::contains('This is my name', 'no'); // false

        #.endsWith
        // $result = Str::endsWith('This is my name', 'name'); // true

        #. finish
        // $adjusted = Str::finish('this/string', '/test');
        // $adjusted = Str::finish('this/string/', '/');

        #.headline
        // $headline = Str::headline('steve_jobs');
        // $headline = Str::headline('EmailNotificationSent');

        #.is
        // $matches = Str::is('foo*', 'bar'); // true
        // $matches = Str::is('baz*', 'foobar'); // false

        #. isUuid
        // $isUuid = Str::isUuid('a0a2a2d2-0b87-4a18-83f2-2529882be2de');

        #. kebad
        // $converted = Str::kebab('fooBaz');
        // $converted = Str::kebab('foo baz');

        #. length
        // $length = Str::length('Laravel');

        #.limit
        // $truncated = Str::limit('The quick brown fox jumps over the lazy dog', 30);

        #.lower
        // $converted = Str::lower('LARAVEL');

        #. mask
        // $string = Str::mask('taylor@example.com', '*', 5);
        // $string = Str::mask('taylor@example.com', '*', -15, 3);

        #. orderedUuid
        // return (string) Str::orderedUuid();

        // $padded = Str::padBoth('James', 10, '_');
        // $padded = Str::padBoth('James', 10);

        #. random
        // $random = Str::random(40);

        #. remove
        // $string = 'Peter Piper picked a peck of pickled peppers.';
        // $removed = Str::remove('e', $string);

        #. replace
        // $string = 'Laravel 8.x';
        // $replaced = Str::replace('8.x', '9.x', $string);

        #. replaceArray
        // $string = 'The event will take place between ? and ?';
        // $replaced = Str::replaceArray('?', ['8:30', '9:00'], $string);

        #. replaceFirst
        // $replaced = Str::replaceFirst('the', 'a', 'the quick brown fox jumps over the lazy dog');

        #. reverse
        // $reversed = Str::reverse('Hello World');

        #. slug
        // $slug = Str::slug('Laravel 5 Framework', '-');

        #.snake
        // $converted = Str::snake('fooBar','_');

        #.start()
        // $adjusted = Str::start('this/string', '/');

        #.substr
        $substr = Str::substr('The Laravel Framework', 4, 7);

        #.substrCount
        // $count = Str::substrCount('If you like ice cream, you will like snow cones.', 'cream');

        #. title
        // $converted  = Str::title('a nice title uses the correct case');

        #. ucfirst
        // $string = Str::ucfirst('foo bar');

        #.upper
        // $string = Str::upper('laravel');

        #. uuid
        // $uuid_2 = (string) Str::uuid();

        #. wordCount
        // $count =  Str::wordCount('Hello every body');

        #. exactly
        // $result = Str::of('Laravel')->exactly('Larave');

        #.trim
        // $string = '  Laravel    Framwork        đấ dddddd   dddđ      ';
        // $string = Str::of($string)->replaceMatches('/\s+/', ' ')->trim();

        // echo $string;
        // dd($string);
    }

    public function miscellaneous()
    {
        #. abort

        // abort(403);
        // abort(403, 'Unauthorized.', ['No data']);

        #. abort_if
        // abort_if(! Auth::user()->isAdmin(), 403);


    }


    public function path()
    {

        #. app_path
        // $path = app_path();
        // $path = app_path('Http/Controllers/Controller.php');

        #. database_path
        // $path = database_path();
        // $path = database_path('factories/UserFactory.php');

        #.....
        // dd($path);

        echo trans_choice('auth.apples', 3, ['value' => 5]);
    }
}
