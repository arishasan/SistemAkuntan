<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped text-sm" width="100%">
        <thead>
            <tr>
                <th class="text-center" width="5%">No.</th>
                <th width="15%">Tanggal</th>
                <th>Keterangan</th>
                <th class="text-right text-success" width="20%"><b>DEBIT</b></th>
                <th class="text-right text-danger" width="20%"><b>KREDIT</b></th>
            </tr>
        </thead>

        <tbody>
            @php
            $tot_debit = 0;
            $tot_kredit = 0;
            @endphp
            @foreach($list_detail as $key => $val)
                <tr>
                    <td class="text-center">{{ $key+1 }}.</td>
                    <td>{{ date('d M Y', strtotime($val['tgl'])) }}</td>
                    <td>{{ $val['keterangan'] }}</td>
                    <td class="text-right text-success text-bold">
                        @if($val['type'] == 'DEBIT')
                        @php
                            $tot_debit += $val['nominal'];
                        @endphp
                        Rp. {{ number_format($val['nominal']) }}
                        @else
                        -
                        @endif
                    </td>
                    <td class="text-right text-danger text-bold">
                        @if($val['type'] == 'KREDIT')
                        @php
                            $tot_kredit += $val['nominal'];
                        @endphp
                        Rp. {{ number_format($val['nominal']) }}
                        @else
                        -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

        <tfooter>
            <tr>
                <th class="text-center" colspan="3">Total</th>
                <th class="text-right text-success"><b>Rp. {{ number_format($tot_debit) }}</b></th>
                <th class="text-right text-danger"><b>Rp. {{ number_format($tot_kredit) }}</b></th>
            </tr>
            <tr>
                @php
                    $percentage_kredit = 0;
                    $percentage_debit = 0;

                    $sisa_debit = ($tot_debit - $tot_kredit);
                    $sisa_kredit = ($tot_kredit - $tot_debit);

                    $rata2 = ($tot_debit + $tot_kredit) / 2;

                    $percentage_debit = ($sisa_debit / $rata2) * 100;
                    $percentage_kredit = ($sisa_kredit / $rata2) * 100;
                @endphp
                <th class="text-center" colspan="3">Perbandingan</th>
                <th class="text-right text-success">
                    <small>Debit <i class="fas fa-arrow-right"></i> Kredit</small> <br/>
                    <b>Rp. {{ number_format(($tot_debit - $tot_kredit)) }}</b> 
                    <!-- <small><b>{{ $percentage_debit }}%</b></small> -->
                </th>
                <th class="text-right text-danger">
                    <small>Kredit <i class="fas fa-arrow-right"></i> Debit</small> <br/>
                    <b>Rp. {{ number_format(($tot_kredit - $tot_debit)) }}</b>
                    <!-- <small><b>{{ $percentage_kredit }}%</b></small> -->
                </th>
            </tr>
        </tfooter>
    </table>
</div>