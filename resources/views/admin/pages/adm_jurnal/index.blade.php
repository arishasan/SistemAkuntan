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
              Administrasi Jurnal
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Administrasi</a></li>
              <li class="breadcrumb-item active">Jurnal</li>
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

                <form action="{{ route('adm_jurnal_filter') }}" method="POST">
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
                        <th width="15%">Kode Jurnal</th>
                        <th width="15%">Tgl. Jurnal</th>
                        <th>Keterangan</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($data_jurnal as $key => $val)
                    <tr>
                        <td><center><i class="fas fa-arrow-right text-success"></i></center></td>
                        <td>{{ $val->kode_jurnal }}</td>
                        <td>{{ date('d M Y', strtotime($val->tgl_jurnal)) }}</td>
                        <td>{{ $val->keterangan ?? '-' }}</td>
                        <td><center>
                            
                            <button class="btn btn-outline-info btn-sm detail" data-id="{{ md5($val->id) }}" data-nama="{{ $val->kode_jurnal }}"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-outline-danger btn-sm delete" data-id="{{ md5($val->id) }}"><i class="fas fa-trash"></i></button>
                            
                        </center></td>
                    </tr>
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <th width="5%"></th>
                        <th width="15%">Kode Jurnal</th>
                        <th width="15%">Tgl. Jurnal</th>
                        <th>Keterangan</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                    </tfoot>
                  </table>

                </div>

                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                  
                  <form action="{{ route('simpan-jurnal') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-5">
                            
                            <div class="card">
                                <div class="card-body">
                                <div class="form-group">
                                    <label for="tgl_jurnal">Tgl. Jurnal</label>
                                    <input type="date" class="form-control" id="tgl_jurnal" value="{{ date('Y-m-d') }}" name="tgl_jurnal" placeholder="Required" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
                                </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-7">

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr class="text-sm">
                                            <th width="5%" class="text-center">No.</th>
                                            <th>Keterangan</th>
                                            <th width="15%" class="text-center">Type</th>
                                            <th width="15%" class="text-center">Tanggal</th>
                                            <th width="15%" class="text-right">Nominal</th>
                                        </tr>
                                    </thead>

                                    <tbody id="body_jurnal"></tbody>

                                    <tfoot>
                                        <tr class="text-sm">
                                            <th width="5%" class="text-center">No.</th>
                                            <th>Keterangan</th>
                                            <th width="15%" class="text-center">Type</th>
                                            <th width="15%" class="text-center">Tanggal</th>
                                            <th width="15%" class="text-right">Nominal</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <button type="submit" class="btn btn-outline-primary"><i class="fas fa-save"></i> Simpan</button>
                        </div>
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

function cariTrx(){

    let tgl = $('#tgl_jurnal').val();
    let link = '{{ url("administrasi/jurnal/get_trx/") }}/'+tgl;
    let loading = '<tr class="text-sm">'+
        '<td colspan="5"><center><b>Memuat</b></center></td>'+
    '</tr>';
    $('#body_jurnal').html(loading);
    $.get(link, function(res){

        let parse = JSON.parse(res);
        let txt = '';
        if(parse.length > 0){

            $.each(parse, function(i, o){

                let warna = '';

                if(o.type == 'PEMASUKAN'){
                    warna = 'bg-success';
                }else if(o.type == 'PENGELUARAN'){
                    warna = 'bg-danger';
                }else if(o.type == 'PIUTANG'){
                    warna = 'bg-warning';
                }else if(o.type == 'PIUTANG DIBAYAR'){
                    warna = 'bg-primary';
                }else{
                    warna = '';
                }

                txt += '<tr class="text-sm '+warna+'">'+
                '<td class="text-center">'+(i+1)+'.</td>'+
                '<td><input type="hidden" name="id[]" value="'+o.id+'">'+o.keterangan+'</td>'+
                '<td class="text-center"><input type="hidden" name="type[]" value="'+o.type+'"><b>'+o.type+'</b></td>'+
                '<td class="text-center"><b>'+o.tgl+'</b></td>'+
                '<td class="text-right"><b>Rp. '+o.nominal.toLocaleString('en-US')+'</b></td>'+
                +'</tr>';
            });

            $('#body_jurnal').html(txt);

        }else{

            let res = '<tr class="text-sm">'+
                '<td colspan="5"><center><b>Tidak Ada Data Yang Ditampilkan.</b></center></td>'+
            '</tr>';
            $('#body_jurnal').html(res);

        }

    });

}

  $(function () {

    cariTrx();

    $('#tgl_jurnal').change(function(){
        cariTrx();
    });

    $("#table").DataTable({
      "responsive": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

    $('#table').on('click', '.delete', function(){
      let id = $(this).attr('data-id');

      Swal.fire({
        title: 'Hapus data jurnal?',
        showCancelButton: true,
        icon: 'warning',
        confirmButtonText: 'Hapus',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

          let link = "{{ url('administrasi/jurnal/delete') }}/"+id;
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
        let link = "{{ url('administrasi/jurnal/detail') }}/"+id;
        $.get(link, function(res){
            $('#holder_detail').html(res);
            $('#modal_detail').modal('show');
        });

    });

  });
</script>

@endsection