(function($){

    $(document).ready(function(){
        
        let page;
        page = window.location.href;

        let contents;
        contents = "";

        if(page.indexOf("kategori") !== -1){

            let interval;
            interval = setInterval(function(){

                if($("#main .headcontent-wrapper #head-content").length > 0){

                    clearInterval(interval);
                    setDefaults(0);

                }

            }, 10);

            $(document).on("click", "#sorting-options-form .row #delta-offer", function(){

                let category;
                category = "";

                $(this).parents("#main").find("#breadcrumbs li").each(function(){

                    category += $(this).find("span > span").text().replace("Anasayfa", "").trim() + " ";

                });

                Swal.fire({

                    confirmButtonText: "Özel Sipariş İste",
                    showCancelButton: true,
                    cancelButtonText: "İptal"

                }).then((result) => {
                    
                    (result.isConfirmed) ? sendMail($(".swal2-popup .swal2-content form"), category, $("#image-url").text().trim()) : console.log("denied!");

                });

                $(".swal2-popup .swal2-content").html("<form></form>");
                $(".swal2-popup .swal2-content form").load("https://dev.digitalfikirler.com/delta_form/form.php", function(){
                
                    if($("#image-url").length > 0){

                        $("#form-delta #header").before($('<div class="row d-flex justify-content-center"><img src="' + $("#image-url").text().trim() + '" class="img-fluid"/></div>'));
    
                    }
                    $("#form-delta #body .container .item:eq(0)").before($(contents));

                    let auth;
                    auth = (typeof visitor !== "undefined" && typeof visitor.name !== "undefined" && visitor.name !== "") ? visitor.name : false;

                    if(auth !== false){

                        auth += (typeof visitor !== "undefined" && typeof visitor.surname !== "undefined" && visitor.surname !== "") ? " " + visitor.surname : false;

                    }
                    
                    (auth !== false) ? $("#form-delta #body .container #auth").val(auth) : $("#form-delta #body .container #auth").attr("disabled", false).removeClass("disabled");

                    (typeof visitor !== "undefined" && typeof visitor.mail !== "undefined" && visitor.mail !== "") ? $("#form-delta #body .container #email").val(visitor.mail) :  $("#form-delta #body .container #email").attr("disabled", false).removeClass("disabled");

                    (typeof visitor !== "undefined" && typeof visitor.phone !== "undefined" && visitor.phone !== "") ? $("#form-delta #body .container #phone").val(visitor.phone) :  $("#form-delta #body .container #phone").attr("disabled", false).removeClass("disabled");
                    // $("#form-delta #body .container #firm").val();

                });

            });

        }

        /*if(page.indexOf("/urun/d200-1102080") !== -1){

            let interval;
            interval = setInterval(function(){

                if($(".product-left .product-extra-details #columns-and-tolerances").length > 0){

                    clearInterval(interval);
                    setDefaults(1);

                }

            }, 10);

            $(document).on("click", ".product-left .product-buttons-wrapper .product-buttons-row #delta-offer", function(){

                Swal.fire({

                    confirmButtonText: "Özel Sipariş İste",
                    showCancelButton: true,
                    cancelButtonText: "İptal"

                }).then((result) => {
                    
                    (result.isConfirmed) ? sendMail($(".swal2-popup .swal2-content form")) : console.log("denied!");

                });

                $(".swal2-popup .swal2-content").html("<form></form>");
                $(".swal2-popup .swal2-content form").load("https://dev.digitalfikirler.com/delta_form/form.php", function(){
                
                    if($("#image-url").length > 0){

                        $("#form-delta #header").before($('<div class="row d-flex justify-content-center"><img src="' + $("#image-url").text().trim() + '" class="img-fluid"/></div>'));
    
                    }
                    $("#form-delta #body .container .item:eq(0)").before($(contents));

                    let auth;
                    auth = (typeof visitor !== "undefined" && typeof visitor.name !== "undefined" && visitor.name !== "") ? visitor.name : false;

                    if(auth !== false){

                        auth += (typeof visitor !== "undefined" && typeof visitor.surname !== "undefined" && visitor.surname !== "") ? visitor.surname : false;

                    }
                    
                    (auth !== false) ? $("#form-delta #body .container #auth").val(auth) : $("#form-delta #body .container #auth").attr("disabled", false).removeClass("disabled");
                    // $("#form-delta #body .container #firm").val();

                });

            });

        }*/

        if(page.indexOf("/Ozel-Olcu-Form") !== -1){

            $("head").append("<style>#main_category, #alt_category_1, #alt_category_2{ border: solid #9E0045; }</style>")

            $("#main").html(null);

            $.ajax({url: "https://dev.digitalfikirler.com/delta_form/queries.php", type: "POST", data: { proggress: 0 }, success: function(response){

                response = JSON.parse(response);
                $("#main").append($(response));

            }});

            $(document).on("change", "#main #main_category", function(){

                contents = "";

                let value;
                value = $(this).val();

                ($("#alt_category_1").length > 0) ? $("#alt_category_1").parent().remove() : false;
                ($("#alt_category_2").length > 0) ? $("#alt_category_2").parent().remove() : false;
                ($("#form-delta").length > 0) ? $("#form-delta").parent().remove() : false;

                $.ajax({url: "https://dev.digitalfikirler.com/delta_form/queries.php", type: "POST", data: { proggress: 1, value: value }, success: function(response){

                    response = JSON.parse(response);
                    $("#main").append($(response));

                }});

            });

            $(document).on("change", "#main #alt_category_1", function(){

                contents = "";

                let value;
                value = $(this).val();

                ($("#alt_category_2").length > 0) ? $("#alt_category_2").parent().remove() : false;
                ($("#form-delta").length > 0) ? $("#form-delta").parent().remove() : false;

                $.ajax({url: "https://dev.digitalfikirler.com/delta_form/queries.php", type: "POST", data: { proggress: 2, value: value }, success: function(response){

                    response = JSON.parse(response);
                    $("#main").append($(response));

                }});

            });

            $(document).on("change", "#main #alt_category_2", function(){

                contents = "";

                let value;
                value = $(this).val();

                ($("#head-content").length > 0) ? $("#head-content").remove() : false;
                ($("#form-delta").length > 0) ? $("#form-delta").parent().remove() : false;

                $.ajax({url: "https://dev.digitalfikirler.com/delta_form/queries.php", type: "POST", data: { proggress: 3, value: value }, success: function(response){

                    $("#main").append($(response));
                    $("#main").append('<form class="mt-5"></form>');

                    let interval;
                    interval = setInterval(function(){

                        if($("#main #head-content").length > 0){

                            clearInterval(interval);
                            setDefaults();

                            $("#main form").load("https://dev.digitalfikirler.com/delta_form/form.php", function(){

                                $("head").append(`<style>
                                    #form-delta #header .row { padding: 35px 0 20px 0; font-size: 11pt; font-weight: 600; border-bottom: solid 1px; margin: 0 0 15px 0; text-align:center; }
                                    #form-delta #body .item { margin-top: 10px; }
                                    @media screen and (max-width: 576px) {
                                        form { overflow: hidden; overflow-x: auto; }
                                        #form-delta { min-width: 500px }
                                    }
                                </style>`);
                
                                if($("#image-url").length > 0){

                                    $("#form-delta #header").before($('<div class="row d-flex justify-content-center"><img src="' + $("#image-url").text().trim() + '" class="img-fluid"/></div>'));
                
                                }

                                $("#form-delta #body .container .item:eq(0)").before($(contents));

                                let auth;
                                auth = (typeof visitor !== "undefined" && typeof visitor.name !== "undefined" && visitor.name !== "") ? visitor.name : false;

                                if(auth !== false){

                                    auth += (typeof visitor !== "undefined" && typeof visitor.surname !== "undefined" && visitor.surname !== "") ? " " + visitor.surname : false;

                                }
                                
                                (auth !== false) ? $("#form-delta #body .container #auth").val(auth) : $("#form-delta #body .container #auth").attr("disabled", false).removeClass("disabled");

                                (typeof visitor !== "undefined" && typeof visitor.mail !== "undefined" && visitor.mail !== "") ? $("#form-delta #body .container #email").val(visitor.mail) :  $("#form-delta #body .container #email").attr("disabled", false).removeClass("disabled");

                                (typeof visitor !== "undefined" && typeof visitor.phone !== "undefined" && visitor.phone !== "") ? $("#form-delta #body .container #phone").val(visitor.phone) :  $("#form-delta #body .container #phone").attr("disabled", false).removeClass("disabled");

                                $("#form-delta").append('<div class="row d-flex justify-content-end mt-5 pr-3" id="buttons"><a href="javascript:void(0)" class="btn btn-primary">Özel Sipariş İste</a></div>')

                            });

                        }

                    }, 10);

                }});

            });

            $(document).on("click", "#form-delta #buttons a", function(){
                
                let category;
                category = $(this).parents("#main").find("#main_category").find("option:selected").text() + " ";
                category += $(this).parents("#main").find("#alt_category_1").find("option:selected").text() + " ";
                category += $(this).parents("#main").find("#alt_category_2").find("option:selected").text();

                sendMail($(this).parents("form"), category, $("#image-url").text().trim());
    
            });

        }

        function setDefaults(pageType) {

            if(pageType == 0){

                $("#sorting-options-form .row").append($('<a href="javascript:void(0);" class="btn btn-primary" id="delta-offer" style="border-radius: 0;">TEKLİF OLUŞTUR</a>'));

            }
            else if(pageType == 1){

                $(".product-left .product-buttons-wrapper .product-buttons-row").append($('<a href="javascript:void(0);" class="add-to-cart-button w-100 mt-3" id="delta-offer" style="border-radius: 0;">TEKLİF OLUŞTUR</a>'));

            }

            if($("#columns-and-tolerances").length > 0){

                $("#columns-and-tolerances").find(".col-12").each(function(){

                    let array;
                    array = $(this).text().split("|");
                    
                    contents += '<div class="row d-flex align-items-center item">';
                    
                    for (let index = 0; index < array.length; index++) {
                        
                        let array2;
                        array2 = array[index].split(":");

                        if(index == 0){

                            contents += '<div class="col-4 d-flex justify-content-center"><label for="title">' + array2[1] + '</label></div>';
                            contents += '<div class="col-4 d-flex justify-content-center"><input type="text" class="form-control value" placeholder="Değer"></div>';

                        }
                        else{

                            contents += '<div class="col-4 d-flex justify-content-center text-center"><input class="form-control text-center tolerance disabled" value="' + array2[1] + '"></input></div>';

                        }
                        
                        
                    }
                    
                    contents += "</div>";

                });

                contents += '<div class="row d-flex align-items-baseline item"><div class="col-12 d-flex justify-content-end">';
                contents += '<div class="form-check d-flex"><input class="form-check-input" type="checkbox" id="standart-tolerance" checked>';
                contents += '<label class="form-check-label" for="standart-tolerance">Standart toleransları kullan</label></div>';
                contents += '</div></div>';

            }
            
            if($("#options").length > 0){

                let options;
                options = $("#options").text().replace(/\s/g, '').split("|")[1].split(",");
                
                if(options[0] == "YağKanalı"){

                    contents += '<div class="row d-flex align-items-baseline item"><div class="col-4 d-flex justify-content-center">';
                    contents += '<label for="title">Yağ Kanalı</label></div><div class="col-4 d-flex justify-content-center">';
                    contents += '<div class="d-flex align-items-center form-check p-0 m-0"><input class="form-check-input disabled" type="radio" id="oil-channel-1" checked>';
                    contents += '<label class="form-check-label" for="oil-channel-1"> VAR </label></div></div><div class="col-4 d-flex justify-content-center">';
                    contents += '<div class="form-check d-flex align-items-center p-0 m-0"><input class="form-check-input disabled" type="radio" id="oil-channel-2">';
                    contents += '<label class="form-check-label" for="oil-channel-2"> YOK </label></div></div></div>';

                }

            }

        }

        function sendMail(form, category, image) {

            let params;
            params = [
                {
                    vals:[],
                    qty: form.find("#quantity").val(),
                    auth: form.find("#auth").val(),
                    firm: form.find("#firm").val(),
                    email: form.find("#email").val(),
                    phone: form.find("#phone").val(),
                    note: form.find("#note").val(),
                    category: category,
                    image: image
                }
            ];

            form.find(".tolerance").each(function(){

                params[0].vals.push({
                    title: $(this).parents(".row:eq(0)").find("label").text().trim(),
                    value: $(this).parents(".row:eq(0)").find(".value").val().trim(),
                    tolerance: $(this).val().trim()
                });

            });
            
            let err;
            err = false;

            (params[0].qty == "") ? Swal.fire({icon: "warning", title: "Zorunlu Alan!", text: "Adet Alanaı Boş!", confirmButtonText: "Tamam", willOpen: function(){ err = true; }}) : false;
            (params[0].auth == "") ? Swal.fire({icon: "warning", title: "Zorunlu Alan!", text: "Yetkili Kişi Alanaı Boş!", confirmButtonText: "Tamam", willOpen: function(){ err = true; }}) : false;
            (params[0].email == "") ? Swal.fire({icon: "warning", title: "Zorunlu Alan!", text: "Email Alanı Boş!", confirmButtonText: "Tamam", willOpen: function(){ err = true; }}) : false;
            ((params[0].email.indexOf("@") == -1 || params[0].email.indexOf(".com") == -1) && params[0].email !== "") ? Swal.fire({icon: "warning", title: "Zorunlu Alan!", text: "Lütfen Gerçerli Bir Mail Adresi Giriniz!", confirmButtonText: "Tamam", willOpen: function(){ err = true; }}) : false;
            (params[0].phone == "") ? Swal.fire({icon: "warning", title: "Zorunlu Alan!", text: "Telefon Alanı Boş!", confirmButtonText: "Tamam", willOpen: function(){ err = true; }}) : false;

            let is;
            is = false;

            for (let index = 0; index < params[0].vals.length; index++) {
                
                if(params[0].vals[index].value !== ""){

                    is = true;
                    break;

                }
                
            }

            (is === false) ? Swal.fire({icon: "error", title: "Hata!", text: "Hiç bir değer girmediniz!", confirmButtonText: "Tamam", willOpen: function(){ err = true; }}) : false;
            if(err !== false){ return false; }

            params[0].oil = form.find("#oil-channel-1").parents(".row:eq(0)").find("input:checked").parent().find("label").text().trim();
            params[0].tolerancetype = ($("#form-delta #standart-tolerance").is(":checked") !== false) ? "Standart Tolerans Değerleri" : "Özel Tolerans Değerleri";

            params = JSON.stringify(params);

            Swal.fire({
                title: 'Teklifiniz oluşturuluyor...',
                content: {
                    element: 'p',
                    attributes: {
                        innerHTML: '<img src="https://dev.digitalfikirler.com/delta_form/loading.gif" width="120"/>'
                    }
                },
                closeOnClickOutside: false,
                closeOnEsc: false,
                allowEnterKey: false,
                onOpen: () => {
                    Swal.showLoading();
                },
                buttons: {						  
                    confirm: {
                        visible: false
                    }
                }
            });

            $.ajax({url: "https://dev.digitalfikirler.com/delta_form/mailer.php", type: "POST", data: {params: params}, success: function(response){

                !Swal.isLoading();
                console.log(response);

                if(response == 1) {
									
                    Swal.fire({title: "Tebrikler!", text: "Teklifiniz başarılı bir şekilde alınmıştır.", icon: "success", confirmButtonText: "Tamam"});
                        
                }
                else {
                                        
                    Swal.fire({title: "Hata Oluştu", text: "Lütfen tekrar deneyiniz.", icon: "error", confirmButtonText: "Tamam"});
                
                }

            }});

        }

        $(document).on("click", "#form-delta label[for='oil-channel-1'], #form-delta label[for='oil-channel-2']", function(e){
                
            e.preventDefault();
            e.stopImmediatePropagation();

            $(this).parents(".item").find("input[type='radio']").each(function(){

                $(this).attr("checked", false);

            });

            $(this).parents(".form-check").find("input[type='radio']").attr("checked", true);

        });

        $(document).on("change", "#form-delta #standart-tolerance", function(){

            let self;
            self = $(this);

            if($(this).is(":checked")){

                let counter;
                counter = 0;
                
                $("#columns-and-tolerances").find(".col-12").each(function(){

                    let array;
                    array = $(this).text().split("|");
                    
                    for (let index = 0; index < array.length; index++) {
                        
                        let array2;
                        array2 = array[index].split(":");
                        
                        if(index%2 !== 0){

                            self.parents("#form-delta").find(".item .tolerance").each(function(){

                                self.parents("#form-delta").find(".item .tolerance:eq(" + counter + ")").val(array2[1]).addClass("disabled");

                            });

                            counter++;

                        }
                        
                    }

                });

            }else{

                $(this).parents("#form-delta").find(".item .tolerance.disabled").each(function(){

                    $(this).removeClass("disabled");

                });

            }

        });

    });

})(jQuery);