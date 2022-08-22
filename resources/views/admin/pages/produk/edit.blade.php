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
              Edit Master Produk
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master</a></li>
              <li class="breadcrumb-item">Produk</li>
              <li class="breadcrumb-item">Edit</li>
              <li class="breadcrumb-item active"><a href="#">{{ $data_produk->kode_produk }}</a></li>
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
                  
                    <form action="{{ route('update-produk') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $data_produk->id }}">
                        <div class="row vertical-align">
                            <div class="col-lg-4">
                                <div class="callout callout-success text-success">
                                    <label class="text-success">Kode Produk </label> <br/>
                                    {{ $data_produk->kode_produk }}
                                </div>
                            </div>
                            <div class="col-lg-8">

                            <div class="row">
                                <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Required" value="{{ $data_produk->nama }}" required>
                                </div>
                                </div>
                                <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control" required>
                                    <option value="">[ Silahkan Pilih ]</option>
                                    @foreach($data_kategori as $val)
                                        <option value="{{ $val->id }}" {{ $val->id == $data_produk->id_kategori ? 'selected' : '' }}>{{ $val->nama }}</option>
                                    @endforeach
                                    </select>
                                </div>
                                </div>
                                <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" class="form-control text-right currency" id="harga" name="harga" placeholder="Required" value="{{ number_format($data_produk->harga, 0, ".", ",") }}" required>
                                </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3">{{ $data_produk->deskripsi }}</textarea>
                                </div>
                                </div>
                            </div>

                            </div>
                        </div>

                        <div class="float-right">
                        <a href="{{ route('produk') }}" class="btn btn-outline-warning"><i class="fas fa-arrow-left"></i> Kembali</a>
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