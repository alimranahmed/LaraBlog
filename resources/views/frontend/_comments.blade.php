@forelse($comments as $comment)
    <div class="row margin-bottom-5">
        <div class="col-sm-12 text-md">
            <b>{{is_null($comment->user) ? 'Someone' : $comment->user->name }}</b>&nbsp;said:
        </div>
        <div class="col-sm-12 text-justify">{{$comment->content}}
            <span class="text-grey">&nbsp;{{$comment->createdAtHuman}}</span>
            <span class="text-primary pointer" data-toggle="modal"
                  data-target="#reply-form"
                  v-on:click="initiateReplyForm({{$comment->id}})">&nbsp;Reply</span>
        </div>
    </div>
    @foreach($comment->replies as $reply)
        <div class="row margin-bottom-5 margin-left-30">
            <div class="col-sm-12 text-md">
                <b>{{is_null($reply->user) ? 'Someone' : $reply->user->name }}</b>&nbsp;replied:
            </div>
            <div class="col-sm-12 text-justify">{{$reply->content}}
                <span class="text-grey">&nbsp;{{$reply->createdAtHuman}}</span>
            </div>
        </div>
    @endforeach
@empty
    <div class="row">
        <div class="col-sm-12">
            <span class="text-grey">No comment yet</span>
        </div>
    </div>
@endforelse
@include('frontend._form_reply')