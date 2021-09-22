
// v1 : Project & Layout Setup
1- set up a the project    => laravel new laravel8ecommerce
2- set up livewire         => composer require livewire/livewire
3- create db               => go to phpMyAdmin and create db called (laravel8ecommercedb).
4- go to .env and write :  DB_DATABASE=laravel8ecommercedb
5- download template from   => https://github.com/surfsidemedia/Laravel-8-E-Commerce
6- go to views and create directory called layouts.
7- create base.blade.php inside layouts.
8- go to index.html from no. 5 and take all code without the <main> section
    copy and paste in base.blade.php and write {{$slot}} in the olace of <main> section
9- add @livewireStyles last thing in the head & @livewireScripts last thing before the closing body tag
10- go to cmd and create livewire component for home : php artisan make:livewire HomeComponent
11- go to app->Http->Livewire->HomeComponent and
write inside the (render) function :
return view('livewire.home-component')->layout('layouts.base');

12- go to web.php hash the default Route and create route for the home component :
use App\Http\Livewire\HomeComponent;
Route::get('/', HomeComponent::class);

13- go to resources->views->livewire->home-component.blade.php and write :
paste the <main> section from no.5

14- take assets directory from no. 5 copy to public directory in the project.
15- change all files and images to {{asset('')}}
16- go to browser and run the project
////////////////////////////////////////////////////////////////////////

// v2 : Create Shop, Cart And Checkout Page
1- create ShopComponent : php artisan make:livewire ShopComponent
2- create CartComponent : php artisan make:livewire CartComponent
3- create CheckoutComponent : php artisan make:livewire CheckoutComponent
4- create the Routs for the 3 compnents :
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\CheckoutComponent;
Route::get('/shop', ShopComponent::class);
Route::get('/cart', CartComponent::class);
Route::get('/checkout', CheckoutComponent::class);

5- go to app->Http->Livewire->ShopComponent and
write inside the (render) function :
return view('livewire.shop-component')->layout('layouts.base');

6- go to app->Http->Livewire->CartComponent and
write inside the (render) function :
return view('livewire.cart-component')->layout('layouts.base');

7- go to app->Http->Livewire->CheckoutComponent and
write inside the (render) function :
return view('livewire.checkout-component')->layout('layouts.base');

8- go to base.blade.php and change :
<a href="index.html" class="link-term mercado-item-title">Home</a>
to
<a href="/" class="link-term mercado-item-title">Home</a>// the req dest. in the route.

<a href="shop" class="link-term mercado-item-title">Shop</a>
to
<a href="shop.html" class="link-term mercado-item-title">Shop</a>// the req dest. in the route.
and for the other to links (cart & checkout).

9- go to v1 no.5 and take <main> section from shop.html and paste
    in resources->views->livewire->shop-component.blade.php
    and for the other to pages (cart & checkout).

10- change all images to asset and delete first comment
(<!--main area-->) and last one
then go and test the page in the browser go and open localhost:8000/ then
from the header press shop
then do the same for cart & checkout pages.
//////////////////////////////////////////////////////////////////////////







