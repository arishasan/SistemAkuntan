@extends('admin.mainlayout')



@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              Administrasi Pemesanan
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Administrasi</a></li>
              <li class="breadcrumb-item active">Pemesanan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        @include('admin.parts.feedback')
        
        <div>
          <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
              <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Data</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Tambah Data Baru</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                <form action="{{ route('adm_pemesanan_filter') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>Tampilkan Dari</label>
                                        <input type="date" class="form-control" name="tgl_dari" value="{{ $tgl_dari ?? date('Y-m-01') }}">
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label>Tampilkan Sampai</label>
                                        <input type="date" class="form-control" name="tgl_sampai" value="{{ $tgl_sampai ?? date('Y-m-t') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button class="btn btn-outline-primary btm-sm form-control"><i class="fas fa-search"></i> Cari</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <br/>
                  
                <table id="table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                        <th width="5%"></th>
                        <th width="15%">Kode Pesanan</th>
                        <th width="15%">Tgl. Pesan</th>
                        <th>Nama Pemesan</th>
                        <th width="15%" class="text-right">Total</th>
                        <th width="10%" class="text-center">Tipe</th>
                        <th width="15%"><center>Aksi</center></th>
                    </tr>
                    </thead>
                    <tbody id="body_pemesanan">
                    
                    @foreach($data_pemesanan as $key => $val)
                    <tr>
                        <td><center><i class="fas fa-receipt"></i></center></td>
                        <td>{{ $val->kode_pesanan }}</td>
                        <td>{{ date('d M Y', strtotime($val->tanggal_pesan)) }}</td>
                        <td>{{ $val->nama_pemesan }}</td>
                        <td class="text-right"><b>Rp. {{ number_format($val->total_pembayaran) }}</b></td>
                        <td class="text-center">
                            <span class="badge badge-{{ $val->tipe_pesanan == 'BAYAR' ? 'success' : 'danger' }}">{{ $val->tipe_pesanan }}</span>
                        </td>
                        <td><center>
                            <button class="btn btn-outline-info btn-sm detail" data-id="{{ md5($val->id) }}" data-nama="{{ $val->kode_pesanan }}"><i class="fas fa-eye"></i></button>
                            <a href="{{ url('administrasi/pemesanan/edit/') }}/{{ md5($val->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-outline-danger btn-sm delete" data-id="{{ md5($val->id) }}" data-nama="{{ $val->kode_pesanan }}"><i class="fas fa-trash"></i></button>
                        </center></td>
                    </tr>
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <th width="5%"></th>
                        <th width="10%">Kode Pesanan</th>
                        <th width="10%">Tgl. Pesan</th>
                        <th>Nama Pemesan</th>
                        <th width="15%" class="text-right">Total</th>
                        <th width="10%" class="text-center">Tipe</th>
                        <th width="15%"><center>Aksi</center></th>
                    </tr>
                    </tfoot>
                  </table>

                </div>
                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                  
                  <form action="{{ route('simpan-pemesanan') }}" method="POST" id="formnya">
                    @csrf
                    
                    <div class="row">

                        <div class="col-lg-5">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                <label for="tgl_pesan">Tgl. Pesan</label>
                                <input type="date" class="form-control" id="tgl_pesan" name="tgl_pesan" placeholder="Required" value="{{ old('tgl_pesan') ?? date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                <label for="nama">Nama Pemesan</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Required" value="{{ old('nama') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                <label for="catatan">Catatan</label>
                                <textarea name="catatan" class="form-control" id="catatan" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                <label for="tipe_pesanan">Tipe Pesanan</label>
                                <select name="tipe_pesanan" id="tipe_pesanan" class="form-control" required>
                                    <option value="BAYAR">BAYAR</option>
                                    <option value="PIUTANG">PIUTANG</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-lg-6" hidden>
                                <div class="form-group">
                                <label for="status_pesanan">Status Pesanan</label>
                                <select name="status_pesanan" id="status_pesanan" class="form-control" required>
                                    <option value="VALID">VALID</option>
                                    <option value="VOID">VOID</option>
                                </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                            <div class="callout callout-success">
                                <b class="text-success">Total Pembayaran</b>
                                <input type="hidden" name="tot_bayar" id="tot_bayar">
                                <p>Rp. <label id="total_pembayarannya">0</label></p>
                            </div>
                            </div>
                        </div>

                        </div>
                        <div class="col-lg-7">

                            <div class="callout callout-warning">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                        <label for="pilih_produk">Produk</label>    
                                        <select name="pilih_produk" id="pilih_produk" class="form-control select2" style="width: 100%;">
                                            <option value="">[ Silahkan Pilih ]</option>
                                            @foreach($data_produk as $val)
                                                <option value="{{ $val->id }}" data-id="{{ md5($val->id) }}" data-harga="{{ $val->harga }}">{{ $val->nama_kategori }} - {{ $val->kode_produk }} - {{ $val->nama }} [Rp. {{ number_format($val->harga) }}]</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>&nbsp;</label> <br/>
                                        <button type="button" class="btn btn-outline-warning form-control" id="tambah_item"><i class="fas fa-plus"></i> Tambahkan</button>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-list"></i> List Produk
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped" width="100%">
                                            <thead>
                                                <tr>
                                                    <th><small>Nama Item</small></th>
                                                    <th class="text-right" width="25%"><small>Harga Satuan</small></th>
                                                    <th width="5%"><center><small>QTY</small></center></th>
                                                    <th class="text-right" width="25%"><small>Total</small></th>
                                                    <th width="5%"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="list_produk"></tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>


                        </div>

                    </div>

                    <div class="float-right">
                      <button type="submit" class="btn btn-outline-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>

                  </form>

                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal_produk">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Tambahkan Produk Kedalam List</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

        <div id="holder_produk"></div>

        <hr>

        <div class="form-group">
        <label for="qty_nya">Kuantitas</label>
        <input type="hidden" id="harga_nya">
        <input type="hidden" id="id_nya">
        <input type="hidden" id="nama_nya">
        <input type="number" class="form-control" id="qty_nya" name="qty_nya" placeholder="Required" value="1" min="1">
        </div>

            
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="tambahkan_produk_now">Tambahkan</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal_detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="title_modal"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="holder_detail">
            
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection

@section('scriptplus')

<script>
var totBayar = 0;

function hitung_tot_bayar(){
    totBayar = 0;
    $(document).find('.totalInput').each(function(i, obj) {
        totBayar = totBayar + parseFloat($(this).val());
    });
    $('#total_pembayarannya').text(totBayar.toLocaleString('en-US'));
    $('#tot_bayar').val(totBayar);
}

  $(function () {

    $("#formnya").on("keypress", function (event) {
        var keyPressed = event.keyCode || event.which;
        if (keyPressed === 13) {
            event.preventDefault();
            return false;
        }
    });

    $(document).on('click', '.delete_item', function(){
      $(this).closest('tr').remove();
      hitung_tot_bayar();
    });

    $('#tambahkan_produk_now').click(function(){

        let id = $('#id_nya').val();
        let nama = $('#nama_nya').val();
        let harga = $('#harga_nya').val();
        let qty = $('#qty_nya').val();

        if(qty == null || qty == '' || qty == 0){

            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Anda belum mengisi QTY!',
            });

        }else{

            if($('.item_'+id).length > 0){

                let qtyExist = $('.item_'+id).find('.qtynyah').text();
                let tambah = parseFloat(qtyExist) + parseFloat(qty);
                $('.item_'+id).find('.qtynyah').text(tambah);

                let tot = parseFloat(harga) * parseFloat(tambah);
                $('.item_'+id).find('.totalnyah').html("Rp. "+tot.toLocaleString('en-US'));

            }else{

                let tot = parseFloat(harga) * parseFloat(qty);

                let text = '<tr class="item_'+id+'">'+
                '<td><input type="hidden" value="'+id+'" name="item_id[]"><small>'+nama+'</small></td>'+
                '<td class="text-right"><input type="hidden" value="'+harga+'" name="item_harga[]"><small>Rp. '+parseFloat(harga).toLocaleString('en-US')+'</small></td>'+
                '<td class="text-center"><input type="hidden" value="'+qty+'" name="item_qty[]"><small class="qtynyah">'+qty+'</small></td>'+
                '<td class="text-right"><input type="hidden" value="'+tot+'" name="item_tot[]" class="totalInput"><small class="totalnyah">Rp. '+parseFloat(tot).toLocaleString('en-US')+'</small></td>'+
                '<td class="text-center"><button type="button" class="btn btn-danger btn-sm delete_item"><i class="fas fa-trash"></i></button></td>'+
                '</tr>';

                $('#list_produk').append(text);

            }

            hitung_tot_bayar();

            $('#modal_produk').modal('hide');
            $('#qty_nya').val(1);
            $('#pilih_produk').val('').trigger('change');

        }

    });

    $('#tambah_item').click(function(){

        let item = $('#pilih_produk');

        if(item.val() == null || item.val() == ''){

            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Anda belum memilih produk!',
            });

        }else{

            let id = item.val();
            let idmd = $( "#pilih_produk option:selected" ).attr('data-id');
            let harga = $( "#pilih_produk option:selected" ).attr('data-harga');
            let namaItem = $( "#pilih_produk option:selected" ).text();

            let link = "{{ url('master/produk/detail') }}/"+idmd;
            $.get(link, function(res){
                $('#harga_nya').val(harga);
                $('#nama_nya').val(namaItem);
                $('#id_nya').val(id);
                $('#holder_produk').html(res);
                $('#modal_produk').modal('show');
            });

        }

    });

    $("#table").DataTable({
      "responsive": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

    $('#table').on('click', '.delete', function(){
      let id = $(this).attr('data-id');
      let nama = $(this).attr('data-nama');

      Swal.fire({
        title: 'Hapus data pemesanan '+nama+'?',
        showCancelButton: true,
        icon: 'warning',
        confirmButtonText: 'Hapus',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

          let link = "{{ url('administrasi/pemesanan/delete') }}/"+id;
          $.get(link, function(res){
            location.reload();
          });

        } else if (result.isDenied) {
        }
      })

    });

    $('#table').on('click', '.detail', function(){
      let id = $(this).attr('data-id');
      let nama = $(this).attr('data-nama');

        $('#title_modal').text(nama);
        let link = "{{ url('administrasi/pemesanan/detail') }}/"+id;
        $.get(link, function(res){
            $('#holder_detail').html(res);
            $('#modal_detail').modal('show');
        });

    });

  });
</script>

@endsection