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
              Administrasi Piutang
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Administrasi</a></li>
              <li class="breadcrumb-item active">Piutang</li>
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
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                <form action="{{ route('adm_piutang_filter') }}" method="POST">
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
                        <th width="15%">Tgl. Input</th>
                        <th>Nama Pemesan</th>
                        <th width="20%" class="text-right">Nominal</th>
                        <th width="15%" class="text-center">Status</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                    </thead>
                    <tbody id="body_pemesanan">
                    
                    @foreach($data_piutang as $key => $val)
                    <tr>
                        <td><center><i class="fas fa-receipt text-danger"></i></center></td>
                        <td>{{ $val->kode_pesanan }}</td>
                        <td>{{ date('d M Y', strtotime($val->created_at)) }}</td>
                        <td>{{ $val->nama_pemesan }}</td>
                        <td class="text-right"><b>Rp. {{ number_format($val->nominal) }}</b></td>
                        <td class="text-center">
                            <span class="badge badge-{{ $val->status == 'SUDAH BAYAR' ? 'success' : 'warning' }}">{{ $val->status }}</span>

                            @if($val->status == 'BELUM BAYAR')
                            <hr>
                                <button type="button" data-id="{{ $val->id }}" data-kode="{{ $val->kode_pesanan }}" data-idpesanan="{{ $val->id_pesanan }}" class="btn btn-outline-primary btn-sm form-control btn_bayar"><i class="fas fa-check"></i> BAYAR</button>
                            @else
                            <hr>
                            <small>Dibayar pada tanggal</small><br/>
                            <b>{{ date('d M Y', strtotime($val->tanggal_bayar)) }}</b>

                            @endif

                        </td>
                        <td><center>
                            <button class="btn btn-outline-info btn-sm detail" data-id="{{ md5($val->id_pesanan) }}" data-nama="{{ $val->kode_pesanan }}"><i class="fas fa-eye"></i></button>
                            @if($val->is_jurnal == 0)
                            <button class="btn btn-outline-danger btn-sm delete" data-id="{{ md5($val->id) }}"><i class="fas fa-trash"></i></button>
                            @else
                            <small class="text-success"><b>Jurnal <i class="fas fa-check"></i></b></small>
                            @endif
                        </center></td>
                    </tr>
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <th width="5%"></th>
                        <th width="10%">Kode Pesanan</th>
                        <th width="10%">Tgl. Input</th>
                        <th>Nama Pemesan</th>
                        <th width="20%" class="text-right">Nominal</th>
                        <th width="15%" class="text-center">Status</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                    </tfoot>
                  </table>

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

    <div class="modal fade" id="modal_bayar">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Pembayaran Piutang</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="bayar_id">
            <input type="hidden" id="pesanan_id">
            <div class="callout callout-info">
                <b class="text-info">Kode Transaksi</b>
                <p><label><b id="bayar_kode"></b></label></p>
            </div>
            <div class="form-group">
                <label>Tanggal Bayar</label>
                <input type="date" class="form-control" id="bayar_tgl" value="{{ date('Y-m-d') }}">
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="bayar_now">Bayar</button>
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

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

  $(function () {

    $('#bayar_now').click(function(){
        
        Swal.fire({
            title: 'Apakah anda yakin?',
            showCancelButton: true,
            icon: 'info',
            confirmButtonText: 'Ya',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                $.ajax({
                    url: "{{ route('simpan-bayar-piutang') }}",
                    type:"POST",
                    data:{
                        id: $('#bayar_id').val(),
                        pesanan: $('#pesanan_id').val(),
                        tglBayar: $('#bayar_tgl').val()
                    },
                    success:function(response){
                        location.reload();
                    },
                    error: function(error) {
                        location.reload();
                    }
                });

            } else if (result.isDenied) {
            }
        });
        
    });

    $("#table").DataTable({
      "responsive": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

    $('#table').on('click', '.delete', function(){
      let id = $(this).attr('data-id');

      Swal.fire({
        title: 'Hapus data piutang?',
        showCancelButton: true,
        icon: 'warning',
        confirmButtonText: 'Hapus',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

          let link = "{{ url('administrasi/piutang/delete') }}/"+id;
          $.get(link, function(res){
            location.reload();
          });

        } else if (result.isDenied) {
        }
      })

    });

    $('#table').on('click', '.btn_bayar', function(){
      let id = $(this).attr('data-id');
      let pesanan = $(this).attr('data-idpesanan');
      let kode = $(this).attr('data-kode');

      $('#bayar_id').val(id);
      $('#pesanan_id').val(pesanan);
      $('#bayar_kode').text(kode);
      $('#modal_bayar').modal('show');

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