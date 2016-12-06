@extends('layouts.admin')
@section('content')
    <table class="table table-hover table-bordered">
        <tr class="text-center">
            <th>ID</th>
            <th>Name</th>
            <th>Alias</th>
            <th>Created</th>
            <th>Articles</th>
            <th class="text-center">Operations</th>
        </tr>
        @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->alias}}</td>
                <td>{{$category->createdAtHuman}}</td>
                <td>
                    <a href="{{route('articles-by-category', $category->alias)}}">{{$category->articles->count()}}</a>
                </td>
                <td class="text-center">
                    <span class="fa fa-edit text-primary" onclick="showCategoryForm()"></span>&nbsp;
                    <a href="{{route('toggle-category-active', $category->id)}}">
                        <span class="fa fa-lg {{$category->is_active ? 'fa-toggle-on text-success' : 'fa-toggle-off text-grey'}}"></span>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
<!-- Modal -->
<div class="modal fade" id="category-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    function showCategoryForm(){
        $("#category-form").modal('show');
    }
</script>