<h1>Jadwal Kelas</h1>

<a href="{{ route('schedules.create') }}">
    Tambah Jadwal
</a>

<table border="1">
    <tr>
        <th>Judul</th>
        <th>Lokasi</th>
        <th>Mulai</th>
        <th>Selesai</th>
        <th>Aksi</th>
    </tr>

    @foreach($schedules as $schedule)
    <tr>
        <td>{{ $schedule->title }}</td>
        <td>{{ $schedule->location }}</td>
        <td>{{ $schedule->start_time }}</td>
        <td>{{ $schedule->end_time }}</td>
        <td>
            <a href="{{ route('schedules.edit',$schedule->id) }}">
                Edit
            </a>
        </td>
    </tr>
    @endforeach
</table>