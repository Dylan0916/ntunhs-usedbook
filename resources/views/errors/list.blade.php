@if (count($errors) > 0)
  <ul class="list-group">
    @foreach ($errors->all() as $error)
      <li class="list-group-item list-group-item-danger">
        <span class="glyphicon glyphicon-exclamation-sign"></span>
        <span class="sr-only">Error:</span>
        {{ $error }}
      </li>
    @endforeach
  </ul>
@endif
