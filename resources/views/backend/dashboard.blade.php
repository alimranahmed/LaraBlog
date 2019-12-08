@extends('layouts.admin')
@section('content')
  <div class="panel panel-default no-margin-bottom">
    <div class="panel-heading">
      <strong>Welcome to Admin portal!</strong>
    </div>
    <div class="panel-body">
      {{--Latest comments--}}
      <div class="col-sm-4">
        <div class="panel panel-default no-margin-bottom">
          <div class="panel-heading">
            <strong>Latest comments</strong>
          </div>
          <div class="panel-body">
            <table class="table">
              <tr>
                <th class="text-left">#</th>
                <th class="text-left">Comment</th>
                <th class="text-left">User</th>
              </tr>
              @foreach($latestComments as $key => $comment)
                <tr>
                  <td>{{++$key}}</td>
                  <td>{{mb_substr($comment->content, 0, 20)}}...<br>
                    <span class="text-muted">{{$comment->createdAtHuman}}</span>
                  </td>
                  <td>{{$comment->user->name}}<br>({{$comment->user->email}})</td>
                </tr>
              @endforeach
            </table>
            <a href="{{route('comments')}}">View all</a>
          </div>
        </div>
      </div>

      {{--Latest feedbacks--}}
      <div class="col-sm-4">
        <div class="panel panel-default no-margin-bottom">
          <div class="panel-heading">
            <strong>Latest Feedbacks</strong>
          </div>
          <div class="panel-body">
            <table class="table">
              <tr>
                <th class="text-left">#</th>
                <th class="text-left">Comment</th>
                <th class="text-left">User</th>
              </tr>
              @foreach($latestFeedbacks as $key => $feedback)
                <tr>
                  <td>{{++$key}}</td>
                  <td>{{mb_substr($feedback->content, 0, 20)}}...<br>
                    <span class="text-muted">{{$feedback->createdAtHuman}}</span>
                  </td>
                  <td>{{$feedback->name}}<br>({{$feedback->email}})</td>
                </tr>
              @endforeach
            </table>
            <a href="{{route('feedbacks')}}">View all</a>
          </div>
        </div>
      </div>


      {{--Article by category--}}
      <div class="col-sm-4">
        <div class="panel panel-default no-margin-bottom">
          <div class="panel-heading">
            <strong>Article by Category</strong>
          </div>
          <div class="panel-body">
            <table class="table">
              <tr>
                <th class="text-left">Category Name</th>
                <th class="text-left">Total Article</th>
              </tr>
              @foreach($articleCategories as $categoryName => $articles)
                <tr>
                  <td>{{$categoryName}}</td>
                  <td>
                    <a href="{{route('admin-articles', ['category' => $articles->first()->category_id])}}">
                      {{count($articles)}}
                    </a>
                  </td>
                </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
