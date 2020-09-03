$(document).ready(function(){
    // menghilangkan tombol cari
    $('#tombol-cari').hide();
    // event ketika keyword ditulis
    $('#keyword').on('keyup', function() {
        // munculkan icon loading
        $('.loader').show();
        // ajax menggunakan $.get()
        $.get('ajax/mahasiswa.php?keyword=' + $('#keyword').val(), function(data) {
            $('#container').html(data);
            $('.loader').hide();
        });
        // ajax menggunakan load()
        // $('#container').load('ajax/mahasiswa.php?keyword=' + $('#keyword').val());
    });
});