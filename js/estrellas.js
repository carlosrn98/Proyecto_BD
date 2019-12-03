$(document).ready(function(){
    // Check Radio-box
    $(".rating input:radio").attr("checked", false);

    $('.rating input').click(function () {
        $(".rating span").removeClass('checked');
        $(this).parent().addClass('checked');
        var userRating = this.value;

        $("input[type=radio]").attr('disabled', true);

        var params="idP="+usuario+"&idL="+lugar+"&cali="+userRating;

        url='./califica.php';

        $.ajax({
          url: url,
          dataType: 'html',
          type: 'POST',
          async: true,
          data: params,
          success:muestraContenido,
          error: funcionErrors
        });
        console.log(params);
        return true;
    });
    function muestraContenido(result, status, xhr){
      console.log(result);
    }

    function funcionErrors(xhr, status, error){
      alert(xhr);
    }
});
