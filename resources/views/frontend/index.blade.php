<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Thunderbite</title>

    <link href="{{ mix('/css/backstage.css') }}" rel="stylesheet">

    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            align-items: center;
            display: flex;
            justify-content: center;
        }


        #logo {
            max-width: 100%;
            width: 200px;
        }
    </style>

</head>

<body>
    <div class="container mx-auto px-8 relative z-10">
        <div class="flex justify-end">
            <div class="flex justify-between bg-black text-white hidden point-div">
                <div>Point:</div>
                <div id="point">0</div>
            </div>
        </div>
    <div class="grid grid-cols-5 gap-4" id="game">

        <div id="card" class="bg-white shadow-lg mx-auto rounded-b-lg flex justify-center">
            <div class="px-10 pt-4 pb-8">
                <h1>Game Arena</h1>
                <p>Hello, {{ auth()->user()->name }}</p>
                <p>Welcome on board!</p>
                <p>Let's get started. Click on the "Spin" button below to start playing.</p>
    
    
            </div>
        </div>
    </div>
    

    <div class="grid grid-cols-1 mt-5">
      <button id="spin" class="submit-button text-white font-bold py-4 px-4 rounded-full">
        Spin
      </button>
    </div>
</div>

</body>

</html>
