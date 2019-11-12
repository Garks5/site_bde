$(document).ready(function() {
    $("#popup1").on("click",afficher);
    $("#accepte").on("click",accepte);
    var valide; 

     function afficher(){
        valide=0; 
        $('#pop-up').css("display","block");
        $('#formulaire').css("display","none");
    }

    function accepte(){
        valide=1; 
        $('#pop-up').css("display","none");
        $('#formulaire').css("display","block");
        if(valide==1){
            $("#inscrit").show();
            $('#popup1').css('display','none');
        }
    }
});