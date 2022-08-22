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
              <li class="breadcrumb-item">Pemesanan</li>
              <li class="breadcrumb-item">Edit</li>
              <li class="breadcrumb-item active"><a href="#">{{ $data_pemesanan->kode_pesanan }}</a></li>
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
                  <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Edit Data</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                  
                <form action="{{ route('update-pemesanan') }}" method="POST" id="formnya">
                @csrf
                <input type="hidden" name="id" value="{{ $data_pemesanan->id }}">
                <div class="row">

                    <div class="col-lg-12">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="tgl_pesan">Tgl. Pesan</label>
                            <input type="date" class="form-control" id="tgl_pesan" name="tgl_pesan" placeholder="Required" value="{{ $data_pemesanan->tanggal_pesan }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="nama">Nama Pemesan</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Required" value="{{ $data_pemesanan->nama_pemesan }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea name="catatan" class="form-control" id="catatan" rows="3">{{ $data_pemesanan->catatan }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                        <div class="callout callout-success">
                            <b class="text-success">Total Pembayaran</b>
                            <p>Rp. <label id="total_pembayarannya">{{ number_format($data_pemesanan->total_pembayaran) }}</label></p>
                        </div>
                        </div>
                    </div>

                    </div>
                    

                </div>

                <div class="float-right">
                <a href="{{ route('adm_pemesanan') }}" class="btn btn-outline-warning"><i class="fas fa-arrow-left"></i> Kembali</a>
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


@endsection

@section('scriptplus')

<script>

  $(function () {


  });
</script>

@endsection