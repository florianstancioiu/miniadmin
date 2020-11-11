<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Clean Blog - Start Bootstrap Theme</title>

        @include('client.partials.styles')
    </head>
    <body>
        <!-- Navigation -->
        @include('client.partials.navigation')


        <!-- Page Header -->
        @yield('header')

        <!-- Main Content -->
        <div class="container">
            <div class="row">
                @yield('content')
           </div>
        </div>

        <hr>

        <!-- Footer -->
        @include('client.partials.footer')

        
        @include('client.partials.scripts')    
    </body>
</html>
