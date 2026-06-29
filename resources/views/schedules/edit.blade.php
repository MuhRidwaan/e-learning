<h1>Edit Jadwal</h1>

<form method="POST" action="{{ route('schedules.update', $schedule->id) }}">
    @csrf
    @method('PUT')

```
<input type="hidden" name="course_id" value="{{ $schedule->course_id }}">

<div>
    <label>Judul Pertemuan</label>
    <input type="text" name="title" value="{{ $schedule->title }}">
</div>

<div>
    <label>Deskripsi</label>
    <textarea name="description">{{ $schedule->description }}</textarea>
</div>

<div>
    <label>Mulai</label>
    <input type="datetime-local" name="start_time" value="{{ $schedule->start_time }}">
</div>

<div>
    <label>Selesai</label>
    <input type="datetime-local" name="end_time" value="{{ $schedule->end_time }}">
</div>

<div>
    <label>Lokasi</label>
    <input type="text" name="location" value="{{ $schedule->location }}">
</div>

<div>
    <label>Tipe</label>

    <select name="type">
        <option value="online" {{ $schedule->type == 'online' ? 'selected' : '' }}>Online</option>
        <option value="offline" {{ $schedule->type == 'offline' ? 'selected' : '' }}>Offline</option>
        <option value="hybrid" {{ $schedule->type == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
    </select>
</div>

<button type="submit">
    Update
</button>
```

</form>
