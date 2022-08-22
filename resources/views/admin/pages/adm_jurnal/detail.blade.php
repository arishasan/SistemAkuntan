<div class="row">
    <div class="col-lg-12">
        
        <div class="card">
            <div class="card-header">
                Jurnal Information
            </div>
            <div class="card-body">
            <div class="form-group">
                <label>Kode Jurnal</label><br/>
                {{ $data_jurnal->kode_jurnal }}
            </div>
            <div class="form-group">
                <label for="">Tgl. Jurnal</label><br/>
                {{ date('d M Y', strtotime($data_jurnal->tgl_jurnal)) }}
            </div>
            <div class="form-group">
                <label for="">Keterangan</label><br/>
                <p>{!! $data_jurnal->keterangan !!}</p>
            </div>
            </div>
        </div>

    </div>
    <div class="col-lg-12">

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

                @foreach($det_jurnal as $key => $val)

                @php

                $warna = '';
                if($val->type == 'PEMASUKAN'){
                    $warna = 'bg-success';
                }else if($val->type == 'PENGELUARAN'){
                    $warna = 'bg-danger';
                }else if($val->type == 'PIUTANG'){
                    $warna = 'bg-warning';
                }else if($val->type == 'PIUTANG DIBAYAR'){
                    $warna = 'bg-primary';
                }else{
                    $warna = '';
                }

                $keterangan = '-';
                $tgl = '-';
                $nominal = '-';

                if($val->type == 'PEMASUKAN'){
                    
                    $get_pemasukan = App\Models\PemasukanModel::where('id', $val->id_table)->first();
                    if(null !== $get_pemasukan){
                        $keterangan = $get_pemasukan->keterangan;
                        $tgl = date('d M Y', strtotime($get_pemasukan->tgl_pemasukan));
                        $nominal = number_format($get_pemasukan->nominal);
                    }

                }else if($val->type == 'PENGELUARAN'){
                    
                    $get_pengeluaran = App\Models\PengeluaranModel::where('id', $val->id_table)->first();
                    if(null !== $get_pengeluaran){
                        $keterangan = $get_pengeluaran->keterangan;
                        $tgl = date('d M Y', strtotime($get_pengeluaran->tgl_pengeluaran));
                        $nominal = number_format($get_pengeluaran->nominal);
                    }

                }else if($val->type == 'PIUTANG'){

                    $get_piutang = App\Models\PiutangModel::where('id', $val->id_table)->first();
                    
                    if(null !== $get_piutang){
                        $getTRX = App\Models\PemesananModel::find($get_piutang->id_pesanan);
                        $kode = '-';
                        if(null !== $getTRX){
                            $kode = $getTRX->kode_pesanan;
                        }
                        $keterangan = 'Hutang Transaksi Dengan Kode Pemesanan : '.$kode;
                        $tgl = date('d M Y', strtotime($get_piutang->periode));
                        $nominal = number_format($get_piutang->nominal);
                    }

                }else if($val->type == 'PIUTANG DIBAYAR'){
                    
                    $piutang_dibayar = App\Models\PiutangModel::where('id', $val->id_table)->first();
                    
                    if(null !== $piutang_dibayar){
                        $getTRX = App\Models\PemesananModel::find($piutang_dibayar->id_pesanan);
                        $kode = '-';
                        if(null !== $getTRX){
                            $kode = $getTRX->kode_pesanan;
                        }
                        $keterangan = 'Bayar Hutang Transaksi Dengan Kode Pemesanan : '.$kode;
                        $tgl = date('d M Y', strtotime($piutang_dibayar->periode));
                        $nominal = number_format($piutang_dibayar->nominal);
                    }

                }else{

                }

                @endphp

                <tr class="text-sm {{ $warna }}">
                    <td class="text-center">{{ ($key+1) }}.</td>
                    <td>{{ $keterangan }}</td>
                    <td class="text-center"><b>{{ $val->type }}</b></td>
                    <td class="text-center"><b>{{ $tgl }}</b></td>
                    <td class="text-right"><b>Rp. {{ $nominal }}</b></td>
                </tr>

                @endforeach

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