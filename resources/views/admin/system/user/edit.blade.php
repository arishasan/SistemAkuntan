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
              Edit Data User
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">System</a></li>
              <li class="breadcrumb-item">Edit</li>
              <li class="breadcrumb-item">Data</li>
              <li class="breadcrumb-item active"><a href="#">{{ $data_user->nama }}</a></li>
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
                  
                  <form action="{{ route('update-user') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data_user->id }}">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="nama">Nama</label>
                          <input type="text" class="form-control" id="nama" name="nama" placeholder="Required" value="{{ $data_user->nama }}" required>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="username">Username</label>
                          <input type="text" class="form-control" id="username" name="username" placeholder="Required" value="{{ $data_user->username }}" required>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="password">Password <small>*Lewati jika tidak akan diubah.</small></label>
                          <input type="password" class="form-control" id="password" name="password" placeholder="" >
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="password_confirmation">Confirm Password <small>*Lewati jika tidak akan diubah.</small></label>
                          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="" >
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label for="level">Level</label>
                          <select name="level" id="level" class="form-control" required>
                            <option value="ADMIN">ADMIN</option>
                            @if(Auth()->user()->level == 'MANAGER')
                            <option value="MANAGER" {{ $data_user->level == 'MANAGER' ? 'selected' : '' }}>MANAGER</option>
                            @endif
                          </select>
                        </div>
                      </div>
                    </div>
                    
                    <div class="float-right">
                      <a href="{{ route('users') }}" class="btn btn-outline-warning"><i class="fas fa-arrow-left"></i> Kembali</a>
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