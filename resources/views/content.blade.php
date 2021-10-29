@extends('layouts.main')

@section('content_title')
    {{$content_name}}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-2 text-center">
            <div class="list-group">
                <div class="list-group-item list-group-item-action active" aria-current="true">
                    Contents List
                </div>
                @foreach($contents as $content)
                    <tr>
                        <a href="/contents/{{$content->content_name}}" class="list-group-item list-group-item-action">{{$content->content_name}}</a>
                    </tr>
                @endforeach
            </div>
            <a class="d-flex justify-content-end" href="/make_contents">
                ＋コンテンツ追加
            </a>
        </div>
        <div class="col-8 text-center">
            <div id="inputbutton">ID : <input type=text id="player_id">&nbsp;<button type="button" id="matchbutton" class="btn btn-primary">session開始</button></div>
            <table class="table bg-light">
                <thead>
                    <tr>
                        <th scope="col">セッション名</th>
                        <th scope="col">ルール</th>
                        <th scope="col">必要人数</th>
                        <th scope="col">待ち人数</th>
                    </tr>
                </thead>
                <tbody>
                    </div>
                    @foreach($sessionlists as $sessionlist)
                        <tr>
                            <td><div class="form-check">
                                @if($sessionlist===$sessionlists[0])
                                <input class="form-check-input" type="radio" name="contents" id="{{$sessionlist->content_id}}" value="{{$sessionlist->session_id}}" checked>
                                @else
                                <input class="form-check-input" type="radio" name="contents" id="{{$sessionlist->content_id}}" value="{{$sessionlist->session_id}}">
                                @endif
                                <label class="form-check-label" for="{{$sessionlist->content_id}}">{{$sessionlist->session_name}}</label>
                            </div></td>
                            <td>{{$sessionlist->rule}}</td>
                            <td>{{$sessionlist->numpeople}}人</td>
                            <td><p id="{{$sessionlist->content_id}}/{{$sessionlist->session_id}}">{{$sessionlist->nummatchpeople}}人</p></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a class="d-flex justify-content-end" href="/make_sessionlists">
                ＋セッション追加
            </a>
        </div>
        <div class="col-sm text-center">
            c
        </div>
    </div>
</div>
@endsection