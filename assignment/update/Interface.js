$.ajax({
    url: 'http://localhost:8080/atwd1/assignment/update/?cur=EUR&action=del',
    dataType: 'text',
    contentType: 'text/plain',
    success: function(data){
    $('input[type=radio][name=action]').change(function() {
        if (this.value == 'PUT') {
                // cm.setValue("");
                // cm.clearHistory();
                $("#response").val(data);
                document.getElementById("response").value = vkbeautify.xml(document.getElementById("response").value);
                CodeMirror.fromTextArea(document.getElementById("response"), {
                  mode: 'application/xml',
                //    theme: 'eclipse',
                  lineNumbers: true,
                  lineWrapping: true,
                  readOnly: true,
                  cursorBlinkRate: -1
                });
                // alert(data);

        }
        else if (this.value == 'DEL') {
            alert(this.value);
        }
    })
    },
    error: function(){
        console.log('ERROR');
    }




});

