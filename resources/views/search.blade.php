<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body class="p-8">
  <form action="/" method="GET">
    <input class="border border-gray-300 border-b-0 w-full px-4 py-2" type="search" name="q" id="q" required
      value="{{ request('q') }}">
  </form>

  <ul class="border border-gray-300 py-2 px-4">
    @forelse ($results as $key => $result)
    <li>{!! $result !!}</li>
  @empty
    <li>No matching results.</li>
  @endforelse
  </ul>
</body>

</html>
