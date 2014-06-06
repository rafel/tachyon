 $(document).ready(function(){

    $.getJSON( "?controller=user&action=userRole", function( data ) {
        setCookie("userRole",data.userrole,1);
        setCookie("userID",data.id,1);
    });    


  toastr.options = {
    "closeButton": true,
    "debug": false,
    "positionClass": "toast-top-full-width",
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "10000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  };

  $("#registerForm").submit( function () {  
  console.log("post");  
    $.post(
     '?controller=user&action=register',
      $(this).serialize(),
      function(data){
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-full-width",
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "10000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          };
        if(data.status == "error"){
          toastr.error(data.msg);
          $("#registerFormContainer").css('border', '1px solid #CC181E'); 
          $("#registerFormContainer").css('box-shadow','inset 0 1px 3px rgba(0,0,0,0.05),0 0 8px rgba(82,168,236,0.6)');
        }
        else {
          toastr.success(data.msg);
          $('html, body').animate({
              scrollTop: $("#loginForm").offset().top - 150
          }, 500);
          $("#loginForm .username").val($("#registerForm #username").val());
          $("#loginForm .password").val($("#registerForm .password").val());
          $("#loginForm .button").val("Continue...");
          $("#loginForm .button").addClass("greenButton");
          $("#loginFormContainer").css('border', '1px solid #67AE34'); 
          $("#registerFormContainer").css('border', 'none'); 
          $("#loginFormContainer").css('box-shadow','inset 0 1px 3px rgba(0,0,0,0.05),0 0 8px rgba(82,168,236,0.6)');
        }
      }
    );
    return false;   
  });   
 $("#loginForm").submit( function () {  
  //console.log("post");  
    $.post(
     '?controller=user&action=login',
      $(this).serialize(),
      function(data){
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-full-width",
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "10000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          };
        if(data.status == "error"){
          toastr.error(data.msg);
          $("#loginFormContainer").css('border', '1px solid #CC181E'); 
          $("#loginFormContainer").css('box-shadow','inset 0 1px 3px rgba(0,0,0,0.05),0 0 8px rgba(82,168,236,0.6)');
        }
        else {
          document.location.href = "?controller=user";
        }
      }
    );
    return false;   
  });

/*
 $('#profileInfoContainer').on(
    'drop',
    function(e){
      console.log(e);
              e.originalEvent.stopPropagation();
        e.originalEvent.preventDefault();
            e.preventDefault();
                e.stopPropagation();
        if(e.originalEvent.dataTransfer){
            if(e.originalEvent.dataTransfer.files.length) {
                e.preventDefault();
                e.stopPropagation();
                upload(e.originalEvent.dataTransfer.files);
            }   
        }
         e.originalEvent.stopPropagation();
        e.originalEvent.preventDefault();
    }
  );
  $('#profileInfoContainer').on(
    'dragover',
    function(e) {
       var dt = e.originalEvent.dataTransfer;
        if(dt.types != null && (dt.types.indexOf ? dt.types.indexOf('Files') != -1 : dt.types.contains('application/x-moz-file'))) {
          console.log(e);
          console.log(dt.types.indexOf('Files'));
        }else {
          e.preventDefault();
          e.stopPropagation(); 
        }
    }
  )
  $('#profileInfoContainer').on(
      'dragenter',
      function(e) {
        //console.log(e);
          e.preventDefault();
          e.stopPropagation();
      }
  )*/





 $("#profileImage").on('drop',function(e){
    //e.stopPropagation();
   // e.preventDefault();
   // $(this).html('A file was dropped!');
    //console.log(e);
     //var dt = e.originalEvent;
     //console.log(dt);
    e.preventDefault();
     var files = e.originalEvent.dataTransfer.files;
      $("#profileImage").removeClass("hover");
      alert("File detected:" + files[0].name + " ,\nShowing sample image");
      $("#profileImage").attr("src","uploads/photo.jpg");
  }).on('dragover', function (e) {
    var dt = e.originalEvent.dataTransfer;
    if(dt.types != null && (dt.types.indexOf ? dt.types.indexOf('Files') != -1 : dt.types.contains('application/x-moz-file'))) {
      $("#profileImage").addClass("hover");
    }
   // e.preventDefault();
     e.stopPropagation();
     e.preventDefault();
  }).on('dragleave', function (e) {
    $("#profileImage").removeClass("hover");
    //e.preventDefault();
     e.stopPropagation();
     e.preventDefault();
  });

  function handleFileUpload(files){
    console.log(files[0].name);
  }

  $("#editprofile").click(function(e){
    $(".profileForm").toggle();
    $(".passwordForm").toggle();
    //$('html, body').animate({
      //        scrollTop: $(".infobox").offset().top - 75
        //  }, 500);
  });
  $("#name").keyup(function (e) {
    $("#profileFullname").html($("#name").val());
  });
  $("#title").keyup(function (e) {
     $("#profileTitle").html($("#title").val());
  });

  $("#thecomment").keyup(function (e) {
     if (e.keyCode == 13) {
          $(this).parent().find("#postCommentForm").submit();
      }
  });

  $("#thepost").keyup(function (e) {
    var thepost = $("#thepost").val();
    if(thepost.length>10){
      /*$("#postContent").animate({
        height: "100px"
      }, 100 );*/

      if(((thepost.length / 10) % 10) % 1 == 0){
        $.post(
           '?controller=post&action=save',
            $(this).serialize(),
            function(data){
              if(data.status == "error"){
                toastr.error(data.msg);
                $("#postForm").css('border', '1px solid #CC181E'); 
                $("#postForm").css('box-shadow','inset 0 1px 3px rgba(0,0,0,0.05),0 0 8px rgba(82,168,236,0.6)');
              }
              else {
                console.log("autoSave " + data.msg);
              }
            }
          );
      }
      if (e.keyCode == 13) {
          $("#postForm").submit();
      }
    }
    else {
      /* $("#postContent").animate({
        height: "60px"
      }, 100 );*/
       $.post(
           '?controller=post&action=reset',
            $(this).serialize(),
            function(data){
              if(data.status == "error"){
                toastr.error(data.msg);
                $("#postForm").css('border', '1px solid #CC181E'); 
                $("#postForm").css('box-shadow','inset 0 1px 3px rgba(0,0,0,0.05),0 0 8px rgba(82,168,236,0.6)');
              }
              else {
                console.log("reset " + data.msg);
              }
            }
          );

    }
});


  $("#postForm").submit( function () {
    var thepost = $("#thepost").val();
    console.log(thepost);
    if(thepost.length>10){
      $.post(
       '?controller=post&action=post',
        $(this).serialize(),
        function(data){
          if(data.status == "error"){
            toastr.error(data.msg);
            $("#postForm").css('border', '1px solid #CC181E'); 
            $("#postForm").css('box-shadow','inset 0 1px 3px rgba(0,0,0,0.05),0 0 8px rgba(82,168,236,0.6)');
            console.log(data);
          }
          else {
            $("ul.posts").prepend('<li><div class="postcontainer"><div class="userimage"><img class="profilePic img" width ="50px" alt="" src="uploads/photo.gif"></div><div class="postinfo"><div class="postheader"><span class="postauthor">Rafel Saad</span><span class="postuser"><a href="#">@rafel</a></span><span class="postdate">Feb 28</span></div><div class="postcontent">'+ thepost +'</div><div class="postfooter"><a href="#">View comments</a></div></div></div></li>');
            $("#thepost").val("");
           /* $("#postContent").animate({
        height: "60px"
      }, 100 );*/
          }
        }
      );
    }
    return false;   
  });

  if($('ul.posts').length != 0){
    var url = "?controller=post&action=getPosts"
    if(getParameterByName("userid").length > 0){
      url = "?controller=post&action=getPosts&userid="+getParameterByName("userid");
      console.log(getParameterByName("userid"));
    }
   $.getJSON( url, function( data ) {
      //console.log(data);
      var regexp = new RegExp('#([^\\s]*)','g');
      for(var i in data) {
       $("ul.posts").append('<li id="post-id-'+ data[i].id +'"><div class="postcontainer"><div class="userimage"><img class="profilePic img" width ="50px" alt="" src="uploads/'+ ((data[i].photo!=null) ? data[i].photo : 'photo.gif')  +'"></div><div class="postinfo"><div class="postheader"><span class="postauthor">'+ ((data[i].name!=null) ? data[i].name : '')  +'</span><span class="postuser"><a href="?controller=user&userid='+ data[i].userid +'">@'+ data[i].username +'</a></span><span class="postdate" title="'+ data[i].created +'">'+ data[i].created +'</span></div><div class="postcontent">'+ data[i].content.replace(regexp,'<a href="?controller=user#!/search/$1">#$1</a>') +'</div><div class="postfooter"><a class="viewComment link" onclick="viewComments('+data[i].id+')">View comments ('+ data[i].commentnr +')</a>'+  ((getCookie("userRole")=="admin") ? ' <a style="float:right;" class="link" onclick="removePost('+data[i].id+')">X<a>' : '') +'</div></div></div></li>');
      }
      jQuery("span.postdate").timeago();
    });
  }

$(".viewComment").click(function(){
    var li = $(this).closest("li");
    console.log(li);
    console.log("s");
  });

   if($('#thepost').length != 0){
     $.getJSON( "?controller=post&action=getTemp", function( data ) {
        if(data.status == "success"){
          $('#thepost').val(data.msg);
        /*  $("#postContent").animate({
        height: "100px"
      }, 100 );*/
        }
      });
    }
$(".removePost").click(function(){
  alert("No changes was made, this is just a dummy sample");
});

$(".dummy").click(function(){
  alert("No changes was made, this is just a dummy sample");
});

  if(getParameterByName("userid").length > 0){
     if(getCookie("userID")!=getParameterByName("userid")){
      $("#sidebar #profileInfoContainer").css("background","#999");
      $("#editprofile").remove();
     }
     else {
      $("#profileImage").hover(
  function() {
       $(".imgHover").show();
        },
  function() {
     $(".imgHover").hide();
  }
);
     }
  }else {
    $("#profileImage").hover(
  function() {
       $(".imgHover").show();
        },
  function() {
     $(".imgHover").hide();
  }
);
  }


$("#search").keyup(function (e) {
    var sform = $("#search");
    var result = $("#searchResult");
    if($('#search').val().length > 0){
      var pos = sform.position();
      pos.top = 35;
      result.css(pos);
      result.width(sform.width());
      result.show();
    }else {
    result.hide();
    }
  });

  $(".setMenu").click(function (){
    var sform = $(".setMenu");
    var result = $("#settingMenu");
    var pos = sform.position();
    pos.top = 55;
    pos.left = pos.left - 20 - ( result.width() / 2 );
    result.css(pos);
    result.toggle();

  });

 $("#postCommentForm").submit( function (event) {
   /*   e.originalEvent.stopPropagation();
  e.originalEvent.preventDefault();
  e.preventDefault();
    e.stopPropagation();*/
    var thepost= $(this).find("#thecomment").val();
    var postid = $(this).find("#postid");
    console.log(postid);


    if(thepost.length>10){
      $.post(
       '?controller=post&action=comment',
        $(this).serialize(),
        function(data){
          if(data.status == "error"){
            toastr.error(data.msg);
            $("#postForm").css('border', '1px solid #CC181E'); 
            $("#postForm").css('box-shadow','inset 0 1px 3px rgba(0,0,0,0.05),0 0 8px rgba(82,168,236,0.6)');
            console.log(data);
          }
          else {
            $("#post-id-"+ postid +" ul.postComments").prepend('<li><div class="postcontainer"><div class="userimage"><img class="profilePic img" width ="50px" alt="" src="uploads/photo.jpg"></div><div class="postinfo"><div class="postheader"><span class="postauthor">Rafel Saad</span><span class="postuser"><a href="#">@rafel</a></span><span class="postdate">Feb 28</span></div><div class="postcontent">'+ thepost +'</div><div class="postfooter"><a href="#">View comments</a></div></div></div></li>');
            $("#post-id-"+ postid +" #thecomment").val("");
           /* $("#postContent").animate({
        height: "60px"
      }, 100 );*/
          
        }
      }
      );
    }


    return false; 
  });

 

});

    function viewComments(id){
      var li = $("#post-id-"+ id);
      var isOpen = li.find(".commentForm");
      if(isOpen.length > 0){
        var postComs = li.find(".postComments");
        isOpen.remove();
        postComs.remove();
      }else {
        var commentForm = li.append('<div class="commentForm"></div>').find(".commentForm");
        commentForm.html('<div id="postContent" class="commentContent"><form id="postCommentForm" method="post" action="?controller=post&action=comment"><input value="'+id+'" type="hidden" name="postid"><div class="postcontainer commentcontainer"><div class="userimage"><img class="profilePic img" width ="50px" alt="" src="uploads/photo.gif"></div><div class="postinfo postcommentinfo"><textarea type="text" value="" id="thecomment" class="simple-form thecomment" placeholder="Write your comment to @rafel" name="thecomment"></textarea></div></div><div id="submitPost"><input class="button right" value="Share" type="submit" name="submit"></div></form></div>');
        $.getJSON( "?controller=post&action=getComments&postID="+id, function( data ) {
            var regexp = new RegExp('#([^\\s]*)','g');
            var list = li.append('<ul class="postComments"></ul>').find('ul');
            for(var i in data) {
               list.append('<li id="comment-id-'+ data[i].id +'"><div class="postcontainer"><div class="userimage"><img class="profilePic img" width ="50px" alt="" src="uploads/photo.gif"></div><div class="postinfo"><div class="postheader"><span class="postauthor">Rafel Saad</span><span class="postuser"><a href="?controller=user#!/user/'+ data[i].username +'">@'+ data[i].username +'</a></span><span title="'+data[i].created+'" class="postdate">'+data[i].created+'</span></div><div class="postcontent">'+ data[i].content.replace(regexp,'<a href="?controller=user#!/search/$1">#$1</a>') +'</div><div class="postfooter"><a class="viewComment link" onclick="#">Like</a></div></div></div></li>');
            }
            jQuery("span.postdate").timeago();
            /*li.append('<ul class="postComments">');
            for(var i in data) {
             li.append('<li id="post-id-'+ data[i].id +'"><div class="postcontainer"><div class="userimage"><img class="profilePic img" width ="50px" alt="" src="uploads/photo.gif"></div><div class="postinfo"><div class="postheader"><span class="postauthor">Rafel Saad</span><span class="postuser"><a href="?controller=user#!/user/'+ data[i].username +'">@'+ data[i].username +'</a></span><span class="postdate">Feb 28</span></div><div class="postcontent">'+ data[i].content.replace(regexp,'<a href="?controller=user#!/search/$1">#$1</a>') +'</div><div class="postfooter"><a class="viewComment link" onclick="viewComments('+data[i].id+')">View comments</a></div></div></div></li>');
            }
            li.append('</ul>');*/
        });
      }
    }

   function removePost(id){
      $.getJSON( "?controller=post&action=removePost&postid="+id, function( data ) {
        if(data.status == "error"){
           toastr.error(data.msg);
            console.log(data);
        }
        else {
            var li = $("#post-id-"+ id);
            li.remove();
            toastr.success(data.msg);

        }
       
      });
    }

    function setCookie(cname,cvalue,exdays)
    {
    var d = new Date();
    d.setTime(d.getTime()+(exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    function getCookie(cname)
    {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) 
      {
      var c = ca[i].trim();
      if (c.indexOf(name)==0) return c.substring(name.length,c.length);
      }
    return "";
    }

    function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}