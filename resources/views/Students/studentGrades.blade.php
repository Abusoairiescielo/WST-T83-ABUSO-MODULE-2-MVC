@extends('layouts.dashboardTemp')

@section('title', 'My Grades')
@section('Pages')
    <span style="font-weight: 500 !important;">My Grades</span>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="text-white">My Grades</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Midterm</th>
                                    <th>Finals</th>
                                    <th>Average</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->subjects as $subject)
                                    @php
                                        $grade = $student->grades->where('subject_id', $subject->id)->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $subject->subject_code }}</td>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $grade->midterm ?? 'N/A' }}</td>
                                        <td>{{ $grade->finals ?? 'N/A' }}</td>
                                        <td>{{ $grade->average ?? 'N/A' }}</td>
                                        <td>
                                            @if($grade)
                                                <span class="badge badge-sm bg-gradient-{{ $grade->remarks === 'Passed' ? 'success' : 'danger' }}">
                                                    {{ $grade->remarks }}
                                                </span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Pending</span>
                                            @endif
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