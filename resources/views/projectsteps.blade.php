
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

// v3: Admin and User Authentication :
1- setup jetstream :
- composer require laravel/jetstream
- php artisan jetstream:install livewire
- go to create_users_table and add column
$table->string('utype')->default('USR')->comment('ADM for Admin and USR for User or Customer');
- npm install
- npm run dev
- php artisan migrate
- php artisan vendor:publish --tag=jetstream-views

2- go to base.blade.php and add this code to the header :
@if(Route::has('login'))
@auth     {{--if the user authenticated--}}
    @if(Auth::user()->utype === 'ADM')   {{-- if the user is Admin --}}
            {{-- for Admin --}}
            <li class="menu-item menu-item-has-children parent" >
                <a title="My Account" href="#">My Account ({{Auth::user()->name}})<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                <ul class="submenu curency" >
                    <li class="menu-item" >
                        <a title="Dashboard" href="{{route('admin.dashboard')}}">Dashboard</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); ">Logout</a>
                    </li>
                    <form id="logout-form" action="{{route('logout')}}" method="POST">
                        @csrf
                    </form>
                </ul>
            </li>
        @else  {{-- for User or Customer --}}
            <li class="menu-item menu-item-has-children parent" >
                <a title="My Account" href="#">My Account ({{Auth::user()->name}})<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                <ul class="submenu curency" >
                    <li class="menu-item" >
                        <a title="Dashboard" href="{{route('user.dashboard')}}">Dashboard</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); ">Logout</a>
                    </li>
                    <form id="logout-form" action="{{route('logout')}}" method="POST">
                        @csrf
                    </form>
                </ul>
            </li>
    @endif
@else  {{-- if the user didn't log in or register --}}
<li class="menu-item" ><a title="Register or Login" href="{{route('login')}}">Login</a></li>
<li class="menu-item" ><a title="Register or Login" href="{{route('register')}}">Register</a></li>
@endif
@endif

3- go and create an two accounts
- admin@admin.com
- user@user.com
- go tp phpMyAdmin and change the utype of admin to 'ADM'

4- go to web.php and hash the default middleware Route because we will create another
two Routes :
use App\Http\Livewire\User\UserDashboardComponent;
use App\Http\Livewire\Admin\AdminDashboardComponent;

// for User or Customer :
Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get('/user/dashboard',UserDashboardComponent::class)->name('user.dashboard');
});

// for Admin :
Route::middleware(['auth:sanctum', 'verified','authadmin'])->group(function(){
        Route::get('/admin/dashboard',AdminDashboardComponent::class)->name('admin.dashboard');
    });

5- go to cmd and create middleware for the Admin :
php artisan make:middleware AuthAdmin

6- go to app->Http->Middleware->AuthAdmin.php and write :
public function handle(Request $request, Closure $next)
    {
        return $next($request);
        if(session('utype') === 'ADM'){
            return $next($request);
        }else{
            session()->flush();   // clear all session data
            return redirect()->route('login');
        }
    }

7- go to app->Http->Kernel.php in protected $routeMiddleware add :
'authadmin' => \App\Http\Middleware\AuthAdmin::class,

what is Kernel.php :
the application console kernel is responsible for specifying which custom commands
should be made available to users and when to automatically execute various commands
and tasks (by using the task scheduler).
نواة وحدة تحكم التطبيق مسؤولة عن تحديد الأوامر المخصصة التي يجب إتاحتها للمستخدمين
ومتى يتم تنفيذ الأوامر والمهام المختلفة تلقائيًا (باستخدام برنامج جدولة المهام).

8- go to app->Providers->RouteServiceProvider.php and
turn this code : public const HOME = '/dashboard';
to : public const HOME = '/';

9- go to vendor->laravel->fortify->src->Actions->AttemptToAuthenticate.php :

use Illuminate\Support\Facades\Auth;

public function handle($request, $next)
    {
        if (Fortify::$authenticateUsingCallback) {
            return $this->handleUsingCustomCallback($request, $next);
        }

        if ($this->guard->attempt(
            $request->only(Fortify::username(), 'password'),
            $request->filled('remember'))
        ) {
            if(Auth::user()->utype === 'ADM'){   // what will you write from here
                session(['utype'=>'ADM']);
                return redirect(RouteServiceProvider::HOME);
            }else if(Auth::user()->utype === 'USR')
            {
                session(['utype'=>'USR']);
                return redirect(RouteServiceProvider::HOME);
            }                                 // to here
            return $next($request);
        }

        $this->throwFailedAuthenticationException($request);
    }


10- create two coponents for admin dashboard and user dashboard :
php artisan make:livewire admin/AdminDashboardComponent
php artisan make:livewire user/UserDashboardComponent

11- go to app->Http->Livewire->Admin->AdminDashboardcomponent.php :
return view('livewire.admin.admin-dashboard-component')->layout('layouts.base');

12- go to app->Http->Livewire->User->UserDashboardcomponent.php :
return view('livewire.user.user-dashboard-component')->layout('layouts.base');

13 - go to resources->views->admin->admin-dashboard-component.blade.php :
<h1>Admin Dashboard</h1>

14 - go to resources->views->user->user-dashboard-component.blade.php :
<h1>User/Customer Dashboard</h1>

14- go to cmd : php artisan optimize

15- go to browser and login with the user account and from arrow press dashboard
then with admin account too.



