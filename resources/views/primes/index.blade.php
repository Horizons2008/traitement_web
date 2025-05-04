<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Abbreviation</th>
            <th>Groupe</th>
            <th>Mode</th>
            <th>Configurations</th> <!-- New Column -->
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($primes as $prime)
        <tr>
            <td>{{ $prime->title }}</td>
            <td>{{ $prime->abrv }}</td>
            <td>{{ $prime->groupe->title ?? 'N/A' }}</td>
            <td>{{ $prime->mode_name }}</td>
            <td>
                <a href="{{ route('configurations.index', $prime->id) }}" 
                   class="btn btn-sm btn-info">
                   {{ $prime->configurations_count }} Configs
                </a>
            </td>
            <td>
                <!-- Existing action buttons -->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>