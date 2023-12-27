<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 10 and Vue 3</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/Routes/index.js']); ?>
    
</head>

<body>
    <div id="app"></div>


</body>

</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Inv-wps/resources/views/app.blade.php ENDPATH**/ ?>