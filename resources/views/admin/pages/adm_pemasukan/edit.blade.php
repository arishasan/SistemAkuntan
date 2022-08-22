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
              <li class="breadcrumb-item">Pemasukan</li>
              <li class="breadcrumb-item active"><a href="#">Edit</a></li>
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
                  
                    <form action="{{ route('update-pemasukan') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $data_pemasukan->id }}">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                <label for="tgl_pemasukan">Tgl. Pemasukan</label>
                                <input type="date" class="form-control" id="tgl_pemasukan" value="{{ $data_pemasukan->tgl_pemasukan }}" name="tgl_pemasukan" placeholder="Required" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $data_pemasukan->keterangan }}" placeholder="Required" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                <label for="nominal">Nominal</label>
                                <input type="text" class="form-control text-right currency" value="{{ number_format($data_pemasukan->nominal, 0, ".", ",") }}" id="nominal" name="nominal" placeholder="Required" required>
                                </div>
                            </div>
                            <div class="col-lg">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-outline-primary form-control"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                            <div class="col-lg">
                                <label>&nbsp;</label>
                                <a href="{{ route('adm_pemasukan') }}" class="btn btn-outline-warning form-control"><i class="fas fa-arrow-left"></i> Kembali</a>
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

@endsection

@section('scriptplus')

@endsection