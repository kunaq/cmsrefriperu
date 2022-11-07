@extends('layouts.refriPeruLayout')

@section('content')
   <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Adminox</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Dashboard 1</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>     
       
            <div class="row">
                <div class="col-xl-4">
                                <div class="card-box">
                                    <h4 class="header-title mb-4">Revenue Comparison</h4>

                                    <!--<div class="text-center">
                                        <h5 class="font-weight-normal text-muted">You have to pay</h5>
                                        <h3 class="mb-3"><i class="mdi mdi-arrow-up-bold-hexagon-outline text-success"></i> 25643 <small>USD</small></h3>
                                    </div>-->

                                    <div class="chart-container" dir="ltr">
                                        <div class="" style="height:300px" id="platform_type_dates_donut"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card-box">
                                    <h4 class="header-title mb-4">Visitors Overview</h4>

                                    <!--<div class="text-center">
                                        <h5 class="font-weight-normal text-muted">You have to pay</h5>
                                        <h3 class="mb-3"><i class="mdi mdi-arrow-down-bold-hexagon-outline text-danger"></i> 5623 <small>USD</small></h3>
                                    </div>-->

                                    <div class="chart-container" dir="ltr">
                                        <div class="" style="height:300px" id="user_type_bar"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="card-box">
                                    <h4 class="header-title mb-4">Goal Completion</h4>

                                    <!--<div class="text-center">
                                        <h5 class="font-weight-normal text-muted">You have to pay</h5>
                                        <h3 class="mb-3"><i class="mdi mdi-arrow-up-bold-hexagon-outline text-success"></i> 12548 <small>USD</small></h3>
                                    </div>-->

                                    <div class="chart-container" dir="ltr">
                                        <div class="chart has-fixed-height" style="height:300px" id="page_views_today"></div>
                                    </div>
                                </div>
                            </div>
            </div>
            <!-- end row -->

        </div> <!-- end container-fluid -->

    </div> <!-- end content -->
@endsection

@push('scripts')

@endpush
