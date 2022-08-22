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
              Edit Master Kategori
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master</a></li>
              <li class="breadcrumb-item">Kategori</li>
              <li class="breadcrumb-item">Edit</li>
              <li class="breadcrumb-item active"><a href="#">{{ $data_kategori->nama }}</a></li>
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
                  
                 <form action="{{ route('update-kategori') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data_kategori->id }}">
                    <div class="row">
                      <div class="col-lg-8">
                        <div class="form-group">
                          <label for="nama_kategori">Nama Kategori</label>
                          <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Required" value="{{ $data_kategori->nama }}" required>
                        </div>
                      </div>
                      <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-outline-primary form-control"><i class="fas fa-save"></i> Simpan</button>
                      </div>
                      <div class="col-lg-2">
                        <label>&nbsp;</label>
                        <a href="{{ route('kategori') }}" class="btn btn-outline-warning form-control"><i class="fas fa-arrow-left"></i> Kembali</a>
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

<script>
  $(function () {
    
  });
</script>

@endsection