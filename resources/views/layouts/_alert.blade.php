@if(session('successMsg'))
    <div class="alert alert-success" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Success! </strong>{{session('successMsg')}}
    </div>
@elseif(session('errorMsg'))
    <div class="alert alert-danger" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Error; </strong>{{session('errorMsg')}}
    </div>
@elseif(session('warningMsg'))
    <div class="alert alert-warning" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>Warning, </strong>{{session('warningMsg')}}
    </div>
@elseif