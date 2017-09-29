 jQuery(document).ready(function($) {
     $("#voa_date_assistance").datepicker({
        dateFormat: 'dd-mm-yy'
     });

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
          date_d = parseInt(date_d.replaceAll('-',''));
        //HASTA
          date_h = $("#voa_date_h").val();
          date_h = parseInt(date_h.replaceAll('-',''));
          
          $('.event_user_assist').hide();
          $('.event_user_assist').each(function(){
            date_temp = parseInt($(this).find("span.article_event_date").text().replaceAll('-',''));
            if(date_temp>=date_d && date_temp<=date_h){
                $(this).show(0);
            }
          });
    }

    //function desde
    function des(){
          date_d = $("#voa_date_d").val();
          date_d = parseInt(date_d.replaceAll('-',''));
          $('.event_user_assist').hide();
          $('.event_user_assist').each(function(){
            date_temp = parseInt($(this).find("span.article_event_date").text().replaceAll('-',''));
            if(date_temp>=date_d){
                $(this).show(0);
            }
          });
    }


    String.prototype.replaceAll = function(target, replacement) {
      return this.split(target).join(replacement);
    };

 });