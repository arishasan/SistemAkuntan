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
              Administrasi Pemasukan
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Administrasi</a></li>
              <li class="breadcrumb-item active">Pemasukan</li>
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

                <form action="{{ route('adm_pemasukan_filter') }}" method="POST">
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
                        <th>Keterangan</th>
                        <th width="15%">Tgl. Pemasukan</th>
                        <th width="20%">Nama Pemesan</th>
                        <th width="15%" class="text-right">Nominal</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                    </thead>
                    <tbody id="body_pemesanan">
                    
                    @foreach($data_pemasukan as $key => $val)
                    <tr>
                        <td><center><i class="fas fa-arrow-right text-success"></i></center></td>
                        <td>{{ $val->keterangan }}</td>
                        <td>{{ date('d M Y', strtotime($val->tgl_pemasukan)) }}</td>
                        <td>{{ $val->nama_pemesan ?? '-' }}</td>
                        <td class="text-right"><b>Rp. {{ number_format($val->nominal) }}</b></td>
                        <td><center>
                              @if($val->id_pesanan != 0)
                              <button class="btn btn-outline-info btn-sm detail" data-id="{{ md5($val->id_pesanan) }}" data-nama="{{ $val->kode_pesanan }}"><i class="fas fa-eye"></i></button>
                              @endif
                            @if($val->is_jurnal == 0)
                            
                              @if($val->id_pesanan != 0)
                              <!-- <button class="btn btn-outline-info btn-sm detail" data-id="{{ md5($val->id_pesanan) }}" data-nama="{{ $val->kode_pesanan }}"><i class="fas fa-eye"></i></button> -->
                              @else
                              <a href="{{ url('administrasi/pemasukan/edit/') }}/{{ md5($val->id) }}" class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></a>
                              @endif

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
                        <th>Keterangan</th>
                        <th width="15%">Tgl. Pemasukan</th>
                        <th width="20%">Nama Pemesan</th>
                        <th width="15%" class="text-right">Nominal</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                    </tfoot>
                  </table>

                </div>

                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                  
                  <form action="{{ route('simpan-pemasukan') }}" method="POST">
                    @csrf
                    <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                          <label for="tgl_pemasukan">Tgl. Pemasukan</label>
                          <input type="date" class="form-control" id="tgl_pemasukan" value="{{ date('Y-m-d') }}" name="tgl_pemasukan" placeholder="Required" required>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label for="keterangan">Keterangan</label>
                          <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Required" required>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label for="nominal">Nominal</label>
                          <input type="text" class="form-control text-right currency" value="0" id="nominal" name="nominal" placeholder="Required" required>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-outline-primary form-control"><i class="fas fa-save"></i> Simpan</button>
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

  $(function () {

    $("#table").DataTable({
      "responsive": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

    $('#table').on('click', '.delete', function(){
      let id = $(this).attr('data-id');

      Swal.fire({
        title: 'Hapus data pemasukan?',
        showCancelButton: true,
        icon: 'warning',
        confirmButtonText: 'Hapus',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

          let link = "{{ url('administrasi/pemasukan/delete') }}/"+id;
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