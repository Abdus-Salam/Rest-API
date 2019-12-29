# Laravel 6.0 key-val Store REST API


### Prerequisite
We will need to make sure our server meets the following requirements:
1. PHP >= 7.2.0
2. BCMath PHP Extension
3. Ctype PHP Extension
4. JSON PHP Extension
5. Mbstring PHP Extension
6. OpenSSL PHP Extension
7. PDO PHP Extension
8. Tokenizer PHP Extension
9. XML PHP Extension




### Installation

1. Need to configure database connector on .env file for Mysql - <br>
  by default db name is : `laravel_rest_api`
2. run `composer install`
3. `php artisan migrate`

### API EndPoints

* Get all the values of the store <br> 
   `GET /values` `http://localhost:8000/api/v1/values`
* GET Single / Multiple Values by Key <br />
  `http://localhost:8000/api/v1/values?keys=key1,key2`
* Save a value in the store <br> 
`POST /values` `http://localhost:8000/api/v1/values`
* Update a value in the store  <br>
`PATCH /values` `http://localhost:8000/api/v1/values/key`


### Collections Example
 ##### list of all records
 
 `GET /values` `http://localhost:8000/api/v1/values` <br>
 Response <br>
  `200` <Br>
 Headers <br>
 `Content-Type:application/json` <br>
 Body <br>
<pre> 
[
     {
        "success": true,
        "message": "All data fetch successfully",
        "data": [
            {
                "_key": "1",
                "value": "This is arbitary length value"
            },
            {
                "_key": "2",
                "value": "secret key of the value"
            }
        ]
    }
 ] 
</pre>



##### GET value by key
 
 `GET /values?keys=key1,key2` `http://localhost:8000/api/v1/values?keys=2` <br>
 Response <br>
  `200` <Br>
 Headers <br>
 `Content-Type:application/json` <br>
 Body <br>
<pre> 
 [
     {
        "success": true,
        "message": "Data fetch by keys successfully",
        "data": [
            {
                "_key": "2",
                "value": "secret key of the value"
            }
        ]
    }
]

</pre>

##### Save a value
 
 `POST /values` `http://localhost:8000/api/v1/values` <br>
Request <br>

 Headers <br>
 `Content-Type:application/json` <br>
 Body <br>
 <pre> 
   {
	"key" : "2",
	"value" : "secret key of the value"
   }
</pre>



##### Update a value
 
 `Patch /values` `http://localhost:8000/api/v1/values/2` <br>
Request <br>

 Headers <br>
 `Content-Type:application/json` <br>
 Body <br>
``` <pre> 
   {
	"key" : "2",
	"value" : "update secret key of the value"
   }
```
</pre>

### Status code
1. `200` for `GET / PATCH`  VERBS.
2. `201` for `POST` VERB.
3. `500` for no resource is created

### TTL - 5 min
1. TTL is set for every values. 
2. TTL is reset when GET or Patch request serve. 
3. Value is removed from the store when TTL is over.

TTL is implemented by events. When migrate command run, automatically TTL schedular create named with `TTL_Schedular` in the DB section.

### Testing API

Run the laravel development server <br>
`php artisan serve`
