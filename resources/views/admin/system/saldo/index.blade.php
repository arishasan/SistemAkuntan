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
              Update Saldo Kas
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">System</a></li>
              <li class="breadcrumb-item active">Update Saldo Kas</li>
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
                  
                  <form action="{{ route('update-saldo-now') }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label for="bulan">Periode Bulan</label>
                          <select name="bulan" id="bulan" class="form-control" required>
                            <option value="01" {{ date('m') == '01' ? 'selected' : '' }}>Januari</option>
                            <option value="02" {{ date('m') == '02' ? 'selected' : '' }}>Februari</option>
                            <option value="03" {{ date('m') == '03' ? 'selected' : '' }}>Maret</option>
                            <option value="04" {{ date('m') == '04' ? 'selected' : '' }}>April</option>
                            <option value="05" {{ date('m') == '05' ? 'selected' : '' }}>Mei</option>
                            <option value="06" {{ date('m') == '06' ? 'selected' : '' }}>Juni</option>
                            <option value="07" {{ date('m') == '07' ? 'selected' : '' }}>Juli</option>
                            <option value="08" {{ date('m') == '08' ? 'selected' : '' }}>Agustus</option>
                            <option value="09" {{ date('m') == '09' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ date('m') == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ date('m') == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ date('m') == '12' ? 'selected' : '' }}>Desember</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label for="tahun">Periode Tahun</label>
                          <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Required" value="{{ date('Y') }}" required>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label for="nominal_saldo">Nominal Saldo</label>
                          <input type="text" class="form-control currency text-right" id="nominal_saldo" name="nominal_saldo" placeholder="Required" value="{{ number_format($saldo_bulan_ini->nominal ?? 0, 0, ".", ",") }}" required>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label for="username">Aksi</label>
                          <button type="submit" class="btn btn-outline-primary form-control"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                      </div>
                    </div>

                  </form>

                  <br/>

                  <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="table" width="100%">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th>Periode</th>
                                <th class="text-right">Nominal Saldo</th>
                                <th class="text-center">Terakhir Diupdate</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($data_saldo as $val)
                        <tr class="{{ date('m-Y') == $val->periode ? 'bg-success' : '' }}">
                            <td><center><i class="fas fa-database"></i></center></td>
                            <td>{{ \App\Models\HelperModel::convertBulanTahunIndo($val->periode) }}</td>
                            <td class="text-right"><b>Rp. {{ number_format($val->nominal) }}</b></td>
                            <td><center>{{ date('d M Y, H:i:s', strtotime($val->updated_at)) }}</center></td>
                        </tr>
                        @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th width="5%"></th>
                                <th>Periode</th>
                                <th class="text-right">Nominal Saldo/Modal</th>
                                <th class="text-center">Terakhir Diupdate</th>
                            </tr>
                        </tfoot>
                    </table>
                  </div>

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

    $('#table').DataTable();

  });
</script>

@endsection