<!-- ======= Hero Section ======= -->

<body>
    <section id="hero" class="align-items-center" data-aos="fade-up" data-aos-delay="100">
        <div class="fixed">
            <a href="<?=base_url('home/index')?>"><button class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Company">&#8249;</button></a>
        </div>
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Add User</h1>
                </div>
            </div>

            <div class="card adduser_container">
                <div class="card-body">
                    <h4 class="card-title">Input the user's credits.</h4>

                    <!-- Floating Labels Form -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input value="<?=$user['username']?>" type="email" class="form-control"
                                    id="_adduserusername" placeholder="Username">
                                <label for="floatingEmail">User Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input value="<?=$user['password']?>" type="password" class="form-control"
                                    id="_adduserpassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>
                        </div>

                        <hr class="p-0">

                        <h4>Input the user's allowance<span class="text-red-400 card-deputy-title">(multi-select with
                                KEY_CTRL)</span></h4>

                        <div class="row mt-3 ">
                            <label class="col-sm-2 col-form-label">Company</label>
                            <div class="col-sm-10">
                                <select class="form-select" multiple aria-label="multiple select example"
                                    id="_addusercompany">
                                    <?php foreach ($companies as $key=>$company):?>
                                    <option value="<?=$company['id']-1?>"
                                        <?=in_array(($company['id']-1), json_decode($user['company']))?"selected":""?>>
                                        <?=str_replace("_"," ",$company['name'])?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3 ">
                            <label class="col-sm-2 col-form-label">Module</label>
                            <div class="col-sm-10">
                                <select class="form-select h-52" multiple aria-label="multiple select example"
                                    id="_addusermodule">
                                    <?php foreach ($modules as $key=>$module):?>
                                    <option value="<?=$module['id']-1?>"
                                        <?=in_array(($module['id']-1), json_decode($user['module']))?"selected":""?>>
                                        <?=str_replace("_"," ",$module['name'])?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-primary w-24"
                                onclick="_edituser('<?=$user['id']?>')">Save</button>
                            <a type="reset" class="btn btn-secondary w-24" href="<?=base_url('home/index')?>">Cancel</a>
                        </div>
                    </div><!-- End floating Labels Form -->
                </div>
            </div>
        </div>
    </section><!-- End Hero -->