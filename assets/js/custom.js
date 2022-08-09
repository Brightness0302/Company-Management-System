$(function () {
    var refresh = navigationType();
    var pathname = window.location.pathname;

    //console.log(pathname);

    function navigationType() {

        var result;
        var p;

        if (window.performanceNavigation) {
            result = window.performanceNavigation;
            if (result == 255) {
                result = 4
            }
        }

        if (window.performance.getEntriesByType("navigation")) {
            p = window.performance.getEntriesByType("navigation")[0].type;

            if (p == 'navigate') {
                result = 0
            }
            if (p == 'reload') {
                result = 1
            }
            if (p == 'back_forward') {
                result = 2
            }
            if (p == 'prerender') {
                result = 3
            }
        }
        return result;
    }

    /*if(refresh == 1) {
        
        var url = pathname.split("/").slice(-2).join("/");
        var fullurl = 'http://10.11.11.6/protoarch/web' + '/page/' + url;

        $("#loadcontent").load(fullurl);
        $('.side-header').addClass('side-header-hide');
        $('.hamburguer-btn .hamburguer').addClass('mysidebarmenuother');
        $('#mylogo').attr('src', 'http://10.11.11.6/protoarch/web/images/logo/proto-arch-logo-dark.png');
        $('#mylogo').attr('height', '80px');
        $('#mylogo').hide();

        setTimeout(
            function () {
                $('#maincontainer').removeClass('container-fluid');
                $('#maincontainer').addClass('container');
                $('#mylogo').show();
            }, 500);

        //$('.side-header').addClass('side-header-hide');
        //$('.hamburguer-btn .hamburguer').addClass('mysidebarmenuother');
        //$('#mylogo').attr('src', 'http://10.11.11.6/protoarch/web/images/logo/proto-arch-logo-dark.png');
        //$('#mylogo').hide();
    } /*else if(refresh == 2) {
        var url = pathname.split("/").slice(-2).join("/");
        var fullurl = 'http://10.11.11.6/protoarch/web' + '/page/' + url;

        $("#loadcontent").load(fullurl);
        $('.side-header').addClass('side-header-hide');
        $('.hamburguer-btn .hamburguer').addClass('mysidebarmenuother');
        $('#mylogo').attr('src', 'http://10.11.11.6/protoarch/web/images/logo/proto-arch-logo-dark.png');
        $('#mylogo').hide();

        setTimeout(
            function () {
                $('#maincontainer').removeClass('container-fluid');
                $('#maincontainer').addClass('container');
                $('#mylogo').show();
            }, 500);
    }*/



    //console.log('Satus:' + refresh);

    $(".gotlink").click(function (e) {
        e.preventDefault();

        var href = $(this).attr('href');
        var url = 'http://10.11.11.6/protoarch/web' + '/page/' + href;
        console.log(url);

        window.history.pushState('obj', 'PageTitle', href);

        $("#loadcontent").load(url);
        $('.side-header').addClass('side-header-hide');
        $('.hamburguer-btn .hamburguer').addClass('mysidebarmenuother');
        $('#mylogo').attr('src', 'http://10.11.11.6/protoarch/web/images/logo/proto-arch-logo-dark.png');
        $('#mylogo').attr('height', '80px');
        $('#mylogo').hide();
        $('#maincontainer').removeClass('intromenuback');

        setTimeout(
            function () {
                $('#maincontainer').removeClass('container-fluid');
                $('#maincontainer').addClass('container');
                
                $('#mylogo').show();
            }, 500);

    });


    $(".tooglemore").click(function(){
        $(".tooglemoredata").toggle();
      });

  


 



});