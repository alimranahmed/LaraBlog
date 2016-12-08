@extends('layouts.admin')
@section('content')
    <table class="table table-hover table-bordered" id="categoryList">
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
                    <span class="fa fa-edit text-primary pointer" v-on:click="showCategoryForm({{$category}})"></span>&nbsp;
                    <a href="{{route('toggle-category-active', $category->id)}}">
                        <span class="fa fa-lg {{$category->is_active ? 'fa-toggle-on text-success' : 'fa-toggle-off text-grey'}}"></span>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
<!-- Modal -->
<div class="modal fade" id="category-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Category</h4>
            </div>
            <form class="form-inline" id="category-form" method="POST">
                <div class="modal-body">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label>Name</label>
                        <input name="name" placeholder="Name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Alias</label>
                        <input name="alias" placeholder="Alias" id="alias" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('inPageJS')
    <script type="application/javascript">
        new Vue({
            el: '#categoryList',
            data: {},
            methods: {
                showCategoryForm: function(category){
                    $("#name").val(category.name);
                    $("#alias").val(category.alias);
                    $("#category-form").attr("action", "category/" + category.id);
                    $("#category-modal").modal("show");
                }
            }
        });
    </script>
@endsection