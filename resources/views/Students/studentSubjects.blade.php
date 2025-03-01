@extends('layouts.dashboardTemp')

@section('title', 'My Subjects')
@section('Pages')
    <span style="font-weight: 500 !important;">My Subjects</span>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
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
                                    <th class="text-start">Subject Name</th>
                                    <th>Units</th>
                                    <th>Schedule</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->subjects as $subject)
                                <tr>
                                    <td>{{ $subject->subject_code }}</td>
                                    <td class="text-start">{{ $subject->name }}</td>
                                    <td>{{ $subject->units }}</td>
                                    <td>{{ $subject->schedule ?? 'TBA' }}</td>
                                    <td>{{ $subject->description }}</td>
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