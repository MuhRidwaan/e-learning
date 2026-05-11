{{-- Partial: form fields untuk tambah/edit modul --}}
<div class="form-group">
    <label for="moduleTitle">Judul Modul <span class="text-danger">*</span></label>
    <input type="text"
           name="title"
           id="moduleTitle"
           class="form-control"
           placeholder="Contoh: Pengenalan Dasar"
           maxlength="255"
           required>
</div>

<div class="form-group">
    <label for="moduleDescription">Deskripsi</label>
    <textarea name="description"
              id="moduleDescription"
              class="form-control"
              rows="3"
              placeholder="Deskripsi singkat modul (opsional)"></textarea>
</div>

<div class="form-group">
    <label for="moduleOrder">Urutan <span class="text-danger">*</span></label>
    <input type="number"
           name="order"
           id="moduleOrder"
           class="form-control"
           min="0"
           value="0"
           required>
    <small class="form-text text-muted">Angka lebih kecil tampil lebih dulu.</small>
</div>
