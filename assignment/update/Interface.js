$.ajax({
    url: 'http://localhost:8080/atwd1/assignment/update/?cur=EUR&action=del',
    dataType: 'text',
    success: function(data){
    $('input[type=radio][name=action]').change(function() {
        if (this.value == 'PUT') {
                // console.log(data));
                var xmlDoc = jQuery.parseXML(data);
                $("#response").val(xmlDoc);
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

