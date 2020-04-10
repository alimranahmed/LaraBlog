@extends('layouts.admin')
@section('content')
  <div class="panel panel-default no-margin-bottom">
    <div class="panel-heading">
      <strong>All System Configurations</strong>
    </div>
    <div class="panel-body">
      <table class="table table-hover" id="configList">
        <tr class="text-center">
          <th>ID</th>
          <th>Name</th>
          <th>Value</th>
          <th class="text-center">Operations</th>
        </tr>
        @foreach($configs as $config)
          <tr>
            <td>{{$config->id}}</td>
            <td>{{$config->name}}</td>
            <td>{{$config->value}}</td>
            <td class="text-center">
              <span class="fa fa-edit text-primary pointer"
                    onclick="showConfigForm({{$config}})"></span>&nbsp;
            </td>
          </tr>
        @endforeach
      </table>
      <!-- Modal -->
      <div class="modal fade" id="config-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Edit Config</h4>
            </div>
            <form class="form-inline" id="config-form" method="POST">
              <div class="modal-body">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group {{$errors->has('name') ? 'has-error has-feedback' : ''}}">
                  <label>Name</label>
                  <input name="name" placeholder="Name" id="name" class="form-control" disabled
                         value="{{old('name')}}">
                </div>
                <div class="form-group {{$errors->has('value') ? 'has-error has-feedback' : ''}}">
                  <label>Value</label>
                  <input name="value" placeholder="Value" id="value" class="form-control"
                         value="{{old('value')}}">
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
    </div>
  </div>
@endsection

@section('inPageJS')
  @parent
  <script type="application/javascript">
    function showConfigForm(config) {
      $("#name").val(config.name);
      $("#value").val(config.value);
      $("#config-form").attr("action", "config/" + config.id);
      $("#config-modal").modal("show");
    }
  </script>
@endsection
