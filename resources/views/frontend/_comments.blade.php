@forelse($comments as $comment)
    @php
        $commenterName = is_null($comment->user) ? 'Someone' : $comment->user->name;
        if($comment->user && $article->user_id == $comment->user->id){
            $commenterName .= '(Author)';
        }
    @endphp
    <div class="row margin-bottom-5">
        <div class="col-sm-12 text-md">
            <b>{{ $commenterName }}</b>&nbsp;said:
        </div>
        <div class="col-sm-12 text-justify">{{$comment->content}}
            <span class="text-grey">&nbsp;{{$comment->createdAtHuman}}</span>
            <span class="text-primary pointer" data-toggle="modal"
                  data-target="#reply-form"
                  v-on:click="initiateReplyForm({{$comment->id}})">&nbsp;Reply</span>
        </div>
    </div>
    @foreach($comment->replies as $reply)
        @php
            $commenterName = is_null($reply->user) ? 'Someone' : $reply->user->name;
            if($reply->user && $article->user_id == $reply->user->id){
                $commenterName .= '(Author)';
            }
        @endphp
        <div class="row margin-bottom-5 margin-left-30">
            <div class="col-sm-12 text-md">
                <b>{{$commenterName }}</b>&nbsp;replied:
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