<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body class="p-8">
  <div class="grid grid-cols-12 gap-10">
    <aside class="col-span-3">
      <form action="/search" method="GET">
        <input type="hidden" name="q" value="{{ request('q') }}">
        @foreach ($facets as $facet)
        <div class="border-gray-300 py-2 border">
          <h3 class="font-bold border-b border-gray-300 px-4 pb-2">{{ ucwords($facet['name']) }}</h3>
          <ul class="px-4 py-2">
          @foreach ($facet['filters'] as $filter)
          <li>
          <label for="{{ $facet['name'] }}-{{ $filter['id'] }}" class="flex items-center gap-x-2">
          <input type="checkbox" name="filters[{{ $facet['name'] }}][]" id="{{ $facet['name'] }}-{{ $filter['id'] }}"
            onchange="this.form.submit()" value="{{ trim($filter['name']) }}" @checked(in_array($filter['name'], request('filters.authors', [])))> {{  $filter['name'] }}
          </label>
          </li>
        @endforeach
          </ul>
        </div>
    @endforeach
      </form>
    </aside>

    <div class="col-span-9">
      <form action="/search" method="GET">
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
    </div>
  </div>

</body>

</html>
