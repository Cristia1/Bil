<p>To set up the project, users need to run the following commands </p>

  1.<Install Bootstrap:
    npm install bootstrap

  2.<Build assets with npm:
    npm run dev
  
  3.<Generate an application key for Laravel:
    php artisan key:generate

  4.<Require Laravel UI package:
    composer require laravel/UI
  
  5.<Install JavaScript dependencies:
    npm install
  
  6.<Require the Laravel DomPDF package:
    composer require barryvdh/laravel-dompdf
  
  7.<Publish the DomPDF configuration with Laravel:
    php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"

   8.<Install Axios:
    npm install axios