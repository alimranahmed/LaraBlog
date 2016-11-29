@forelse($comments as $comment)
    <div class="row margin-bottom-5">
        <div class="col-sm-12 text-md">
            <b>{{is_null($comment->user) ? 'Someone' : $comment->user ->name }}</b>&nbsp;said:
        </div>
        <div class="col-sm-12 text-justify">{{$comment->content}}
            <span class="text-grey">&nbsp;{{$comment->createdAtHuman}}</span>
        </div>
    </div>
@empty
    <div class="row">
        <div class="col-sm-12">
            <span class="text-grey">No comment yet</span>
        </div>
    </div>
@endforelse