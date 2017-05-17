$(function(){
      $('#search').val('');
      $(window).click(function(event) {
        $('.search_results').css('display','none');
      });
      $('#search, .search_results li').click(function(e) {
        e.stopPropagation();
      });
      $('#search').keyup(function(event) {
        event.stopPropagation();
        $.ajax({
          url: 'config/search_action.php',
          type: 'post',
          data: $("form").serialize(),
          success: function(responseText,status,xhr){
            console.log(responseText);
            if (responseText != ''){
              $('.search_results').css('display','block');
              $('.search_results').html(responseText);
            } else {
              $('.search_results').html("<li>没有搜索到</li>");
            }

          }
        })
        .done(function() {
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
        ;
      });
    });