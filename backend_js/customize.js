//js sent to wp every time the color picker value is modified
(function($,log ){

    wp.customize('header_background',function(value){
        value.bind(function(newVal){
            console.log("Entête change",newVal);
            $(".navbar").css("background",newVal);
            



        })
    })

})(jQuery,console.log)

