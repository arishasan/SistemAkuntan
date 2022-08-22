<div class="row">
    <div class="col-lg-5">
        <div class="alert alert-success alert-dismissible">
            <h5><i class="icon fas fa-box"></i> {{ $data_produk->kode_produk }}</h5>
            {{ $data_produk->nama }}
            <br/>
            <b>Rp. {{ number_format($data_produk->harga) }}</b>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="callout callout-success">
            <label class="text-success">Kategori <i class="fas fa-arrow-right"></i> <b>{{ $data_produk->nama_kategori }}</b> </label>
            <p><small>{{ $data_produk->deskripsi }}</small></p>
        </div>
    </div>
</div>

<small>Diupdate pada <b>{{ date('d M Y, H:i:s', strtotime($data_produk->updated_at)) }}</b></small>