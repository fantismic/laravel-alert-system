<h1>{{ $type }} Alert</h1>

<p>{{ $alertMessage }}</p>

@if (!empty($details))
    <h3>Details</h3>
    <ul>
        @foreach($details as $key => $value)
            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
        @endforeach
    </ul>
@endif
