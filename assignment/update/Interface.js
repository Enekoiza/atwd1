$.ajax({
    url: 'http://localhost:8080/atwd1/assignment/XMLStore.xml',
    dataType: 'text',
    contentType: 'text/plain',
    success: function(data){
    $('input[type=radio][name=action]').change(function() {
      $('#codes').find('option').remove();
      if (this.value == 'PUT')
      {
        $(data).find('currencies').each(function(){
          $(this).find('currency').each(function(){
              var code = $(this).attr('code');
              $('#codes').append('<option value="' + code + '">' + code + '</option>');
          })
        })
      }
      else if ( this.value == 'POST')
      {
        $(data).find('currencies').each(function(){
          $(this).find('currency').each(function(){
              var live = $(this).find("live").text();
              if (live == 0)
              {
                var code = $(this).attr('code');
                $('#codes').append('<option value="' + code + '">' + code + '</option>');
              }

          })
        })
      }
      else if ( this.value == 'DEL')
      {
        $(data).find('currencies').each(function(){
          $(this).find('currency').each(function(){
              var live = $(this).find("live").text();
              if (live == 1)
              {
                var code = $(this).attr('code');
                $('#codes').append('<option value="' + code + '">' + code + '</option>');
              }

          })
        })
      }


    })
    },
    error: function(){
        console.log('ERROR');
    }




});



        // if (this.value == 'PUT') {
        //         // cm.setValue("");
        //         // cm.clearHistory();
        //         $("#response").val(data);
        //         document.getElementById("response").value = vkbeautify.xml(document.getElementById("response").value);
        //         CodeMirror.fromTextArea(document.getElementById("response"), {
        //           mode: 'application/xml',
        //           theme: 'eclipse',
        //           lineNumbers: true,
        //           lineWrapping: true,
        //           readOnly: true,
        //           cursorBlinkRate: -1
        //         });
                

        // }
        // else if (this.value == 'DEL') {
        //     alert(this.value);
        // }