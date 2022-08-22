@extends('admin.mainlayout')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <form action="{{ route('dashboard-filter') }}" method="POST">
            @csrf
          <div class="row float-sm-right">
            <div class="col-lg-4">
              <div class="form-group">
                <label for="bulan">Periode Bulan</label>
                <select name="bulan" id="bulan" class="form-control" required>
                  <option value="01" {{ ( (isset($bulan) && $bulan == '01' ) || (!isset($bulan) && date('m') == '01') ? 'selected' : '' ) }}>Januari</option>
                  <option value="02" {{ ( (isset($bulan) && $bulan == '02' ) || (!isset($bulan) && date('m') == '02') ? 'selected' : '' ) }}>Februari</option>
                  <option value="03" {{ ( (isset($bulan) && $bulan == '03' ) || (!isset($bulan) && date('m') == '03') ? 'selected' : '' ) }}>Maret</option>
                  <option value="04" {{ ( (isset($bulan) && $bulan == '04' ) || (!isset($bulan) && date('m') == '04') ? 'selected' : '' ) }}>April</option>
                  <option value="05" {{ ( (isset($bulan) && $bulan == '05' ) || (!isset($bulan) && date('m') == '05') ? 'selected' : '' ) }}>Mei</option>
                  <option value="06" {{ ( (isset($bulan) && $bulan == '06' ) || (!isset($bulan) && date('m') == '06') ? 'selected' : '' ) }}>Juni</option>
                  <option value="07" {{ ( (isset($bulan) && $bulan == '07' ) || (!isset($bulan) && date('m') == '07') ? 'selected' : '' ) }}>Juli</option>
                  <option value="08" {{ ( (isset($bulan) && $bulan == '08' ) || (!isset($bulan) && date('m') == '08') ? 'selected' : '' ) }}>Agustus</option>
                  <option value="09" {{ ( (isset($bulan) && $bulan == '09' ) || (!isset($bulan) && date('m') == '09') ? 'selected' : '' ) }}>September</option>
                  <option value="10" {{ ( (isset($bulan) && $bulan == '10' ) || (!isset($bulan) && date('m') == '10') ? 'selected' : '' ) }}>Oktober</option>
                  <option value="11" {{ ( (isset($bulan) && $bulan == '11' ) || (!isset($bulan) && date('m') == '11') ? 'selected' : '' ) }}>November</option>
                  <option value="12" {{ ( (isset($bulan) && $bulan == '12' ) || (!isset($bulan) && date('m') == '12') ? 'selected' : '' ) }}>Desember</option>
                </select>
              </div>
              </div>
              <div class="col-lg-4">
              <div class="form-group">
                <label for="tahun">Periode Tahun</label>
                <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Required" value="{{ isset($tahun) ? $tahun : date('Y') }}" required>
              </div>
              </div>
              <div class="col-lg-4">
              <div class="form-group">
                <label for="username">Aksi</label>
                <button type="submit" class="btn btn-outline-primary form-control"><i class="fas fa-search"></i> Terapkan</button>
              </div>
              </div>
            </div>
          </form>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row" {{ Auth()->user()->level == 'ADMIN' ? 'hidden' : '' }}>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1">Rp</span>

            <div class="info-box-content">
              <span class="info-box-text">Saldo Kas Aktif</span>
              <span class="info-box-number">
                Rp. {{ number_format($kas_aktif) }}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-arrow-left"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pengeluaran Bulan <b>{{ App\Models\HelperModel::getNamaBulan($bulan ?? date('m')) }}</b></span>
              <span class="info-box-number">Rp. {{ number_format($pengeluaran) }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-arrow-right"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pemasukan Bulan <b>{{ App\Models\HelperModel::getNamaBulan($bulan ?? date('m')) }}</b></span>
              <span class="info-box-number">Rp. {{ number_format($pemasukan) }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-receipt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Piutang Bulan <b>{{ App\Models\HelperModel::getNamaBulan($bulan ?? date('m')) }}</b></span>
              <span class="info-box-number">Rp. {{ number_format($piutang) }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row" {{ Auth()->user()->level == 'ADMIN' ? 'hidden' : '' }}>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Chart Pemasukan & Pengeluaran Bulan <b>{{ App\Models\HelperModel::getNamaBulan($bulan ?? date('m')) }}</b></h5>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center">
                    <strong>Periode: {{ date('01 M, Y', strtotime( (isset($bulan) ? $tahun.'-'.$bulan : date('Y-m')) )) }} - {{ date('t M Y', strtotime( (isset($bulan) ? $tahun.'-'.$bulan : date('Y-m')) )) }}</strong>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <div class="chart">
                    <canvas id="barChart" style="min-height: 450px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>
                    </div>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- ./card-body -->
            
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">10 Pemesanan Terakhir</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                  <tr>
                    <th>Kode Pesanan</th>
                    <th>Nama Pemesan</th>
                    <th>Tipe</th>
                    <th>Nominal</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($pemesanan as $val)
                  <tr>
                    <td>{{ $val->kode_pesanan }}</td>
                    <td>{{ $val->nama_pemesan }}</td>
                    <td>
                    <span class="badge badge-{{ $val->tipe_pesanan == 'BAYAR' ? 'success' : 'danger' }}">{{ $val->tipe_pesanan }}</span>
                    </td>
                    <td>Rp. {{ number_format($val->total_pembayaran) }}</td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <!-- <div class="card-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
            </div> -->
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
          <!-- PRODUCT LIST -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">5 Produk Terakhir Yang Ditambahkan</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                
                @foreach($produk as $val)
                <li class="item">
                  <div class="product-img">
                    <img src="{{ asset('assets') }}/dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title">{{ $val->kode_produk }}
                      <span class="badge badge-warning float-right">Rp. {{ number_format($val->harga) }}</span></a>
                    <span class="product-description">
                    {{ $val->nama }}
                    </span>
                  </div>
                </li>
                @endforeach

              </ul>
            </div>
            <!-- /.card-body -->
            <!-- <div class="card-footer text-center">
              <a href="javascript:void(0)" class="uppercase">View All Products</a>
            </div> -->
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('scriptplus')

<!-- AdminLTE for demo purposes -->
<!-- <script src="{{ asset('assets') }}/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{ asset('assets') }}/dist/js/pages/dashboard2.js"></script> -->

<script src="{{ asset('assets') }}/plugins/chart.js/Chart.min.js"></script>

<script>

function loadGraph(){

let parse = JSON.parse('<?= $chart ?>');

let label = [];
let kredit = [];
let debit = [];
$.each(parse, function(i, o){
    label.push(o.label);
    kredit.push(o.nominal_pengeluaran);
    debit.push(o.nominal_pemasukan);
});

var areaChartData = {
  labels  : label,
  datasets: [
    {
      label               : 'Pemasukan',
      backgroundColor     : 'rgba(60,141,188,0.9)',
      borderColor         : 'rgba(60,141,188,0.8)',
      pointRadius          : false,
      pointColor          : '#3b8bba',
      pointStrokeColor    : 'rgba(60,141,188,1)',
      pointHighlightFill  : '#fff',
      pointHighlightStroke: 'rgba(60,141,188,1)',
      data                : debit
    },
    {
      label               : 'Pengeluaran',
      backgroundColor     : 'rgba(210, 214, 222, 1)',
      borderColor         : 'rgba(210, 214, 222, 1)',
      pointRadius         : false,
      pointColor          : 'rgba(210, 214, 222, 1)',
      pointStrokeColor    : '#c1c7d1',
      pointHighlightFill  : '#fff',
      pointHighlightStroke: 'rgba(220,220,220,1)',
      data                : kredit
    },
  ]
}

//-------------
//- BAR CHART -
//-------------
var barChartCanvas = $('#barChart').get(0).getContext('2d')
var barChartData = $.extend(true, {}, areaChartData)
var temp0 = areaChartData.datasets[0]
var temp1 = areaChartData.datasets[1]
barChartData.datasets[0] = temp0;
barChartData.datasets[1] = temp1;

var barChartOptions = {
  responsive              : true,
  maintainAspectRatio     : false,
  datasetFill             : false,
  tooltips: {
       callbacks: {
           label: function(tooltipItem, data) {
              var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];

              lastHoveredDataIndex = tooltipItem.datasetIndex;
                lastHoveredIndex = tooltipItem.index;

              value = value.toString();
              value = value.split(/(?=(?:...)*$)/);
              value = value.join(',');
              return value;
           }
       }
     }, 
     scales: {
        yAxes: [{
           ticks: {
              beginAtZero:true,
              userCallback: function(value, index, values) {
                 value = value.toString();
                 value = value.split(/(?=(?:...)*$)/);
                 value = value.join(',');
                 return value;
              }
           }
        }],
        xAxes: [{
           ticks: {
           }
        }]
     },
     
     
}

new Chart(barChartCanvas, {
  type: 'bar',
  data: barChartData,
  options: barChartOptions,
  
})

}

$(function () {

loadGraph();

});

</script>

@endsection