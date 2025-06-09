@extends('layouts.backend.app')

@section('title')
    Data Pembayaran Murid
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
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Data Pembayaran Murid</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i data-feather="home" class="me-1"></i>Dashboard</a></li>
                            <li class="breadcrumb-item active">Data Pembayaran Murid</li>
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
                            <h4 class="card-title">Daftar Pembayaran Murid</h4>
                        </div>
                        <div class="card-datatable p-2">
                            <table class="dt-responsive table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th></th>
                                        <th>No</th>
                                        <th>NISN</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Pembayaran Bulan {{Date('F')}} </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payment as $key => $payments)
                                        <tr>
                                            <td></td>
                                            <td class="text-center">{{$key+1}}</td>
                                            <td>{{$payments->muridDetail->nisn}}</td>
                                            <td>{{$payments->name}}</td>
                                            <td>{{$payments->email}}</td>
                                            <td>
                                              @if (Date('m') == 1)
                                                <span class="badge bg-{{$payments->payment->January == 'paid' ? 'info' : 'warning'}}">{{strtoupper($payments->payment->January)}}</span>
                                              @elseif(Date('m') == 2)
                                                <span class="badge bg-{{$payments->payment->Febuary == 'paid' ? 'info' : 'warning'}}">{{strtoupper($payments->payment->Febuary)}}</span>
                                              @elseif(Date('m') == 3)
                                               <span class="badge bg-{{$payments->payment->March == 'paid' ? 'info' : 'warning'}}">{{strtoupper($payments->payment->March)}}</span>
                                              @elseif(Date('m') == 4)
                                               <span class="badge bg-{{$payments->payment->April == 'paid' ? 'info' : 'warning'}}">{{strtoupper($payments->payment->April)}}</span>
                                              @elseif(Date('m') == 5)
                                                <span class="badge bg-{{$payments->payment->Mey == 'paid' ? 'info' : 'warning'}}">{{strtoupper($payments->payment->Mey)}}</span>
                                              @elseif(Date('m') == 6)
                                                <span class="badge bg-{{$payments->payment->Juny == 'paid' ? 'info' : 'warning'}}">{{strtoupper($payments->payment->Juny)}}</span>
                                              @elseif(Date('m') == 7)
                                                <span class="badge bg-{{$payments->payment->July == 'paid' ? 'info' : 'warning'}}">{{strtoupper($payments->payment->July)}}</span>
                                              @elseif(Date('m') == 8)
                                                <span class="badge bg-{{$payments->payment->August == 'paid' ? 'info' : 'warning'}}">{{strtoupper($payments->payment->August)}}</span>
                                              @elseif(Date('m') == 9)
                                                <span class="badge bg-{{$payments->payment->September == 'paid' ? 'info' : 'warning'}}">{{strtoupper($payments->payment->September)}}</span>
                                              @elseif(Date('m') == 10)
                                                <span class="badge bg-{{$payments->payment->October == 'paid' ? 'info' : 'warning'}}">{{strtoupper($payments->payment->October)}}</span>
                                              @elseif(Date('m') == 11)
                                                <span class="badge bg-{{$payments->payment->November == 'paid' ? 'info' : 'warning'}}">{{strtoupper($payments->payment->November)}}</span>
                                              @elseif(Date('m') == 12)
                                                <span class="badge bg-{{$payments->payment->December == 'paid' ? 'info' : 'warning'}}">{{strtoupper($payments->payment->December)}}</span>
                                              @endif
                                            </td>
                                            <td class="text-center"><span class="badge bg-info">{{$payments->payment->is_active == 1 ? 'ACTIVE' : 'SUSPEND'}}</span></td>
                                            <td class="text-center">
                                                <a href="{{route('spp.murid.detail', $payments->payment->id)}}" class="btn btn-sm btn-success">
                                                    <i data-feather="eye"></i>
                                                </a>
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
</div>
@endsection