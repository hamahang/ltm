# laravel_LTM
laravel Task Manager  is a laravel package for manage task .

# Requiments 
<ul>
<li>
PHP >= 7.0
</li>
<li>
Laravel 5.5|5.6 | 5.7
</li>
</ul>

# Installation
<h3>Quick installation</h3>

``composer require hamahang/ltm``

publish vendor  
``php artisan vendor:publish --provider=Hamahang\LTM\TASKServiceProvider``

if update package for publish vendor you should run :  
``php artisan vendor:publish --provider=Hamahang\LTM\TASKServiceProvider --force``

migrate tabales  
``php artisan migrate``
