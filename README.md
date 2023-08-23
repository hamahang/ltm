# Hamahang LTM

Laravel Task Manager is a laravel package for manage tasks.

# Requirements

<ul>
<li>
PHP >= 7.0
</li>
<li>
Laravel 5.5, 5.6, 5.7
</li>
</ul>

# Installation

<h3>Quick Installation</h3>

Composer command:  
``composer require hamahang/ltm``

Publish Vendor:  
``php artisan vendor:publish --provider=Hamahang\LTM\TASKServiceProvider``

If update package for publish vendor you should run:  
``php artisan vendor:publish --provider=Hamahang\LTM\TASKServiceProvider --force``

Migrations:  
``php artisan migrate``