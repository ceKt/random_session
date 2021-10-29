$(function() {
  var matching=0;
  
  setInterval(matchcheck,3000);
  
  $("#matchbutton").click(matchstart);
  
  function matchstart(){
    //console.log(document.getElementsByName("contents").id);
    let ci=-1,si=-1;
    for(var i in document.getElementsByName("contents")){
      if(document.getElementsByName("contents").item(i).checked){
        ci=document.getElementsByName("contents").item(i).id;
        si=document.getElementsByName("contents").item(i).value;
        break;
      }
    }
    //console.log(document.getElementById('player_id').value);
    var pi=document.getElementById('player_id').value;
    
    $.ajax({
      type: "post", //HTTP通信の種類
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      url:'/matchstart', //通信したいURL
      //dataType: 'json',
      //contentType: 'application/json',
      //processData: false,
      data:{content_id:ci,session_id:si,player_id:pi}
    })
    //通信が成功したとき
    .done((res)=>{
      console.log(res);
      if(res==1){
        matching=1;
      //console.log(res.message);
      document.getElementById("inputbutton").innerHTML='<button class="btn btn-primary" type="button" id="stopmatch"><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>マッチング中</button>';
      document.getElementById("stopmatch").onclick="";
      document.getElementById("stopmatch").addEventListener("click",matchstop);
      }
    })
    //通信が失敗したとき
    .fail((error)=>{
      console.log(error.statusText);
    });
  }
  
  function matchstop(){
    //console.log("wadwdadw");
    $.ajax({
      type:"get",
      url:"/matchstop",
      dataType:'json'
    })
    .done((res)=>{
      matching=0;
      console.log(res);
      document.getElementById("inputbutton").innerHTML='ID : <input type=text id="player_id">&nbsp;<button type="button" id="matchbutton" class="btn btn-primary">session開始</button>';
      document.getElementById("matchbutton").onclick="";
      document.getElementById("matchbutton").addEventListener("click",matchstart);
    })
    .fail((error)=>{
      console.log(error.statusText);
    });
    
  }
  
  function matchcheck(){ 

      console.log(matching);
      if(matching==1){
        $.ajax({
            type: "get", //HTTP通信の種類
            url:'/matchcheck', //通信したいURL
            dataType:"json"
          })
          //通信が成功したとき
          .done((res)=>{
            if(res["result"]==200){
              window.location.href=res["link"];
            }
            console.log(res["nummatchpeople"]);
            for(let session of res["nummatchpeople"]){
              document.getElementById(session["content_id"]+"/"+session["session_id"]).textContent=session["nummatchpeople"]+"人";
            }
          })
          //通信が失敗したとき
          .fail((error)=>{
            console.log(error.statusText);
          });
      }
  }
});