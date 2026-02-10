<?php 
session_start();
include '../../main/connect.php';
if($_SESSION['status'] != "login") header("location:../../auth/login.php");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Penjualan - Kasir Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --navy-pro: #081b38; /* Warna dari gambar Anda */
            --primary-soft: #eef2ff;
        }
        body { background: #f0f2f5; font-family: 'Inter', sans-serif; }

        /* UPGRADE PRODUK CARD */
        .produk-item {
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: 15px;
        }
        .produk-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(8, 27, 56, 0.1) !important;
            border-color: var(--navy-pro);
        }

        /* KERANJANG NAVY THEME */
        .keranjang-box {
            border-radius: 20px;
            position: sticky;
            top: 20px;
            border: none;
            overflow: hidden;
        }
        .card-header-navy {
            background-color: var(--navy-pro);
            color: white;
            padding: 20px;
        }
        .btn-navy {
            background-color: var(--navy-pro);
            color: white;
            border: none;
            transition: 0.3s;
        }
        .btn-navy:hover {
            background-color: #0d2a56;
            color: white;
            transform: translateY(-2px);
        }
        .btn-navy:disabled {
            background-color: #cbd5e1;
        }

        /* TEXT HIGHLIGHT */
        .text-navy { color: var(--navy-pro) !important; }
        
        /* QTY CONTROL */
        .qty-input-group {
            display: flex;
            align-items: center;
            gap: 5px;
            background: #f1f4f9;
            border-radius: 8px;
            padding: 2px;
            width: fit-content;
        }
        .btn-qty {
            padding: 2px 8px;
            border-radius: 6px;
            border: none;
            background: white;
            font-size: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        /* SCROLLBAR */
        .custom-scroll::-webkit-scrollbar { width: 5px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>

<body>
<div class="d-flex">
    <?php include '../../template/sidebar.php'; ?>

    <div class="container-fluid p-4">
        <div class="row g-4">
            
            <div class="col-md-7">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white py-4 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold m-0 text-dark">
                                <i class="fas fa-th-large me-2 text-navy"></i>Katalog Produk
                            </h5>
                            <div class="input-group w-50">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" id="searchProduk" class="form-control bg-light border-0" placeholder="Cari produk...">
                            </div>
                        </div>
                    </div>

                    <div class="card-body custom-scroll" style="max-height:75vh; overflow-y: auto;">
                        <div class="row g-3" id="produkList">
                            <?php 
                            $sql = mysqli_query($conn,"SELECT * FROM produk WHERE Stok > 0 ORDER BY NamaProduk ASC");
                            while($p = mysqli_fetch_assoc($sql)){
                            ?>
                            <div class="col-md-4 produk-card">
                                <div class="card produk-item h-100 shadow-sm border-0 p-2"
                                     onclick="tambahItem('<?= $p['ProdukID'] ?>','<?= $p['NamaProduk'] ?>','<?= $p['Harga'] ?>','<?= $p['Stok'] ?>')">
                                    <div class="card-body text-center">
                                        <div class="bg-light rounded-3 py-3 mb-2">
                                            <i class="fas fa-box fa-2x text-muted opacity-50"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1 text-truncate"><?= $p['NamaProduk'] ?></h6>
                                        <p class="text-navy fw-bold mb-2">Rp <?= number_format($p['Harga'], 0, ',', '.') ?></p>
                                        <span class="badge rounded-pill bg-light text-muted border fw-normal small">Stok: <?= $p['Stok'] ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card keranjang-box shadow-lg border-0">
                    <div class="card-header-navy">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold m-0"><i class="fas fa-shopping-basket me-2"></i>Checkout</h5>
                            <span class="badge bg-white text-navy rounded-pill" id="itemCount">0 Item</span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="proses_simpan.php" method="POST" id="formTransaksi">
                            
                            <div class="row g-2 mb-4">
                                <div class="col-12">
                                    <input type="text" name="NamaPelanggan" class="form-control border-0 bg-light py-2" placeholder="Nama Pelanggan" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="NomorTelepon" class="form-control border-0 bg-light py-2" placeholder="No. Telpon" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="Alamat" class="form-control border-0 bg-light py-2" placeholder="Alamat" required>
                                </div>
                            </div>

                            <div class="table-responsive custom-scroll" style="max-height: 250px;">
                                <table class="table table-hover align-middle" id="tabelPesanan">
                                    <thead>
                                        <tr class="small text-muted text-uppercase">
                                            <th>Item</th>
                                            <th>Qty</th>
                                            <th class="text-end">Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            <div class="bg-light p-4 rounded-4 mt-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted fw-bold">Grand Total</span>
                                    <h3 class="fw-bold text-navy mb-0" id="totalHarga">Rp 0</h3>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="small fw-bold text-muted mb-2 d-block">Uang Bayar</label>
                                    <div class="input-group bg-white rounded-3 p-1 border">
                                        <span class="input-group-text border-0 bg-white fw-bold">Rp</span>
                                        <input type="number" id="uangBayar" class="form-control border-0 fs-5 fw-bold" oninput="hitungKembalian()" placeholder="0">
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="small fw-bold text-muted">Kembalian</span>
                                    <span class="fw-bold fs-5 text-danger" id="textKembalian">Rp 0</span>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="button" onclick="confirmBayar()" class="btn btn-navy py-3 rounded-3 fw-bold shadow-sm" id="btnBayar" disabled>
                                    <i class="fas fa-check-circle me-2"></i>Selesaikan Transaksi
                                </button>
                                <button type="button" onclick="clearCart()" class="btn btn-link text-muted btn-sm text-decoration-none">
                                    <i class="fas fa-trash-alt me-1"></i>Reset Keranjang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
let items = [];

function tambahItem(id, nama, harga, stokMax) {
    let index = items.findIndex(i => i.id === id);
    if (index !== -1) {
        if (items[index].qty < stokMax) {
            items[index].qty++;
        } else {
            Swal.fire({ icon: 'warning', title: 'Stok Habis', text: 'Stok maksimal tercapai' });
        }
    } else {
        items.push({ id, nama, harga: parseInt(harga), qty: 1, stokMax: parseInt(stokMax) });
    }
    renderTabel();
}

function updateQty(index, delta) {
    let item = items[index];
    let newQty = item.qty + delta;
    if (newQty > 0 && newQty <= item.stokMax) {
        item.qty = newQty;
        renderTabel();
    }
}

function hapusItem(i) {
    items.splice(i, 1);
    renderTabel();
}

function renderTabel() {
    let html = '';
    let total = 0;
    let count = 0;

    items.forEach((item, i) => {
        let sub = item.qty * item.harga;
        total += sub;
        count += item.qty;
        html += `
        <tr>
            <td>
                <div class="fw-bold text-dark small">${item.nama}</div>
                <div class="text-muted" style="font-size: 11px;">Rp ${item.harga.toLocaleString('id-ID')}</div>
                <input type="hidden" name="ProdukID[]" value="${item.id}">
                <input type="hidden" name="Jumlah[]" value="${item.qty}">
            </td>
            <td>
                <div class="qty-input-group">
                    <button type="button" class="btn-qty" onclick="updateQty(${i}, -1)"><i class="fas fa-minus"></i></button>
                    <span class="px-2 small fw-bold">${item.qty}</span>
                    <button type="button" class="btn-qty" onclick="updateQty(${i}, 1)"><i class="fas fa-plus"></i></button>
                </div>
            </td>
            <td class="text-end fw-bold text-navy small">Rp ${sub.toLocaleString('id-ID')}</td>
            <td class="text-end">
                <button type="button" class="btn btn-sm text-danger opacity-50" onclick="hapusItem(${i})"><i class="fas fa-times"></i></button>
            </td>
        </tr>`;
    });

    document.querySelector('#tabelPesanan tbody').innerHTML = html;
    document.getElementById('totalHarga').innerText = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('itemCount').innerText = count + ' Item';
    hitungKembalian();
}

function hitungKembalian() {
    let total = items.reduce((sum, i) => sum + (i.qty * i.harga), 0);
    let bayar = document.getElementById('uangBayar').value;
    let kembali = bayar - total;

    let textKembali = document.getElementById('textKembalian');
    let btnBayar = document.getElementById('btnBayar');

    if (bayar > 0 && kembali >= 0) {
        textKembali.innerText = 'Rp ' + kembali.toLocaleString('id-ID');
        textKembali.classList.replace('text-danger', 'text-success');
        btnBayar.disabled = (items.length === 0);
    } else {
        textKembali.innerText = 'Rp 0';
        textKembali.classList.replace('text-success', 'text-danger');
        btnBayar.disabled = true;
    }
}

function confirmBayar() {
    Swal.fire({
        title: 'Konfirmasi Bayar',
        text: "Pastikan data pelanggan dan pembayaran benar",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#081b38',
        confirmButtonText: 'Ya, Bayar Sekarang'
    }).then((result) => {
        if (result.isConfirmed) document.getElementById('formTransaksi').submit();
    });
}

function clearCart() {
    if(items.length === 0) return;
    items = [];
    renderTabel();
}

// SEARCH
document.getElementById('searchProduk').addEventListener('keyup', function() {
    let keyword = this.value.toLowerCase();
    document.querySelectorAll('.produk-card').forEach(card => {
        let text = card.innerText.toLowerCase();
        card.style.display = text.includes(keyword) ? 'block' : 'none';
    });
});
</script>
</body>
</html>