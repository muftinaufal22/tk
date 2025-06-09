@extends('layouts.backend.app')

@section('title')
    Detail Pembayaran Murid
@endsection

@section('content')

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="alert-body d-flex align-items-center">
                <i data-feather="check-circle" class="me-2"></i>
                <strong>{{ $message }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @elseif($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="alert-body d-flex align-items-center">
                <i data-feather="x-circle" class="me-2"></i>
                <strong>{{ $message }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <a href="{{ route('spp.murid.index') }}" class="btn btn-secondary mb-1">
                <i data-feather="arrow-left"></i> Kembali
            </a>
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Detail Pembayaran Murid</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i data-feather="home" class="me-1"></i>Dashboard</a></li>
                            <li class="breadcrumb-item active">Detail Pembayaran {{$payment->user->name}} - {{$payment->user->muridDetail->nisn}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <section>
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Data Pembayaran Murid Tahun {{$payment->year}}</h4>
                        </div>
                        <div class="card-datatable p-2">
                            <table class="dt-responsive table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th></th>
                                        <th>No</th>
                                        <th>Bulan</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Diproses</th>
                                        <th>Diproses Tanggal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payment->detailPayment as $key => $detail)
                                    <tr>
                                        <td></td>
                                        <td class="text-center">{{$key+1}}</td>
                                        <td>{{$detail->month}}</td>
                                        <td>Rp {{number_format($detail->amount)}}</td>
                                        <td class="text-center"><span class="badge bg-{{$detail->status == 'paid' ? 'success' : 'danger'}}">{{$detail->status == 'paid' ? 'Lunas' : 'Belum Lunas'}}</span></td>
                                        <td>{{$detail->aprroveBy->name ?? '-'}}</td>
                                        <td>{{$detail->approve_date ?? '-'}}</td>
                                        <td class="text-center">
                                            @if ($detail->file != null && $detail->status == 'unpaid')
                                                <div class="btn-group" role="group">
                                                    <a href="" class="btn btn-sm btn-success" data-toggle="modal" id="klikModal" data-target="#modalPembayaran"
                                                    data-id="{{$detail->id}}"
                                                    data-name="{{$detail->user->name}}"
                                                    data-nisn="{{$detail->user->muridDetail->nisn}}"
                                                    data-month="{{$detail->month}}"
                                                    data-amount="Rp {{number_format($detail->amount)}}"
                                                    data-sender="{{$detail->sender}}"
                                                    data-banksender="{{$detail->bank_sender}}"
                                                    data-datefile="{{$detail->date_file}}"
                                                    data-destinationbank="{{$detail->destination_bank}}"
                                                    ><i data-feather="check-circle"></i></a>
                                                    <a href="{{$detail->url_file}}" target="_blank" class="btn btn-sm btn-info"><i data-feather="eye"></i></a>
                                                </div>
                                            @elseif($detail->status == 'paid')
                                                <a href="{{$detail->url_file}}" target="_blank" class="btn btn-sm btn-info"><i data-feather="eye"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @include('spp::murid.update')
</div>
@endsection

@section('scripts')
  <script>
    // Tampilkan Data Pada Modal
    $(document).on('click','#klikModal', function(){
        var id = $(this).attr('data-id');
        var nisn = $(this).attr('data-nisn');
        var name = $(this).attr('data-name');
        var month = $(this).attr('data-month');
        var amount = $(this).attr('data-amount');
        var sender = $(this).attr('data-sender');
        var banksender = $(this).attr('data-banksender');
        var datefile = $(this).attr('data-datefile');
        var destinationbank = $(this).attr('data-destinationbank');
        $("#id_payment").val(id)
        $("#nisn").val(nisn)
        $("#name").val(name)
        $("#month").val(month)
        $("#amount").val(amount)
        $("#sender").val(sender)
        $("#banksender").val(banksender)
        $("#datefile").val(datefile)
        $("#destinationbank").val(destinationbank)
    });

    // Proses Update Data Peminjam
    $(document).on('click','#konfirmasiPembayaran', function(){
        var id_payment = $("#id_payment").val();
        $.get('{{Url("spp/murid/update-pembayaran")}}',{'_token': $('meta[name=csrf-token]').attr('content'),id_payment:id_payment}, function(resp){
          $("#id_payment").val('');
          location.reload();
        });
    });
  </script>
@endsection