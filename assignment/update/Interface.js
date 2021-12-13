$.ajax({
    url: '../XMLStore.xml',
    dataType: 'xml',
    success: function(data){
        $('input[type=radio][name=action]').change(function() {
            if (this.value == 'PUT') {
                $(data).find('store currencies currency').each(function(){
                    console.log($(this).attr('code'));
                })
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

