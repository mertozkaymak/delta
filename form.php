<?php header("Access-Control-Allow-Origin: *"); ?>
<style>
    input[type=radio]:checked+label:before, input[type=radio]+label:before, input[type=checkbox]:checked+label:before, input[type=checkbox]+label:before { display:none!important; }
    input[type=radio]+label, input[type=checkbox]+label, input[type=checkbox]:checked+label:before, input[type=checkbox]+label:before { padding-left: 1rem!important; }
    #form-delta #header { z-index: 0!important; }
    #form-delta #header .container .row{ padding: 10px 0; font-weight: 600; border-bottom: solid 1px;}
    #form-delta #body .item { padding: 10px 0; }
    #form-delta .item .tolerance.disabled { background: #EEE; color: #999; }
    .swal2-popup #form-delta { max-height: 500px; overflow: hidden; overflow-y: auto; }
    .swal2-popup { width: 70%; }
    .swal2-popup .swal2-content { font-size: 1.6rem }
    .swal2-popup .swal2-actions { display: flex; justify-content: flex-end; padding-right: 3rem; }
    .swal2-popup ::-webkit-scrollbar { width: 5px; height: 7px; }
    .swal2-popup ::-webkit-scrollbar-track { background: #f1f1f1; }
    .swal2-popup ::-webkit-scrollbar-thumb { background: #DDD; border-radius: 20px; }
    .swal2-popup ::-webkit-scrollbar-thumb:hover { background: #AAA; }
    @media screen and (max-width: 576px) { 
        .swal2-popup .swal2-content { font-size: 1rem; } .swal2-popup { width: 100%; } .swal2-popup #form-delta { padding: 1rem; } 
        .swal2-popup .swal2-actions { display: flex; justify-content: center; padding-right: 0; font-size: 1.3rem; }
        .swal2-popup #form-delta { min-width: 500px; }
        .swal2-popup .swal2-content { overflow: hidden; overflow-x: auto; }
    }
</style>
<div class="container" id="form-delta">
    <div class="row" id="header">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-4">Ölçü Adı(Mm)</div>
                <div class="col-4">Ölçü Değeri</div>
                <div class="col-4">Tolerans Değeri</div>
            </div>
        </div>
    </div>
    <div class="row" id="body">
        <div class="container">
            <div class="row d-flex align-items-baseline item">
                <div class="col-4 d-flex justify-content-center">
                Adet:
                </div>
                <div class="col-8 d-flex justify-content-center">
                <input type="number" class="form-control" placeholder="Adet" name="quantity" id="quantity">
                </div>
            </div>
            <div class="row d-flex align-items-baseline item">
                <div class="col-4 d-flex justify-content-center">
                Yetkili:
                </div>
                <div class="col-8 d-flex justify-content-center">
                <input type="text" class="form-control disabled" name="auth" id="auth" disabled="disabled">
                </div>
            </div>
            <div class="row d-flex align-items-baseline item">
                <div class="col-4 d-flex justify-content-center">
                Firma:
                </div>
                <div class="col-8 d-flex justify-content-center">
                <input type="text" class="form-control" name="firm" id="firm">
                </div>
            </div>
            <div class="row d-flex align-items-baseline item">
                <div class="col-4 d-flex justify-content-center">
                Email:
                </div>
                <div class="col-8 d-flex justify-content-center">
                <input type="email" class="form-control" name="email" id="email" disabled="disabled">
                </div>
            </div>
            <div class="row d-flex align-items-baseline item">
                <div class="col-4 d-flex justify-content-center">
                Telefon:
                </div>
                <div class="col-8 d-flex justify-content-center">
                <input type="tel" class="form-control" name="phone" id="phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" disabled="disabled">
                </div>
            </div>
            <div class="row d-flex align-items-baseline item">
                <div class="col-4 d-flex justify-content-center">
                Not:
                </div>
                <div class="col-8 d-flex justify-content-center">
                <textarea class="form-control" name="note" id="note" placeholder="İletmek istediğiniz notunuzu giriniz."></textarea>
                </div>
            </div>
        </div>
    </div>
</div>