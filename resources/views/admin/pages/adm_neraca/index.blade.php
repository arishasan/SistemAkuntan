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
              Administrasi Neraca
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Administrasi</a></li>
              <li class="breadcrumb-item active">Neraca</li>
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

                <form action="{{ route('adm_neraca_filter') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="form-group">
                                        <label>Periode Tahun</label>
                                        <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Required" value="{{ $tahun ?? date('Y') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button class="btn btn-outline-primary btm-sm form-control"><i class="fas fa-search"></i> Tampilkan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <!-- BAR CHART -->
                <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Chart Neraca Saldo Tahun <b>{{ $tahun ?? date('Y') }}</b></h3><br/><small>Klik salah satu chart bar untuk melihat detail.</small>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                    <canvas id="barChart" style="min-height: 450px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->


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

<!-- ChartJS -->
<script src="{{ asset('assets') }}/plugins/chart.js/Chart.min.js"></script>

<script>

var lastHoveredDataIndex = null;
var lastHoveredIndex = null;

function loadGraph(){

    let parse = JSON.parse('<?= $data_neraca ?>');

    let kredit = [];
    let debit = [];
    $.each(parse, function(i, o){
        kredit.push(o.kredit);
        debit.push(o.debit);
    });

    var areaChartData = {
      labels  : ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
      datasets: [
        {
          label               : 'Total Debit',
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
          label               : 'Total Kredit',
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

    var clickOnChart = function(bulan){
        let tahun = $('#tahun').val();

        let bln = '';
        if(bulan == 'Januari'){
            bln = '01';
        }else if(bulan == 'Februari'){
            bln = '02';
        }else if(bulan == 'Maret'){
            bln = '03';
        }else if(bulan == 'April'){
            bln = '04';
        }else if(bulan == 'Mei'){
            bln = '05';
        }else if(bulan == 'Juni'){
            bln = '06';
        }else if(bulan == 'Juli'){
            bln = '07';
        }else if(bulan == 'Agustus'){
            bln = '08';
        }else if(bulan == 'September'){
            bln = '09';
        }else if(bulan == 'Oktober'){
            bln = '10';
        }else if(bulan == 'November'){
            bln = '11';
        }else if(bulan == 'Desember'){
            bln = '12';
        }else{
            bln = '';
        }

        $('body').addClass('loading');

        let link = "{{ url('administrasi/neraca/get_detail/') }}/"+bln+'/'+tahun;
        $.get(link, function(res){

            $('#holder_detail').html(res);
            $('body').removeClass('loading');
            $('#title_modal').html("Detail Neraca Saldo Periode <i class='fas fa-arrow-right'></i> <b>"+bulan+" " +tahun+"</b>");
            $('#modal_detail').modal('show');

        });

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
         onClick: function(e, items){
            if ( items.length == 0 ) return; //Clicked outside any bar.
            eff = items[0];
            var x_value = this.data.labels[eff._index];

            clickOnChart(x_value);
        }
         
         
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