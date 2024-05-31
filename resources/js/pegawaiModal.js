import axios from "axios";

$(document).ready(function () {
    let isModalActive = false;
    let selectedMenu;

    $('#createRencanaForm').on('submit', function (e) {
        if (isModalActive) {
            e.preventDefault();
            console.log('Form submission prevented because isModalActive is false.');
        }
    });

    $('#wakilKetuaForm').on('click', function () {
        selectedMenu = 'wakil_ketua';
        isModalActive = true;
        $('#pegawaiModal').removeClass('hidden modal');
        $('#modal-content-pegawai').html('');
    });

    $('#sekretarisForm').on('click', function () {
        selectedMenu = 'sekretaris';
        isModalActive = true;
        $('#pegawaiModal').removeClass('hidden modal');
        $('#modal-content-pegawai').html('');
    });

    $('#bendaharaForm').on('click', function () {
        selectedMenu = 'bendahara';
        isModalActive = true;
        $('#pegawaiModal').removeClass('hidden modal');
        $('#modal-content-pegawai').html('');
    });

    $('#searchPegawai').on('submit', function (e) {
        e.preventDefault();

        $('#spinner-pegawai').removeClass('hidden');
        $('#spinner-pegawai').addClass('flex');
        $('#modal-content-pegawai').html('');

        const searchText = $(this).find('input[type="text"]').val().toLowerCase();

        axios.get(`${import.meta.env.VITE_APP_URL}/list-pegawai?search=${searchText}`)
            .then(function (response) {
                $('#spinner-pegawai').addClass('hidden');
                $('#spinner-pegawai').removeClass('flex');

                const dataFetch = response.data.data;
                displayData(dataFetch)
            })
            .catch(function (err) {
                $('#searchPegawai').find('input[type="text"]').val('');
                $('#spinner-pegawai').addClass('hidden');
                $('#spinner-pegawai').removeClass('flex');;
                $('#modal-content-pegawai').html('<p class="text-center text-sm text-gray-400">Terjadi kesalahan saat mengambil data.</p>');
            });

    });

    $('#closeModal-pegawai').on('click', function () {
        isModalActive = false;
        $('#searchPegawai').find('input[type="text"]').val('');
        $('#pegawaiModal').addClass('hidden');
        selectedMenu = null;
    });

    function displayData(dataResponses) {
        let content = '';
        dataResponses.forEach(function (item) {
            if (selectedMenu === 'wakil_ketua') {
                content += `
                <div class="p-2 m-2 bg-gray-200 rounded cursor-pointer" 
                     onclick="selectWakilKetua('${item.namaPegawai}')">
                    ${item.namaPegawai}
                </div>`;
            } else if (selectedMenu === 'sekretaris') {
                content += `
                <div class="p-2 m-2 bg-gray-200 rounded cursor-pointer" 
                     onclick="selectSekretaris('${item.namaPegawai}')">
                    ${item.namaPegawai}
                </div>`;
            } else if (selectedMenu === 'bendahara') {
                content += `
                <div class="p-2 m-2 bg-gray-200 rounded cursor-pointer" 
                     onclick="selectBendahara('${item.namaPegawai}')">
                    ${item.namaPegawai}
                </div>`;
            }
        });
        $('#modal-content-pegawai').html(content);
    }

    window.selectWakilKetua = function (name) {
        $('#searchPegawai').find('input[type="text"]').val('');
        isModalActive = false;
        $('#wakilKetuaForm').val(name);
        $('#pegawaiModal').addClass('hidden');
    }

    window.selectSekretaris = function (name) {
        $('#searchPegawai').find('input[type="text"]').val('');
        isModalActive = false;
        $('#sekretarisForm').val(name);
        $('#pegawaiModal').addClass('hidden');
    }

    window.selectBendahara = function (name) {
        $('#searchPegawai').find('input[type="text"]').val('');
        isModalActive = false;
        $('#bendaharaForm').val(name);
        $('#pegawaiModal').addClass('hidden');
    }

});

