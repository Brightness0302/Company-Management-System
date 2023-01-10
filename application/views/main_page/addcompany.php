<!-- ======= Hero Section ======= -->

<body>
    <section id="hero" class="align-items-center">
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=base_url('home/index')?>"><button class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Company">&#8249;</button></a>
        </div>
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Add Company</h1>
                </div>
            </div>

            <div class="pages">
                <div class="page">
                    <div class="uploadcontainer">
                        <img src="<?=base_url('assets/image/img_avatar.png')?>" alt="Avatar" id="uploadimage"
                            class="image" style="width:100%;">
                        <div class="middle">
                            <label class="uploadbutton">
                                <input type="file" id="upload_image_file" style="display: none" />
                                Upload
                            </label>
                        </div>
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Company name</div>
                        <input id="companyname" type="text" placeholder="" data-validation="alphanumeric" data-validation-allowing="_" required/>
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Company registration number</div>
                        <input id="companynumber" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Address </div>
                        <input id="companyaddress" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> VAT number</div>
                        <input id="companyvat" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> EORI number for import activities</div>
                        <input id="companyeori" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Bank name-1</div>
                        <input id="companybankname1" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> BIC-1</div>
                        <input id="companybic1" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Observation-1</div>
                        <select class="form-select" id="observation1">
                            <option value="EURO">EUR</option>
                            <option value="RON">RON</option>
                            <option value="USD">USD</option>
                        </select>
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Bank account-1</div>
                        <input id="companybankaccount1" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Bank name-2</div>
                        <input id="companybankname2" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> BIC-2</div>
                        <input id="companybic2" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Observation-2</div>
                        <select class="form-select" id="observation2">
                            <option value="EURO">EUR</option>
                            <option value="RON">RON</option>
                            <option value="USD">USD</option>
                        </select>
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Bank account-2</div>
                        <input id="companybankaccount2" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> COIN Type</div>
                        <select class="form-select" id="companycoin">
                            <option value="EURO">€</option>
                            <option value="USD">$</option>
                            <option value="LEI">LEI</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="cbutton bg-red" onclick="AddCompany()">Save</button> / <a href="<?=base_url('home/index')?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>
    </section><!-- End Hero -->