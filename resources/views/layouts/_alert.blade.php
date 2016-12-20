<div class="alert alert-success" id="success-alert" style="display: {{session('successMsg') ? "block" : "none"}};">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Success! </strong><span id="success-msg">{{session('successMsg')}}</span>
</div>
<div class="alert alert-danger" id="error-alert" style="display: {{session('errorMsg') ? "block" : "none"}};">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Error; </strong><span id="error-msg">{{session('errorMsg')}}</span>
</div>
<div class="alert alert-warning" id="warning-alert" style="display: {{session('warningMsg') ? "block" : "none"}};">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Warning, </strong><span id="warning-msg">{{session('warningMsg')}}</span>
</div>