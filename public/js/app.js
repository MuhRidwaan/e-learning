/**
 * Global AJAX helpers — E-Learning App
 * Requires: jQuery, SweetAlert2
 */

// Setup CSRF token untuk semua AJAX request
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

/**
 * Handle AJAX form submit
 * @param {string} formSelector
 */
function ajaxForm(formSelector) {
    $(document).on('submit', formSelector, function (e) {
        e.preventDefault();

        const form    = $(this);
        const url     = form.attr('action');
        const method  = form.find('input[name="_method"]').val() || form.attr('method');
        const btn     = form.find('[type=submit]');

        // Clear previous errors
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();

        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');

        $.ajax({
            url: url,
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false,
                }).then(() => {
                    if (res.redirect) window.location.href = res.redirect;
                });
            },
            error: function (xhr) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan');

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        const input = form.find(`[name="${field}"]`);
                        input.addClass('is-invalid');
                        input.after(`<span class="invalid-feedback d-block">${messages[0]}</span>`);
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: 'Periksa kembali isian form.',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: xhr.responseJSON?.message || 'Server error.',
                    });
                }
            }
        });
    });
}

/**
 * Handle AJAX delete dengan konfirmasi SweetAlert2
 * @param {string} btnSelector
 * @param {string} title
 */
function ajaxDelete(btnSelector, title = 'Hapus data ini?') {
    $(document).on('click', btnSelector, function () {
        const url = $(this).data('url');

        Swal.fire({
            title: title,
            text: 'Data yang dihapus tidak bisa dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then(result => {
            if (!result.isConfirmed) return;

            $.ajax({
                url: url,
                type: 'POST',
                data: { _method: 'DELETE', _token: $('meta[name="csrf-token"]').attr('content') },
                success: function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Dihapus!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(() => location.reload());
                },
                error: function () {
                    Swal.fire('Error', 'Gagal menghapus data.', 'error');
                }
            });
        });
    });
}
