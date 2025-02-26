@extends('layouts.dashboardTemp')

@section('title', 'Student Dashboard')
@section('Pages')
    <span style="font-weight: 500 !important;">Student Dashboard</span>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Enrolled Subjects Card -->
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="stats-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Subjects</p>
                                <h5 class="font-weight-bolder">{{ $enrolledSubjects->count() }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <i class="ni ni-book-bookmark text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrolled Subjects Table -->
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="text-white">My Enrolled Subjects</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Schedule</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enrolledSubjects as $subject)
                                <tr>
                                    <td>{{ $subject->subject_code }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->schedule ?? 'TBA' }}</td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-success">Enrolled</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
