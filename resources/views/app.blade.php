<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
  <script src="{{ mix('/js/app.js') }}" defer></script>
</head>
<body>
  <div id="app">
    {{-- {{ dd($data) }} --}}
    {{-- <p>{!! json_encode($data) !!}</p> --}}
    <vue_app />
    <script>
      let laravelData = JSON.parse({!! $data !!})
      console.log(laravelData);
    </script>
    {{-- <vue_app :laravelData="laravelData"/> --}}
  </div>
</body>
</html>
