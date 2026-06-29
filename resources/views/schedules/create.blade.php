<h1>Tambah Jadwal</h1>

<form method="POST" action="{{ route('schedules.store') }}">
    @csrf

    <input type="hidden" name="course_id" value="1">

    <div>
        <label>Judul Pertemuan</label>
        <input type="text" name="title">
    </div>

    <div>
        <label>Deskripsi</label>
        <textarea name="description"></textarea>
    </div>

    <div>
        <label>Mulai</label>
        <input type="datetime-local" name="start_time">
    </div>

    <div>
        <label>Selesai</label>
        <input type="datetime-local" name="end_time">
    </div>

    <div>
        <label>Lokasi</label>
        <input type="text" name="location">
    </div>

    <div>
        <label>Tipe</label>

        <select name="type">
            <option value="online">Online</option>
            <option value="offline">Offline</option>
            <option value="hybrid">Hybrid</option>
        </select>
    </div>

    <button type="submit">
        Simpan
    </button>
</form>