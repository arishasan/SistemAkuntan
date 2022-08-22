<div class="row">
    <div class="col-lg-12">
        <div class="callout callout-success">
            <label class="text-success">Informasi Pesanan </label>
            <p>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="tgl_pesan">Tgl. Pesan</label><br/>
                        <small>{{ date('d M Y', strtotime($data_pemesanan->tanggal_pesan)) }}</small>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="nama">Nama Pemesan</label><br/>
                        <small>{{ $data_pemesanan->nama_pemesan }}</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                        <label for="catatan">Catatan</label><br/>
                        <p><small>{{ $data_pemesanan->catatan }}</small></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                        <label for="tipe_pesanan">Tipe Pesanan</label> <br/>
                        <small><label class="text-{{ $data_pemesanan->tipe_pesanan == 'BAYAR' ? 'success' : 'danger' }}">{{ $data_pemesanan->tipe_pesanan }}</label></small>
                        </div>
                    </div>
                </div>
            </p>
        </div>
        <div class="row">
            <div class="col-lg-12">
            <div class="callout callout-info">
                <b class="text-info">Total Pembayaran</b>
                <p><small>Rp. <b>{{ number_format($data_pemesanan->total_pembayaran) }}</b></small></p>
            </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="callout callout-warning">
            <label class="text-warning">Detail Pesanan </label>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th><small>Nama Item</small></th>
                            <th class="text-right" width="25%"><small>Harga Satuan</small></th>
                            <th width="5%"><center><small>QTY</small></center></th>
                            <th class="text-right" width="25%"><small>Total</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($det_pemesanan as $val)
                        @php
                            $get_produk = \App\Models\ProdukModel::select(DB::raw('tb_produk.*, tb_kategori.nama as `nama_kategori`'))->join('tb_kategori', 'tb_produk.id_kategori','=','tb_kategori.id')->where('tb_produk.id', $val->id_produk)->first();
                        @endphp
                        <tr>
                            <td><small>{{ $get_produk->nama_kategori }} - {{ $get_produk->kode_produk }} - {{ $get_produk->nama }} [Rp. {{ number_format($get_produk->harga) }}]</small></td>
                            <td class="text-right"><small>Rp. {{ number_format($val->harga_satuan) }}</small></td>
                            <td class="text-center"><small>{{ $val->qty }}</small></td>
                            <td class="text-right"><small>Rp. {{ number_format($val->harga_satuan * $val->qty) }}</small></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<small>Diupdate pada <b>{{ date('d M Y, H:i:s', strtotime($data_pemesanan->updated_at)) }}</b></small>