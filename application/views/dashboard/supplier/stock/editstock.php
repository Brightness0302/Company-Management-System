<body>
    <section id="hero" class="align-items-center">
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=base_url('stock/index')?>"><button
                    class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Client">&#8249;</button></a>
        </div>
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Edit Stock</h1>
                </div>
            </div>

            <div class="pages">
                <div class="page">
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Stock name</div>
                        <input id="Stockname" class="text" type="text" placeholder="" value="<?=$stock['name']?>"/>
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Stock code</div>
                        <input id="Stockcode" class="text" type="text" placeholder="" value="<?=$stock['code']?>"/>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="cbutton bg-red" onclick="EditStock('<?=$stock['id']?>')">Save</button> / <a
                    href="<?=base_url('stock/index')?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>
    </section><!-- End Hero -->