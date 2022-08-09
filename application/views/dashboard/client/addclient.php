<!-- ======= Hero Section ======= -->

<body>
    <section id="hero" class="align-items-center">
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=base_url('home/clientmanager')?>"><button
                    class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Client">&#8249;</button></a>
        </div>
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Add Client</h1>
                </div>
            </div>

            <div class="pages">
                <div class="page">
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Client name</div>
                        <input id="Clientname" class="text" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Client registration number</div>
                        <input id="Clientnumber" class="text" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Address </div>
                        <input id="Clientaddress" class="text" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> VAT number</div>
                        <input id="Clientvat" class="text" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Bank name</div>
                        <input id="Clientbankname" class="text" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Bank account</div>
                        <input id="Clientbankaccount" class="text" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> EORI number for import activities
                        </div>
                        <input id="Clienteori" class="text" type="text" placeholder="" />
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="cbutton bg-red" onclick="AddClient()">Save</button> / <a
                    href="<?=base_url('home/clientmanager')?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>
    </section><!-- End Hero -->