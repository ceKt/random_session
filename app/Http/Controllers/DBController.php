<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Content;
use App\Session;
use App\Comment;
use App\User;
use App\Sessionlist;

class DBController extends Controller
{
    public function home(Request $request){
        if(User::where('user_cookie',$request->session()->getId())->exists()){
            if(User::where('user_cookie',$request->session()->getId())->value("match_id")==1){
                return redirect("/chat");
            }
        }
        $contents = Content::get();
        $sessionlists = Sessionlist::get();
        return view('home')->with([
            "contents"      => $contents,
            "sessionlists"  => $sessionlists
        ]);
    }
    
    public function contents($content_name){
        $contents = Content::get();
        $thiscontent = Content::where('content_name', $content_name)->value('content_id');
        $sessionlists = Sessionlist::where('content_id', $thiscontent)->get();
        return view('content')->with([
            "content_name"  =>$content_name,
            "contents"      => $contents,
            "thiscontent"   => $thiscontent,
            "sessionlists"  => $sessionlists
        ]);
    }
    
    public function make_contents(Request $request){
        if(!Content::where('content_name',$request['content_name'])->exists()){
            Content::create(['content_name' => $request['content_name']]);
        }
        return redirect('/');
    }
    
    public function make_sessionlists1(){
        $contents = Content::get();
        return view('make_sessionlists')->with([
            "contents"      => $contents,
        ]);
    }
    
    public function make_sessionlists2(Request $request){
        Sessionlist::create([
            'content_id'    => $request['content_id'],
            'session_name'  => $request['session_name'],
            'rule'          => $request['rule'],
            'numpeople'     => $request['numpeople']
            ]);
        return redirect('/contents/'.Content::where('content_id',$request['content_id'])->first()['content_name']);
    }
    
    public function delete_sessionlists1(){
        $contents = Content::get();
        $sessionlists=Sessionlist::get();
        return view('/delete_sessionlists')->with([
            "contents"      => $contents,
            "sessionlists"  => $sessionlists,
        ]);
    }
    
    public function delete_sessionlists2(Request $request){
        foreach($request['session_id'] as $req){
            Sessionlist::where('session_id',$req)->delete();
        }
        return redirect('/');
    }
    
    public function match_start(Request $request){
        if($request["player_id"]){
            if(User::where('user_cookie',$request->session()->getId())->exists()){
                $user=User::where('user_cookie',$request->session()->getId())->first();
                Sessionlist::where([['content_id',$user->content_id],['session_id',$user->session_id]])->decrement('nummatchpeople');
                User::where('user_cookie',$request->session()->getId())->delete();
            }
            User::create([
            'user_cookie'   => $request->session()->getId(),
            'content_id'    => $request["content_id"],
            'session_id'    => $request["session_id"],
            'value'         => $request["player_id"],
            ]);
            
            $user=User::where('user_cookie',$request->session()->getId())->first();
            Sessionlist::where([['content_id',$user->content_id],['session_id',$user->session_id]])->increment('nummatchpeople');
            return 1;
        }
        return 0;
    }
    
    public function match_stop(Request $request){
        if(User::where('user_cookie',$request->session()->getId())->exists()){
            $user=User::where('user_cookie',$request->session()->getId())->first();
            Sessionlist::where([['content_id',$user->content_id],['session_id',$user->session_id]])->decrement('nummatchpeople');
            User::where('user_cookie',$request->session()->getId())->delete();
        }
        return 0;
    }
    
    public function match_check(Request $request){
        $res = array("result"=>200,"link"=>"/chat");
        if(User::where('user_cookie',$request->session()->getId())->exists()){
            $user = User::where('user_cookie',$request->session()->getId())->first();
            $userstate=$user->status;
            //return $user;
            if($userstate==1){
                return json_encode($res);
            }
            else{
                $userscount=User::where([['content_id',$user['content_id']],['session_id',$user['session_id']],['status', 0]])->count();
                $sessiondata=Sessionlist::where([['content_id',$user['content_id']],['session_id',$user['session_id']]])->first();
                //return $userscount;
                if($userscount>=$sessiondata['numpeople']){
                    $users=User::where([['content_id',$user['content_id']],['session_id',$user['session_id']],['status', 0]])->get();
                    Sessionlist::where([['content_id',$user->content_id],['session_id',$user->session_id]])->increment('numaccess');
                    Session::create([
                        'content_id'    => $user->content_id,
                        'user'         => $users[0]->user_cookie,
                        ]);
                    
                    $match_id=Session::where('user',$users[0]->user_cookie)->value('match_id');
                    for($i=0;$i<$sessiondata['numpeople'];$i++){
                        $users[$i]->status=1;
                        $users[$i]->match_id=$match_id;
                        $users[$i]->save();
                    }
                    
                    $user=User::where('user_cookie',$request->session()->getId())->first();
                    Sessionlist::where([['content_id',$user->content_id],['session_id',$user->session_id]])->decrement('nummatchpeople',$sessiondata['numpeople']);
                    return json_encode($res);
                }
            }
        }
        $res["result"]=201;
        $res+=array('nummatchpeople'=>Sessionlist::select('content_id','session_id','nummatchpeople')->get());
        return json_encode($res);
    }
    
    function chat_start(Request $request){
        if(User::where('user_cookie',$request->session()->getId())->exists()){
            $user=User::where('user_cookie',$request->session()->getId())->first();
            if($user->match_id!=0){
                $comments=Comment::where('match_id',$user->match_id)->get();
                return view('chat')->with([
                    "comments"      => $comments,
                    "user"          => $user
                ]);
            }
        }
        return redirect('/');
    }
    
    function chat_end(Request $request){
        if(User::where('user_cookie',$request->session()->getId())->exists()){
            $user=User::where('user_cookie',$request->session()->getId())->first();
            if(Session::where('match_id',$user['match_id'])->first()->value('num')<=1){
                Session::where('match_id',$user['match_id'])->delete();
                Comment::where('match_id',$user['match_id'])->delete();
            }
            else{
                Comment::create([
                    "content_id"    =>$user['content_id'],
                    "match_id"      =>$user['match_id'],
                    "sender"        =>$user->value,
                    "comment"       =>$user->value."が退出しました。"
                    ]);
                Session::where('match_id',$user['match_id'])->decrement('num');
            }
            User::where('user_cookie',$request->session()->getId())->delete();
        }
        return 0;
    }
    
    function sendmessage(Request $request){
        
        if($request['message']){
            $user=User::where('user_cookie', $request->session()->getId())->first();
            Comment::create([
                "content_id"    =>$user['content_id'],
                "match_id"      =>$user['match_id'],
                "sender"        =>$user->value,
                "comment"       =>$request['message']
                ]);
        }
        return $user->value;
    }
    
    function chatting(Request $request){
        if(User::where('user_cookie', $request->session()->getId())->exists()){
            $user=User::where('user_cookie', $request->session()->getId())->first();
            $sessiondata=Session::where('match_id',$user['match_id'])->first();
            if(strtotime('now')-strtotime($sessiondata['created_at'])>6000){
                Comment::where('match_id', $user['match_id'])->delete();
                User::where('match_id', $user['match_id'])->delete();
                Session::where('match_id', $user['match_id'])->delete();
            }
            $comments=Comment::where('match_id', $user['match_id'])->get();
            return json_encode(['comments'=>$comments,'user'=>$user->value]);
        }
        return redirect('/');
    }
}
