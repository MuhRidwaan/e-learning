<h1>Input Absensi</h1>

<form action="{{ route('attendances.store') }}" method="POST">
    @csrf

    <div>
        <label>Nama Siswa</label>
        <input type="text" name="student_name">
    </div>

    <br>

    <div>
        <label>Status</label>

        <select name="status">
            <option value="present">Hadir</option>
            <option value="excused">Izin</option>
            <option value="sick">Sakit</option>
            <option value="absent">Alpa</option>
        </select>
    </div>

    <br>

    <button type="submit">
        Simpan
    </button>
</form>