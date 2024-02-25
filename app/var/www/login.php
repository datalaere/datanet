<?php if(!Session::exists('auth')): ?>

<div id="wrapper">
    
    <?php include 'templates/nav.php' ?>  
    <p>USER (<?php echo getVisitorIP(), ") connecting to DATANET (", $_SERVER['SERVER_ADDR'], ") on port ", $_SERVER['SERVER_PORT']; ?> ...</p>
    <div id="terminal">

    </div>
  
    <form name="message">
        <b>></b> <input name="input" type="text" id="input" size="1024" />
    </form>
</div>

<script type="text/javascript">
$(document).ready(function(){

    $("#input").focus();

    $("#input").inputhistory();

  
    //If user submits the form
    $("form").submit(function(e){

        e.preventDefault();

        var client = $("#input").val();
        var oldscrollHeight = $("#terminal").prop("scrollHeight") - 20; //Scroll height before the 

        $.ajax({
            type: "POST",
            url: "server.php?action=login",
            cache: false,
            data: {input: client},
            success: function(data){      

                if(data == 'ok') {

                    window.location = 'index.php?id=terminal';

                } else if (data == 'error') {

                    window.location = 'index.php?id=login';

                } else {

                    $("#terminal").append(data); //Insert chat log into the #terminal div  

                        //Auto-scroll           
                    var newscrollHeight = $("#terminal").prop("scrollHeight") - 20; //Scroll height after the request
                    if(newscrollHeight > oldscrollHeight){
                        $("#terminal").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                    } 
                }   
                              
            },
        });

         $("#input").prop("value", "");

        return false;

    });
    
    //Load the file containing the terminal log
    function loadLog(){     
        var oldscrollHeight = $("#terminal").prop("scrollHeight") - 20; //Scroll height before the request
        $.ajax({
            type: "GET",
            url: "server.php?action=request",
            cache: false,
            success: function(data){     

                $("#terminal").html(data); //Insert chat log into the #terminal div   
                
                //Auto-scroll           
                var newscrollHeight = $("#terminal").prop("scrollHeight") - 20; //Scroll height after the request
                if(newscrollHeight > oldscrollHeight){
                    $("#terminal").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                }               
            },
        });
    }

    setTimeout(loadLog, 2500);


}); 
</script>

<?php else:  header("Location: index.php?id=terminal"); ?>

<?php endif; ?>