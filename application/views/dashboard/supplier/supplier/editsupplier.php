<!-- ======= Hero Section ======= -->

<body>
    <section id="hero" class="align-items-center">
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=base_url('home/suppliermanager')?>"><button
                    class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Edit New Supplier">&#8249;</button></a>
        </div>
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Edit Supplier</h1>
                </div>
            </div>

            <div class="pages">
                <div class="page">
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Supplier name</div>
                        <input id="Suppliername" class="text" type="text" placeholder=""
                            value="<?=str_replace("_"," ",$supplier['name'])?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Supplier registration number</div>
                        <input id="Suppliernumber" class="text" type="text" placeholder=""
                            value="<?=$supplier['number']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Address </div>
                        <input id="Supplieraddress" class="text" type="text" placeholder=""
                            value="<?=$supplier['address']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> VAT number</div>
                        <input id="Suppliervat" class="text" type="text" placeholder="" value="<?=$supplier['VAT']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Bank name</div>
                        <input id="Supplierbankname" class="text" type="text" placeholder=""
                            value="<?=$supplier['bankname']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Bank account</div>
                        <input id="Supplierbankaccount" class="text" type="text" placeholder=""
                            value="<?=$supplier['bankaccount']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> EORI number for import activities
                        </div>
                        <input id="Suppliereori" class="text" type="text" placeholder="" value="<?=$supplier['EORI']?>" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Reference</div>
                        <input id="SupplierRef" class="text" type="text" placeholder="" value="<?=$supplier['Ref']?>"/>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="cbutton bg-red" onclick="EditSupplier('<?=$supplier['id']?>')">Save</button> / <button
                    class="cbutton bg-white"><a href="<?=base_url('home/suppliermanager')?>">Cancel</a></button>
            </div>
        </div>
    </section><!-- End Hero -->