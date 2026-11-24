document.addEventListener("DOMContentLoaded", function () {
    const inputBerat = document.getElementById("berat_kg");
    const selectLayanan = document.getElementById("jenis_layanan");
    const tampilHarga = document.getElementById("tampil_harga");
    const rincianHarga = document.getElementById("rincian_harga");

    const TARIF = {
        reguler: 7000,
        kilat: 12000
    };

    function formatRupiah(angka) {
        return "Rp " + angka.toLocaleString("id-ID");
    }

    function hitungEstimasi() {
        if (!inputBerat || !selectLayanan || !tampilHarga) return;

        const berat = parseFloat(inputBerat.value) || 0;
        const layanan = selectLayanan.value;
        const hargaPerKg = TARIF[layanan] || 7000;

        if (berat > 0) {
            const total = Math.round(berat * hargaPerKg);
            tampilHarga.textContent = formatRupiah(total);
            rincianHarga.textContent = `${berat} kg × ${formatRupiah(hargaPerKg)} (${layanan.toUpperCase()})`;
        } else {
            tampilHarga.textContent = "Rp 0";
            rincianHarga.textContent = "Masukkan berat pakaian untuk menghitung estimasi otomatis.";
        }
    }

    if (inputBerat && selectLayanan) {
        inputBerat.addEventListener("input", hitungEstimasi);
        selectLayanan.addEventListener("change", hitungEstimasi);
        hitungEstimasi();
    }
});

function isiOtomatisPelanggan(selectEl) {
    const selectedOption = selectEl.options[selectEl.selectedIndex];
    const namaInput = document.getElementById("nama_pelanggan");
    if (selectedOption && selectedOption.dataset.nama && namaInput) {
        namaInput.value = selectedOption.dataset.nama;
    }
}