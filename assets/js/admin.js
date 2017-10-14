 jQuery(document).ready(function($) {
   
     $("#voa_date_payment").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth : true,
        changeYear : true
     });

     //front end assistence user
     $("#voa_date_d").datepicker({
        dateFormat: 'dd-mm-yy'
     });
        //front end assistence user
     $("#voa_date_h").datepicker({
        dateFormat: 'dd-mm-yy'
     })

 
    //filtrar eventos
    $("#filter_event_search").keyup(function(){
        var text_filter = $(this).val();
        $('.event_user_assist').hide();
        $('.event_user_assist').each(function(){
            $(this).find("h3:contains("+text_filter+")").parent().show(0);
        });
    });

    //date desde
    $('#voa_date_d').datepicker().on("input change", function (e) {
        des();
    });
    //date hasta
    $('#voa_date_h').datepicker().on("input change", function (e) {
        des_has();    
    });


    //filtrar por checkbox
    $("#voa_assist_notassist_check").click(function(){
       // des();
        des_has();
        if($(this).is(':checked')==true)
        {
         $('.event_user_assist').each(function(){
            if($(this).is(":visible")==true){
              if($(this).find("h3 span.assist_event").attr("assist")=="yes"){
                  $(this).show(0);
              }else{
                  $(this).hide();
              }
            }
          });

        }else{
           $('.event_user_assist').each(function(){
            if($(this).is(":visible")==true){
              if($(this).find("h3 span.assist_event").attr("assist")=="no"){
                  $(this).show(0);
              }else{
                 $(this).hide();
              }
            }
          });

         }//cierre del if
    });


    //funciones
    function des_has(){
      //DESDE
          date_d = $("#voa_date_d").val();
         date_d = date_d.split('-');
         var newDate_D=date_d[1]+","+date_d[0]+","+date_d[2];
         date_d = parseInt(new Date(newDate_D).getTime());


        //HASTA
         date_h = $("#voa_date_h").val();
         date_h = date_h.split('-');
         var newDate_h=date_h[1]+","+date_h[0]+","+date_h[2];
         date_h = parseInt(new Date(newDate_h).getTime());
          
          $('.event_user_assist').hide();
          $('.event_user_assist').each(function(){
            date_temp = $(this).find("span.article_event_date").text().split("-");
            newDate_temp=date_temp[1]+","+date_temp[0]+","+date_temp[2];
            date_temp = parseInt(new Date(newDate_temp).getTime());
            if(date_temp>=date_d && date_temp<=date_h){
                $(this).show(0);
            }
          });
    }

    //function desde
    function des(){
          date_d = $("#voa_date_d").val();
         date_d = date_d.split('-');
         var newDate_D=date_d[1]+","+date_d[0]+","+date_d[2];
         date_d = parseInt(new Date(newDate_D).getTime());
          $('.event_user_assist').hide();
          $('.event_user_assist').each(function(){
            date_temp = $(this).find("span.article_event_date").text().split("-");
            newDate_temp=date_temp[1]+","+date_temp[0]+","+date_temp[2];
            date_temp = parseInt(new Date(newDate_temp).getTime());
            if(date_temp>=date_d){
                $(this).show(0);
            }
          });
    }


    String.prototype.replaceAll = function(target, replacement) {
      return this.split(target).join(replacement);
    };

 });