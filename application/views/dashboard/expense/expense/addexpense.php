<body>
    <section id="hero" class="align-items-center" data-aos="fade-up" data-aos-delay="100">
        <div>
            <a href="<?=base_url('expense/index')?>"><button
                    class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Client">&#8249;</button></a>
        </div>
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Add Expense Category</h1>
                </div>
            </div>

            <div class="pages">
                <div class="page">
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Expense Category</div>
                        <input id="ExpenseCategory" class="text" type="text" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> Expense Code</div>
                        <input id="ExpenseCode" class="text" type="text" placeholder="" />
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="cbutton bg-red" onclick="AddExpense()">Save</button> / <a
                    href="<?=base_url('expense/index')?>"><button class="cbutton bg-white">Cancel</button></a>
            </div>
        </div>
    </section><!-- End Hero -->