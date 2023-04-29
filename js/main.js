// Raplace selected text start
function replaceSelectedText(replaceText) {
    
    
    if (replaceText !== '') {
        var range = window.getSelection().getRangeAt(0);
        range.deleteContents(); 

        range.insertNode(document.createTextNode(replaceText));
    }
}
// Replace selected text end

// Word Counter start
function countWords(text){
	text = text.trim();
    text = text.replace(/\s+/g, ' ');
    text = text.split(" ");
    return text.length;
}
// Word Counter End


// parafrasear action code start
jQuery( "#parafrasear_tool_submit" ).click(function() {

    var selection = window.getSelection().toString();
    var lang = jQuery('#parafrasear-lang').val();
    var mode = jQuery('#parafrasear-modes').val();
    var llimit = 2000;

    if(selection == '')
    {
        alert('Seleccione el texto para parafrasear');
    }
    
    
    else
    {
        total_words = countWords(selection);

        if(total_words > llimit)
        {
            alert(`${total_words} palabras seleccionadas. ${llimit} ¡Límite de palabras alcanzado! Intenta reducir algo de texto`);
            return
        }


        var form = new FormData();

        form.append("text", selection);

        var settings = {
            "url": parafrasear_param['pluginsUrl']+"/parafrasear/requests/paraphraseRequest.php",
            "type": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form,
            beforeSend: function() {
                 jQuery('#parafrasear_tool_submit').attr('disabled',true);
                 jQuery('#parafrasear_tool_submit').text('Parafraseando...');
              },
            complete: function() {
                jQuery('#parafrasear_tool_submit').attr('disabled',false);
                jQuery('#parafrasear_tool_submit').text('Parafrasear Texto');
              }
          };
          
          
          
          jQuery.ajax(settings).done(function (response) {
            
            // console.log(response);

            const obj = JSON.parse(response);
                
            if(obj.hasOwnProperty("error")){
              if(obj.error==false){
                // const result  = obj.parafrasear;
                const result  = obj.result;
                replaceSelectedText(result)
                return;
              }
              if(obj.errortype==="empty-input"){
                alert("¡Entrada vacía! Intente ingresar algo de texto en el cuadro de entrada.");
              }
              else if(obj.errortype==="modeerr"){
              }
              else{
                alert("Algo malo paso. Actualiza la página e inténtalo de nuevo.");
              }
              
              return;
              // grecaptcha.reset();
            }
            else{
                const result  = obj.boldResult;
                // jQuery( "#out" ).html(result);
                
                var strippedHtml = result.replace(/<[^>]+>/g, '');


                replaceSelectedText(strippedHtml)
            }
          
          
          });



    }


})