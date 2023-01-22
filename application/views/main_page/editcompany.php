<!-- ======= Hero Section ======= -->

<body>
    <section id="hero" class="align-items-center" data-aos="fade-up" data-aos-delay="100">
        <div class="fixed">
            <a href="<?=base_url('home/index')?>"><button class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl" title="Add New Company">&#8249;</button></a>
        </div>
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Edit Company</h1>
                </div>
            </div>

            <div class="pages">
                <div class="page">
                    <div class="uploadcontainer">
                        <img src="<?=base_url('assets/company/image/'.$company['id'].'.jpg')?>" alt="Avatar" id="uploadimage" class="image" style="width:100%;">
                        <div class="middle">
                            <label class="uploadbutton">
                                <input type="file" id="upload_image_file" style="display: none" />
                                Upload
                            </label>
                        </div>
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Company name</div>
                        <input id="companyname" type="text" placeholder="" value="<?=str_replace("_"," ",$company['name'])?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Company registration number</div>
                        <input id="companynumber" type="text" placeholder="" value="<?=$company['number']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Address </div>
                        <input id="companyaddress" type="text" placeholder="" value="<?=$company['address']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> VAT number</div>
                        <input id="companyvat" type="text" placeholder="" value="<?=$company['VAT']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> EORI number for import activities
                        </div>
                        <input id="companyeori" type="text" placeholder="" value="<?=$company['EORI']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Bank name-1</div>
                        <input id="companybankname1" type="text" placeholder="" value="<?=$company['bankname1']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> BIC-1</div>
                        <input id="companybic1" type="text" placeholder="" value="<?=$company['bic1']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Observation-1</div>
                        <select class="form-select" id="observation1">
                            <option value="EUR" <?=$company['observation1']=="EUR"?"selected":""?>>EUR</option>
                            <option value="RON" <?=$company['observation1']=="RON"?"selected":""?>>RON</option>
                            <option value="USD" <?=$company['observation1']=="USD"?"selected":""?>>USD</option>
                        </select>
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Bank account-1</div>
                        <input id="companybankaccount1" type="text" placeholder="" value="<?=$company['bankaccount1']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Bank name-2</div>
                        <input id="companybankname2" type="text" placeholder="" value="<?=$company['bankname2']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> BIC-2</div>
                        <input id="companybic2" type="text" placeholder="" value="<?=$company['bic2']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Observation-2</div>
                        <select class="form-select" id="observation2">
                            <option value="EUR" <?=$company['observation2']=="EUR"?"selected":""?>>EUR</option>
                            <option value="RON" <?=$company['observation2']=="RON"?"selected":""?>>RON</option>
                            <option value="USD" <?=$company['observation2']=="USD"?"selected":""?>>USD</option>
                        </select>
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Bank account-2</div>
                        <input id="companybankaccount2" type="text" placeholder="" value="<?=$company['bankaccount2']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> COIN Type
                        </div>
                        <select class="form-select" id="companycoin">
                            <option value="EURO" <?=$company['Coin']=="EURO"?"selected":""?>>€</option>
                            <option value="USD" <?=$company['Coin']=="USD"?"selected":""?>>$</option>
                            <option value="LEI" <?=$company['Coin']=="LEI"?"selected":""?>>LEI</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="cbutton bg-red" onclick="EditCompany('<?=$company['id']?>')">Save</button> / <a href="<?=base_url('home/index')?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>
    </section><!-- End Hero -->