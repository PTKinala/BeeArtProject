@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h1 class="text-white">การจัดการสมาชิก</h1>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="fs-3">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="fs-5 table-bordered">
                    @<?php
                    $i = 1;
                    ?>
                    @foreach ($users as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $item->name . ' ' . $item->lname }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <a href="{{ url('view-user/' . $item->id) }}" class="btn btn-primary">View</a><br>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
