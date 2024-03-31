function modalGantiStatus(title, status, link) {
    console.log(status);
    const titleModalGantiStatus = document.getElementById(
        "titleModalGantiStatus"
    );
    const linkGantiStatus = document.getElementById("linkGantiStatus");

    linkGantiStatus.setAttribute("href", link);
    if (status === "1") {
        linkGantiStatus.classList.remove("btn-edit", "bg-white");
        linkGantiStatus.classList.add("btn-delete");
        linkGantiStatus.textContent = "Non Aktifkan";
    } else {
        linkGantiStatus.classList.remove("btn-delete");
        linkGantiStatus.classList.add("btn-edit", "bg-white");
        linkGantiStatus.textContent = "Aktifkan";
    }
    titleModalGantiStatus.textContent = title;
}

function modalEditJurusan(namJurusan, idJurusan) {
    const modal = document.getElementById("titleModal");
    const form_namaJurusan = document.getElementById("namaJurusan");
    const form_idJurusan = document.getElementById("idJurusan");

    form_namaJurusan.value = namJurusan;
    form_idJurusan.value = idJurusan;
    modal.textContent = `Edit Jurusan '${namJurusan}'`;
}

function modalEditMapel(namaMapel, id) {
    const modal = document.getElementById("titleModal2");
    const form_namaMapel = document.getElementById("namaMapel");
    const form_idMapel = document.getElementById("idMapel");

    form_namaMapel.value = namaMapel;
    form_idMapel.value = id;
    modal.textContent = `Edit Mata Pelajaran '${namaMapel}'`;
}

function modalDeleteKelas(namaKelas, dataIdKelas) {
    const titleModalDelete = document.getElementById("titleModalDelete");
    const linkDelete = document.getElementById("linkDeleteJurnal");

    linkDelete.setAttribute("href", `kelas/delete/${dataIdKelas}`);
    titleModalDelete.textContent = `Apakah Anda Yakin Untuk Menghapus Data Kelas ${namaKelas}`;
}

function modalEditKelas(tahunAjaran, namaKelas, id, waliKelas) {
    const modal = document.getElementById("titleModalEdit");
    const form_namaKelas = document.getElementById("formNamaKelas");
    const form_tahunAjaran = document.querySelectorAll(".selectTahunAjaran");
    const form_id = document.getElementById("formIdKelas");
    const form_WaliKelas = document.querySelectorAll(".selectNamaPegawai");

    form_WaliKelas.forEach(function (option) {
        if (option.value == waliKelas) {
            option.setAttribute("selected", "selected");
        } else {
            option.removeAttribute("selected");
        }
    });

    form_tahunAjaran.forEach(function (option) {
        if (option.value == tahunAjaran) {
            option.setAttribute("selected", "selected");
        } else {
            option.removeAttribute("selected");
        }
    });

    form_namaKelas.value = namaKelas;
    form_id.value = id;

    modal.textContent = `Edit Kelas '${namaKelas}'`;
}

function rightClick(row) {
    console.log(row);
}

function showContextMenu(event, tahunAjaran, namaKelas, id, waliKelas) {
    event.preventDefault();

    let contextMenu = document.getElementById("contextMenu");
    let titleContext = document.getElementById("titleContext");
    let btnEditKelas = document.getElementById("btnEditKelas");
    let btnDeleteKelas = document.getElementById("btnDeleteKelas");
    let linkGenap = document.getElementById("linkGenap");
    let linkGanjil = document.getElementById("linkGanjil");
    let linkTambahSiswa = document.getElementById("linkTambahSiswa");

    linkGenap.setAttribute("href", `kelas/detail/${id}/genap`);
    linkGanjil.setAttribute("href", `kelas/detail/${id}/ganjil`);
    linkTambahSiswa.setAttribute("href", `kelas/detail/${id}/tambah-siswa`);

    btnEditKelas.addEventListener(
        "click",
        modalEditKelas(tahunAjaran, namaKelas, id, waliKelas)
    );

    btnDeleteKelas.addEventListener("click", modalDeleteKelas(namaKelas, id));

    titleContext.textContent = `Menu ${namaKelas}`;
    contextMenu.classList.remove("hidden");
    contextMenu.classList.add("block");
    contextMenu.style.left = event.pageX + "px";
    contextMenu.style.top = event.pageY - 100 + "px";

    document.addEventListener("click", hideContextMenu);
}

function hideContextMenu() {
    let contextMenu = document.getElementById("contextMenu");
    contextMenu.classList.remove("block");
    contextMenu.classList.add("hidden");
    document.removeEventListener("click", hideContextMenu);
}

function modalAddUser(namaPegawai, dataNIPY, dataStatus, dataIdPegawai) {
    const modal = document.getElementById("titleModal");
    const nipy = document.getElementById("nipy");
    const status = document.getElementById("status");
    const hideIdPegawai = document.getElementById("hideIdPegawai");
    const hidestatus = document.getElementById("hideStatus");

    nipy.value = dataNIPY;
    hideIdPegawai.value = dataIdPegawai;
    hidestatus.value = status.value = dataStatus;
    modal.textContent = `Akun User ${namaPegawai}`;
}

function modalDeletePegawai(namaPegawai, dataNIPY) {
    const titleModalDelete = document.getElementById("titleModalDelete");
    const linkDelete = document.getElementById("linkDeletePegawai");

    linkDelete.setAttribute("href", `pegawai/delete/${dataNIPY}`);
    titleModalDelete.textContent = `Apakah Anda Yakin Untuk Menghapus Data ${namaPegawai}`;
}

function validationAddUser() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var errorUsername = document.getElementById("errorUsername");
    var errorPassword = document.getElementById("errorPassword");

    var isValid = true;

    if (username.length < 3) {
        errorUsername.textContent = "*NIPY harus memiliki minimal 3 karakter.";
        isValid = false;
    } else {
        errorUsername.textContent = "";
    }

    if (password.length < 6) {
        errorPassword.textContent =
            "*Password harus memiliki minimal 6 karakter.";
        isValid = false;
    } else {
        errorPassword.textContent = "";
    }

    return isValid;
}
