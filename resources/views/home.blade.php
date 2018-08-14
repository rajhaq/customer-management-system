<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
          <!-- CSRF Token -->
       <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>welcome page</title>
        {{-- <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet"> --}}
       {{-- <link href={{ asset('css/all.css' )}} rel="stylesheet"> --}}
     
        <script>
   
        (function () {
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };


            @if(Auth::check())
              window.authUser={!! Auth::user() !!}
             @else
                window.authUser=false
             @endif
        })();
      </script>


    </head>
    <body>
        @guest
        <?php
            header("Location: login");
            die();
        ?>
    @endguest
       
       <div id="app">
        
          <mainapp></mainapp>
            
            

       </div>
   
       <script src="{{asset('js/app.js')}}"></script>
     
    </body>
</html>
