 $('.btn_custom').on('click', function(){
            $('.navbar_small_links').toggle(400);
        });

        $('.navbar_links li').on('click', function(){
            var base = "/";
            window.location = base+$(this).attr('href');
        });

    
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-87323177-1', 'auto');
      ga('send', 'pageview');

  $(function () {
  
    $(".rateyo").rateYo();
    $(".rateyo-readonly-widg").each(function() {
      var item = $(this);
    item.rateYo({
         rating: item.data('rating'),
          numStars: 5,
          precision: 2,
          minValue: 1,
          maxValue: 5
        }).on("rateyo.set", function (e, data) {
          console.log($(this).parent());

            var item_id = e.currentTarget.id;
            var rating = data.rating; 
            var url = "rating";

            $.ajax({
                method: "POST",
                data: {item : item_id, data: rating},
                url: url,
                success:function(response) {
                    if(response == 0){
                        alert("Can't rate!");
                    }else{
                        alert("Thanks For Rating!");
                    }
                },
                error:function(data) {
                    console.log('error');
                    console.log(data);
                }
            });            
        });
    });
    });

  $(function(){
    $('.languages').on('change', function(){

       var lang = $('.languages option:selected').val();
        var url = "/language";
        $.post(url,{'lang':lang}, function(data){
            location.reload();
        });
    });
  });

  $(function(){
    $('a').on('click',function(){
      if($(this).attr('post')){
        var data = {
          url:$(this).attr('url-redirect'),
          post:$(this).attr('post') };
        
          $.ajax({
            url:'site/review',
            data: data,
            method:"POST",
            success:function(data){
            console.log(data, "success");
            },
            error:function(data){
              console.log(data,'error');
            }
          });
      }
      return false;

    });
  });