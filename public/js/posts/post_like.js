$(document).ready(function() {     
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.like_post').click(function(){    
        var id = $(this).data('id');
        var c = $('#'+this.id+'-bs3').html();
        var cObjId = this.id;
        var cObj = $(this);

        $.ajax({
        type:'POST',
        url:'/posts/like',
        data:{id:id},
        success:function(data,status){
                if(data.liked){
                    $(cObj).addClass('liked');
                    $('#'+cObjId+'-bs3').html(parseInt(c)+1);
                }
                else {
                    $(cObj).removeClass('liked');
                    $('#'+cObjId+'-bs3').html(parseInt(c)-1);
                }
            
            }
        });
    }); 
}); 
