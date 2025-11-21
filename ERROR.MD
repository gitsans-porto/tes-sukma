# ErrorException - Internal Server Error

Undefined variable $field

PHP 8.4.14
Laravel 12.39.0
localhost:8000

## Stack Trace

0 - resources\views\edit.blade.php:300
1 - vendor\laravel\framework\src\Illuminate\Filesystem\Filesystem.php:123
2 - vendor\laravel\framework\src\Illuminate\Filesystem\Filesystem.php:124
3 - vendor\laravel\framework\src\Illuminate\View\Engines\PhpEngine.php:57
4 - vendor\laravel\framework\src\Illuminate\View\Engines\CompilerEngine.php:76
5 - vendor\laravel\framework\src\Illuminate\View\View.php:208
6 - vendor\laravel\framework\src\Illuminate\View\View.php:191
7 - vendor\laravel\framework\src\Illuminate\View\View.php:160
8 - vendor\laravel\framework\src\Illuminate\Http\Response.php:78
9 - vendor\laravel\framework\src\Illuminate\Http\Response.php:34
10 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:939
11 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:906
12 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:821
13 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:180
14 - vendor\laravel\framework\src\Illuminate\Routing\Middleware\SubstituteBindings.php:50
15 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
16 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken.php:87
17 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
18 - vendor\laravel\framework\src\Illuminate\View\Middleware\ShareErrorsFromSession.php:48
19 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
20 - vendor\laravel\framework\src\Illuminate\Session\Middleware\StartSession.php:120
21 - vendor\laravel\framework\src\Illuminate\Session\Middleware\StartSession.php:63
22 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
23 - vendor\laravel\framework\src\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse.php:36
24 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
25 - vendor\laravel\framework\src\Illuminate\Cookie\Middleware\EncryptCookies.php:74
26 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
27 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:137
28 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:821
29 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:800
30 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:764
31 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:753
32 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php:200
33 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:180
34 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TransformsRequest.php:21
35 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull.php:31
36 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
37 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TransformsRequest.php:21
38 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TrimStrings.php:51
39 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
40 - vendor\laravel\framework\src\Illuminate\Http\Middleware\ValidatePostSize.php:27
41 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
42 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance.php:109
43 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
44 - vendor\laravel\framework\src\Illuminate\Http\Middleware\HandleCors.php:48
45 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
46 - vendor\laravel\framework\src\Illuminate\Http\Middleware\TrustProxies.php:58
47 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
48 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks.php:22
49 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
50 - vendor\laravel\framework\src\Illuminate\Http\Middleware\ValidatePathEncoding.php:26
51 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
52 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:137
53 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php:175
54 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php:144
55 - vendor\laravel\framework\src\Illuminate\Foundation\Application.php:1220
56 - public\index.php:20
57 - vendor\laravel\framework\src\Illuminate\Foundation\resources\server.php:23

## Request

GET /penduduk/2/edit

## Headers

* **host**: localhost:8000
* **user-agent**: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0
* **accept**: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
* **accept-language**: en-US,en;q=0.5
* **accept-encoding**: gzip, deflate, br, zstd
* **referer**: http://localhost:8000/penduduk/2
* **connection**: keep-alive
* **cookie**: XSRF-TOKEN=eyJpdiI6Im84YnBQTUpOM2xnaHNHUTdMUkRMaEE9PSIsInZhbHVlIjoiYUpIeU85NEhsTys0K3JqbHhMTDYyNFM1YzNsaUdRUjgyajJXUTBQVndrVVlqWXNwMmhRTEs4bHdCaGM3b0p0cm5CWkxJV09GLzR4UitGUzBaU2hHbWZvRXQzc2tqQ0dRL3cyZXZ3OXFlekc2S2dLSiswWmUwQnRVMnFORksxYTEiLCJtYWMiOiI1MmZhNzRjMDE2ZjM0ODYyOTkyZDA5NTE3YjgxYWZkOTFkNDFkN2ZhMjY3Nzk4MzAwYjcwMDRjYWUwOWU1OTlhIiwidGFnIjoiIn0%3D; laravel-session=eyJpdiI6IkoxSGVhRFRYQ1h1eWIvcmZNS1VmaVE9PSIsInZhbHVlIjoiVnViOCsza281Q3Y3SUlCMXZkZjU2cGdmWXlzS3BnRzQ3N0lwN3RmNVlaSDdkeFBkbllwUno5VUdjOEd2Nk1pZkNuSU5zNE92dmhFR2ZFbVJJVXptMWxpVVVYYlNWV09xMFp6RkJBU3pGdEMwSVZRNGpQenEvYzFHMExzaEdMc0UiLCJtYWMiOiJiOTQ3MTc5ZDNmZDhmMTRkMzM1ZWVkNDEyZWYyZjQwODQ3M2U1YTAxZTBjNjY1NzUzYjQ2YTFiYTgzYjNkODY3IiwidGFnIjoiIn0%3D
* **upgrade-insecure-requests**: 1
* **sec-fetch-dest**: document
* **sec-fetch-mode**: navigate
* **sec-fetch-site**: same-origin
* **sec-fetch-user**: ?1
* **priority**: u=0, i

## Route Context

controller: App\Http\Controllers\PendudukController@edit
route name: penduduk.edit
middleware: web

## Route Parameters

{
    "penduduk": "2"
}

## Database Queries

* mysql - select * from `sessions` where `id` = '89s6cTQzTJBh8fFlEedLYx9AXlGNW9qlPbdyKtkv' limit 1 (4.18 ms)
* mysql - select * from `penduduks` where `penduduks`.`id` = '2' limit 1 (0.64 ms)
* mysql - select * from `kartu_keluarga` where `kartu_keluarga`.`id` = 2 limit 1 (0.65 ms)
