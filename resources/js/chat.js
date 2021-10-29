$(function() {
  let chats=[];
  setInterval(chatting,2000);
  
  function chatting(){
      $.ajax({
          type:"get",
          url:"/chat/chatting",
          dataType:'json'
        })
        .done((res)=>{
            //console.log(chats);
            if(chats.length!=res["comments"].length){
                var chat_content="";
                for(var i=chats.length;i<res["comments"].length;i++){
                    var message=res["comments"][i];
                    if(message["sender"]==res["user"]){
                        chat_content+='<p><div class="d-flex justify-content-end">'+message["sender"]+'</div>';
                        chat_content+='<div class="d-flex justify-content-end bg-light">'+message["comment"]+'</div></p>';
                    }
                    else{
                        chat_content+='<p><div class="d-flex justify-content-start">'+message["sender"]+'</div>';
                        chat_content+='<div class="d-flex justify-content-start bg-light">'+message["comment"]+'</div></p>';
                    }
                    
              }
              document.getElementById("chat_content").innerHTML+=chat_content;
              chats=res["comments"];
            }
          console.log(res);
        })
        .fail((error)=>{
          console.log(error.statusText);
        });
  }
  
  $("#sendmessage").click(function(){
    $.ajax({
      type: "post",
      url:'/chat/send_message',
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      data:{
          message:document.getElementById("message").value,
      }
    })
    .done((res)=>{
      console.log(res);
    })
    .fail((error)=>{
      console.log(error.statusText);
    });
  });
  
  $("#endchat").click(function(){
    if(window.confirm('退出しますか？')){
      $.ajax({
        type: "post",
        url:'/chat/chat_end',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:{
            message:document.getElementById("message").value,
        }
      })
      .done((res)=>{
        window.location.href="/"
        console.log(res);
      })
      .fail((error)=>{
        console.log(error.statusText);
      });
    }
  });
});