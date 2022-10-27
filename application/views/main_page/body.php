<!-- ======= Hero Section ======= -->

<body>
    <section id="hero" class="align-items-center">
        <?php if($user['rank'] == 1):?>
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=base_url('home/addcompany')?>"><button
                    class="newcompany w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl" for="dialog_state"
                    title="Add New Company">+</button></a>
        </div>
        <?php endif;?>
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=base_url('home/signview')?>"><button
                    class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl" for="dialog_state"
                    title="goback">&#8249;</button></a>
        </div>
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 text-center">
                    <p class="container-header">Company Management System</p>
                    <div class="b mx-auto h-16 w-128 flex justify-center items-center mt-3">
                        <div
                            class="bg-gradient-to-br from-blue-400 to-blue-600 items-center rounded-xl shadow-2xl  cursor-pointer absolute overflow-hidden transform hover:scale-x-110 hover:scale-y-105 transition duration-300 ease-out">
                        </div>
                        <h3 class="text-updownanimationtext">Select one company to begin!</h3>
                    </div>
                </div>
            </div>

            <div class="row icon-boxes">
                <?php foreach ($companies as $key=>$company):?>
                <?php if(!$company['isremoved']):?>
                <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-4" data-aos="zoom-in"
                    data-aos-delay="200">
                    <div class="icon-box w-full">
                        <div class="icon min-w-full" style="display: flex;justify-content: center;align-items: center;">
                            <img class="ri-stack-line"
                                src="<?=base_url('assets/company/image/'.$company['id']).'.jpg'?>" style="height: 64px; max-width: 100%;"/>
                        </div>
                        <?php if($user['rank'] == 1):?>
                        <div class="temp-icon">
                            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                                data-bs-toggle="dropdown">
                                <span class="d-none d-md-block dropdown-toggle ps-2"><i class="fas fa-tools"></i></span>
                            </a><!-- End Profile Iamge Icon -->

                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="<?=base_url('home/editcompany/'.$company['id'])?>">
                                        <i class="bi custom-edit-icon"></i>
                                        <span>Edit</span>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li>
                                    <button class="dropdown-item d-flex align-items-center"
                                        onclick="Delcompany('<?=$company['id']?>')">
                                        <i class="bi custom-remove-icon"></i>
                                        <span>Delete</span>
                                    </button>
                                </li>

                            </ul>
                        </div>
                        <?php endif;?>
                        <hr />
                        <h4 class="title text-center"><a
                                href="<?=base_url('home/gotodashboard/'.$company['id'])?>"><?=str_replace("_"," ",$company['name'])?></a>
                        </h4>
                    </div>
                </div>
                <?php endif;?>
                <?php endforeach;?>
            </div>
            <?php if($user['rank'] == 1):?>
            <hr class="div-divider">

            <div class="container">
                <h1 class="text-center mb-10">User Management</h1>
                <div class="row">
                    <div class="col-md-6 m-auto">
                        <input type="text" id="myInput" class="input form-control  border border-2 border-primary"
                            onkeyup="myFunction()" placeholder="Search Users" title="Type in a name">
                    </div>
                    <div class="col-md-6 ">
                        <a class="btn btn-primary m-auto w-100" href="<?=base_url('home/adduser')?>"><i
                                class="bx bxs-plus-circle"></i>Add New User</a>
                    </div>
                </div>
                <table id="myTable" class="table text-center border mt-10">
                    <tr class="header">
                        <th>Name</th>
                        <th class="one">Password</th>
                        <th>Company</th>
                        <th>Module</th>
                        <th>Rank</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($users as $key=>$user):?>
                    <tr>
                        <td><?=$user['username']?></td>
                        <td class="one"><?=$user['password']?></td>
                        <td>
                            <div class="col-sm-10 m-auto">
                                <select class="form-select" aria-label="Default select example">
                                    <?php $user_companies=json_decode($user['company']);?>
                                    <?php foreach ($user_companies as $user_key=>$user_company):?>
                                    <?php foreach ($companies as $key=>$company):?>
                                    <?php if (($user_company)==($company['id']-1)):?>
                                    <option value="<?=$user_company?>">
                                        <?=str_replace("_"," ",$companies[$user_key]['name'])?></option>
                                    <?php endif;?>
                                    <?php endforeach;?>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="col-sm-10 m-auto">
                                <select class="form-select" aria-label="Default select example">
                                    <?php $user_modules=json_decode($user['module']);?>
                                    <?php foreach ($user_modules as $key=>$module):?>
                                    <option value="<?=$module?>"><?=$modules[$module]['name']?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </td>
                        <td class="one"><?=$user['rank']==1?"Administrator":"Guest"?></td>
                        <td>
                            <div class="row">
                                <div class="col-md-6">
                                    <a class="btn btn-primary w-100"
                                        href="<?=base_url('home/edituser/'.$user['id'])?>"><i
                                            class="bx bxs-pencil"></i><label id="hide">Edit</label></a>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-danger w-100" onclick="Deluser('<?=$user['id']?>')"><i
                                            class="bx bxs-eraser"></i><label id="hide">Delete</label></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </table>
            </div>
            <?php endif;?>
        </div>
    </section><!-- End Hero -->