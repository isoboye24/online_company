@extends('admin.admin_master')
@section('admin')

<div class="content">
    <!-- Start Content-->
    <div class="container-xxl">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">All Sliders</h5>
                        <a href="{{ route('admin.backend.sliders.create') }}" class="btn btn-success">Add Slider</a>
                    </div><!-- end card header -->


                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap ">
                            <thead>
                                <tr>
                                    <!-- <th>Sl</th> -->
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Link</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sliders as $key=> $item)
                                <tr>
                                    <!-- <td>{{ $key+1 }}</td> -->
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td> <img src="{{ asset($item->image) }}" style="width:70px; height:40px;"> </td>
                                    <td>{{ $item->link }}</td>
                                    <td class="">
                                        <a href="#" class="btn btn-warning btn-sm"><i class="fa-solid fa-eye"></i></a>
                                        <a href="{{route('admin.backend.sliders.edit', $item->id)}}"
                                            class="btn btn-success btn-sm"><i class="fa-solid fa-pencil"></i></a>
                                        <form action="{{ route('admin.backend.sliders.destroy', $item->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" id="delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>

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
