<!-- ======= Hero Section ======= -->

<body>
    <section id="hero" class="align-items-center">
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=base_url('home/suppliermanager')?>"><button
                    class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Supplier">&#8249;</button></a>
        </div>
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Add Supplier</h1>
                </div>
            </div>

            <div class="pages">
                <div class="page">
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Supplier name</div>
                        <input id="Suppliername" class="text" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Supplier registration number</div>
                        <input id="Suppliernumber" class="text" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Address </div>
                        <input id="Supplieraddress" class="text" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> VAT number</div>
                        <input id="Suppliervat" class="text" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Bank name</div>
                        <input id="Supplierbankname" class="text" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Bank account</div>
                        <input id="Supplierbankaccount" class="text" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> EORI number for import activities
                        </div>
                        <input id="Suppliereori" class="text" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Reference</div>
                        <input id="SupplierRef" class="text" type="text" placeholder="" />
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="cbutton bg-red" onclick="AddSupplier()">Save</button> / <a
                    href="<?=base_url('home/suppliermanager')?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>
    </section><!-- End Hero -->