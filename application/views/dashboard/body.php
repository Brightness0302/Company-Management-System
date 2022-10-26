<!-- ======= Hero Section ======= -->
<?php $menu = $this->session->flashdata('menu');?>
<?=$backup['period'].$backup['date']?>
<body style="font-size: 13px !important;">
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center justify-center">
                <img src="<?=base_url('assets/company/image/'.$company['id']).'.jpg'?>" alt="">
                <span class="d-none d-lg-block"><?=str_replace("_"," ", $company['name'])?></span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown">
                    <button type="button" class="nav-link nav-icon border-0" data-bs-toggle="modal"
                        data-bs-target="#ExtralargeModal">
                        <i class="ri-settings-3-line"></i>
                    </button><!-- End Setting Icon -->
                    <!--  -->

                </li><!-- End Setting Part Nav -->


                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">4</span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-x-circle text-danger"></i>
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>

                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav -->

                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-chat-left-text"></i>
                        <span class="badge bg-success badge-number">3</span>
                    </a><!-- End Messages Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            You have 3 new messages
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                                <div>
                                    <h4>Maria Hudson</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>4 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                                <div>
                                    <h4>Anna Nelson</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>6 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                                <div>
                                    <h4>David Muldon</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>8 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="dropdown-footer">
                            <a href="#">Show all messages</a>
                        </li>

                    </ul><!-- End Messages Dropdown Items -->

                </li><!-- End Messages Nav -->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="<?=base_url('assets/image/img_avatar.png')?>" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?=$user['username']?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>Santiago Machado</h6>
                            <span>Blockchain Developer</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                <i class="bi bi-question-circle"></i>
                                <span>Need Help?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?=base_url('home/index')?>">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="<?=base_url('home/dashboard')?>">
                    <i class="bi custom-dashboard-image"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link <?=$menu['menu']=="Clients"?"":"collapsed"?>" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi custom-client-image"></i><span>Clients</span>
                </a>
                <ul id="components-nav" class="nav-content collapse <?=$menu['menu']=="Clients"?"show":""?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?=base_url('client/index')?>">
                            <i class="bi <?=$menu['submenu']=="cm"?"bi-circle-fill":"bi-circle"?>"></i><span>Client Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url('client/invoicemanager')?>">
                            <i class="bi <?=$menu['submenu']=="im"?"bi-circle-fill":"bi-circle"?>"></i><span>Invoice Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url('client/proformainvoicemanager')?>">
                            <i class="bi <?=$menu['submenu']=="prm"?"bi-circle-fill":"bi-circle"?>"></i><span>Proforma Management</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="<?=base_url('client/expensemanager')?>">
                            <i class="bi bi-circle"></i><span>Expense Management</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="<?=base_url('client/paymentmanager')?>">
                            <i class="bi <?=$menu['submenu']=="pm"?"bi-circle-fill":"bi-circle"?>"></i><span>Payment Management</span>
                        </a>
                    </li>

                </ul>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link <?=$menu['menu']=="Suppliers"?"":"collapsed"?>" data-bs-target="#supplier-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi custom-supplier-image"></i><span>Suppliers</span>
                </a>
                <ul id="supplier-nav" class="nav-content collapse <?=$menu['menu']=="Suppliers"?"show":""?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?=base_url('supplier/index')?>">
                            <i class="bi <?=$menu['submenu']=="sm"?"bi-circle-fill":"bi-circle"?>"></i><span>Supplier Management</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?=base_url('material/index')?>">
                            <i class="bi <?=$menu['submenu']=="pdm"?"bi-circle-fill":"bi-circle"?>"></i><span>Supplier Invoices</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?=base_url('material/paymentmanager')?>">
                            <i class="bi <?=$menu['submenu']=="ppm"?"bi-circle-fill":"bi-circle"?>"></i><span>Payment Management</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link <?=$menu['menu']=="Expenses"?"":"collapsed"?>" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bx custom-expense-image"></i><span>Expenses</span>
                </a>
                <ul id="tables-nav" class="nav-content collapse <?=$menu['menu']=="Expenses"?"show":""?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?=base_url('expense/index')?>">
                            <i class="bi <?=($menu['submenu']=="em"||$menu['submenu']=="pmbyid")?"bi-circle-fill":"bi-circle"?>"></i><span>Expense Management</span>
                        </a>
                        <ul id="stocks-nav" class="nav-content collapse show" data-bs-parent="#charts-nav">
                            <li>
                                <?php foreach($expenses as $expense):?>
                                <a href="<?=base_url("expense/showproductbyexpenseid?expense_id=").$expense['id']?>" style="padding-left: 56px;">
                                    <i class="bi <?=($menu['second-submenu']=="expense - ".$expense['name'])?"bi-circle-fill":"bi-circle"?>"></i><span><?=$expense['name']?></span>
                                </a>
                                <?php endforeach;?>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?=base_url('expense/product')?>">
                            <i class="bi <?=($menu['submenu']=="empr")?"bi-circle-fill":"bi-circle"?>"></i><span>Register Expenses</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Tables Nav -->

            <li class="nav-item">
                <a class="nav-link <?=$menu['menu']=="Stocks"?"":"collapsed"?>" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                    <i class="bx custom-stock-image"></i><span>Stocks</span>
                </a>
                <ul id="charts-nav" class="nav-content collapse <?=$menu['menu']=="Stocks"?"show":""?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?=base_url('stock/index')?>">
                            <i class="bi <?=($menu['submenu']=="stm"||$menu['submenu']=="pmbs")?"bi-caret-right-square-fill":"bi-caret-right-square"?>"></i><span>Stock Management</span>
                        </a>
                        <ul id="projects-nav" class="nav-content collapse show" data-bs-parent="#charts-nav">
                            <li>
                                <?php foreach($stocks as $stock):?>
                                <a href="<?=base_url("stock/showproductbystock?stock_id=").$stock['id']?>" style="padding-left: 56px;">
                                    <i class="bi <?=($menu['second-submenu']=="stock - ".$stock['name'])?"bi-circle-fill":"bi-circle"?>"></i><span><?=$stock['name']?></span>
                                </a>
                                <?php endforeach;?>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li><!-- End Charts Nav -->

            <li class="nav-item">
                <a class="nav-link <?=$menu['menu']=="Products"?"":"collapsed"?>" data-bs-target="#product-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi custom-product-image"></i><span>Products</span>
                </a>
                <ul id="product-nav" class="nav-content collapse <?=$menu['menu']=="Products"?"show":""?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?=base_url('product/index')?>">
                            <i class="bi <?=$menu['submenu']=="p_prm"?"bi-circle-fill":"bi-circle"?>"></i><span>Product Recipe Management</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?=base_url('product/internalorder')?>">
                            <i class="bi <?=$menu['submenu']=="p_ioi"?"bi-circle-fill":"bi-circle"?>"></i><span>Internal Production Order</span>
                        </a>
                    </li>

                    <!-- <li>
                        <a href="<?=base_url('product/internalorderproduction')?>">
                            <i class="bi <?=$menu['submenu']=="p_iop"?"bi-circle-fill":"bi-circle"?>"></i><span>Internal order production</span>
                        </a>
                    </li> -->

                    <li>
                        <a href="<?=base_url('product/productmanagement')?>">
                            <i class="bi <?=$menu['submenu']=="p_pm"?"bi-circle-fill":"bi-circle"?>"></i><span>Product Registration</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?=base_url('product/reportmanager')?>">
                            <i class="bi <?=$menu['submenu']=="p_rm"?"bi-circle-fill":"bi-circle"?>"></i><span>Production Reports</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Charts Nav -->
            <!-- Project Module -->
            <li class="nav-item">
                <a class="nav-link <?=$menu['menu']=="Projects"?"":"collapsed"?>" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                    <i class="bx custom-project-image"></i><span>Projects</span>
                </a>
                <ul id="icons-nav" class="nav-content collapse <?=$menu['menu']=="Projects"?"show":""?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?=base_url('project/index')?>">
                            <i class="bi <?=$menu['submenu']=="pj_pm"?"bi-circle-fill":"bi-circle"?>"></i><span>Projects Management</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Project Module -->

            <!-- Labor Module -->
            <li class="nav-item">
                <a class="nav-link <?=$menu['menu']=="Labors"?"":"collapsed"?>" data-bs-target="#labors-nav" data-bs-toggle="collapse" href="#">
                    <i class="bx custom-labor-image"></i><span>Labor</span>
                </a>
                <ul id="labors-nav" class="nav-content collapse <?=$menu['menu']=="Labors"?"show":""?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?=base_url("labor/permanentemployee")?>" style="padding-left: 56px;">
                            <i class="bi <?=($menu['submenu']=='l_pem')?"bi-circle-fill":"bi-circle"?>"></i><span>Permanent Employee</span>
                        </a>
                        <a href="<?=base_url("labor/subcontractor")?>" style="padding-left: 56px;">
                            <i class="bi <?=($menu['submenu']=='l_sc')?"bi-circle-fill":"bi-circle"?>"></i><span>Sub-Contractors</span>
                        </a>
                        <a href="<?=base_url("labor/projectassignment")?>" style="padding-left: 56px;">
                            <i class="bi <?=($menu['submenu']=='l_pa')?"bi-circle-fill":"bi-circle"?>"></i><span>Project Labor Assignment</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Labor Module -->

            <!-- Statistics Module -->
            <li class="nav-item">
                <a class="nav-link <?=$menu['menu']=="Reports & Statistics"?"":"collapsed"?>" data-bs-target="#report-nav" data-bs-toggle="collapse" href="#">
                    <i class="bx custom-report-image"></i><span>Reports & Statistics</span>
                </a>
                <ul id="report-nav" class="nav-content collapse <?=$menu['menu']=="Reports & Statistics"?"show":""?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?=base_url("report/clientchart")?>" style="padding-left: 56px;">
                            <i class="bi <?=($menu['submenu']=='r_cc')?"bi-circle-fill":"bi-circle"?>"></i><span>Clients</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url("report/supplierchart")?>" style="padding-left: 56px;">
                            <i class="bi <?=($menu['submenu']=='r_sc')?"bi-circle-fill":"bi-circle"?>"></i><span>Suppliers</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url("report/expensechart")?>" style="padding-left: 56px;">
                            <i class="bi <?=($menu['submenu']=='r_ec')?"bi-circle-fill":"bi-circle"?>"></i><span>Expenses</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url("report/vatchart")?>" style="padding-left: 56px;">
                            <i class="bi <?=($menu['submenu']=='r_vc')?"bi-circle-fill":"bi-circle"?>"></i><span>VAT</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url("report/traceabilitychart")?>" style="padding-left: 56px;">
                            <i class="bi <?=($menu['submenu']=='r_tc')?"bi-circle-fill":"bi-circle"?>"></i><span>Traceability</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End  Statistics Module -->
        </ul>

    </aside><!-- End Sidebar-->

    <main id="dashboardmain" class="dashboardmain">
        
        <!-- Extra Model Part -->
        <div class="modal fade" id="ExtralargeModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title text-black d-flex "><i
                                class="ri-settings-3-line"></i>Settings</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <!-- Tab bar sections -->
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <!-- Bordered Tabs Justified -->
                                <ul class="nav nav-tabs nav-tabs-bordered w-full" id="borderedTabJustified"
                                    role="tablist">
                                    <li class="nav-item flex-fill" role="presentation">
                                        <button id="backup" class="nav-link w-100 active" id="home-tab"
                                            name="backup" data-bs-toggle="tab"
                                            data-bs-target="#bordered-justified-backup" type="button"
                                            role="tab" aria-controls="backup" aria-selected="true">Back
                                            Up</button>
                                    </li>
                                    <li class="nav-item flex-fill" role="presentation">
                                        <button id="restore" class="nav-link w-100" id="profile-tab"
                                            name="restore" data-bs-toggle="tab"
                                            data-bs-target="#bordered-justified-restore" type="button"
                                            role="tab" aria-controls="restore"
                                            aria-selected="false">Restore</button>
                                    </li>
                                </ul>
                                <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                                    <!-- Backup function -->
                                    <div class="tab-pane fade show active" id="bordered-justified-backup"
                                        role="tabpanel" aria-labelledby="home-tab">
                                        <!-- Back Up setting Sections -->
                                        <!-- Multi Columns Form -->
                                        <form class="row g-3">
                                            <div class="col-md-5">
                                                <label class="form-label text-black">PERIOD</label>
                                                <!-- <input type="email" class="form-control" id="inputEmail5"> -->
                                                <div class="col-sm-10">
                                                    <select class="form-select" id="backup_period" aria-label="Default select example">
                                                        <optgroup label="Select your period for Back Up">
                                                            <option value="1" <?=($backup['period']==1)?"selected":""?>>Every day</option>
                                                            <option value="2" <?=($backup['period']==2)?"selected":""?>>Two days</option>
                                                            <option value="3" <?=($backup['period']==3)?"selected":""?>>Three days</option>
                                                            <option value="4" <?=($backup['period']==4)?"selected":""?>>Four day</option>
                                                            <option value="5" <?=($backup['period']==5)?"selected":""?>>Five days</option>
                                                            <option value="6" <?=($backup['period']==6)?"selected":""?>>Six days</option>
                                                            <option value="7" <?=($backup['period']==7)?"selected":""?>>Seven days</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label text-black">PICK UP TIME</label>
                                                <div class="col-sm-10">
                                                    <input type="time" id="backup_date" value="<?=($backup['date']==false)?date('H:i'):$backup['date']?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-default form-control mt-6" onclick="download()">Download</button>
                                            </div>
                                            <!-- <div class="col-md-2">
                                                <button type="button" class="btn btn-secondary form-control mt-6" onclick="backup_now()">Backup Now</button>
                                            </div> -->
                                            <a id="download" href="" hidden>Download PDF</a>
                                        </form><!-- End Multi Columns Form -->
                                    </div>
                                    <!-- Restore function -->
                                    <div class="tab-pane fade" id="bordered-justified-restore" role="tabpanel" aria-labelledby="profile-tab">
                                        <label class="form-label text-black">PICK UP File</label>
                                        <!-- Restore Setting Sections  -->
                                        <div class="row g-3">
                                            <div class="col-md-8">
                                                <select class="form-select" id="restore_picker" aria-label="Default select example">
                                                    <optgroup label="Select a Restore file">
                                                        <?php $index=0;?>
                                                        <?php foreach ($backups as $backup):?>
                                                        <?php $index++;?>
                                                            <!-- <?php sscanf($backup,"%d_%d_%d_%d_%d_%d.sql", $dat, $mon, $Yea, $hou, $min, $sec);
                                                            $dt = new DateTime($Yea.'-'.$mon.'-'.$dat.' '.$hou.':'.$min.':'.$sec);
                                                            $loc = (new DateTime)->getTimezone();
                                                            $dt->setTimezone($loc);?> -->
                                                            <option value="<?=$backup?>"><?=$backup?></option>
                                                        <?php endforeach;?>
                                                            <option id="custom-select" value=""></option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="file-upload" id="file-text" class="btn btn-secondary form-control" style="color: red;">
                                                    <i class="fa fa-cloud-upload"></i> Custom select
                                                </label>
                                                <input id="file-upload" name='upload_cont_img' type="file" style="display:none;">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-secondary form-control" onclick="restore_now()">Restore Now</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div><!-- End Bordered Tabs Justified -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-primary" onclick="save_setting()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Extra Large Modal-->
        <div class="pagetitle">
            <h1><u><?=$menu['menu']?></u></h1>
            <hr>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                    <?php
                    if ($menu['menu']=="Dashboard")
                        echo "Dashboard";
                    else if($menu['submenu']=="cm")
                        echo "Client Management";
                    else if($menu['submenu']=="im")
                        echo "Invoice Management";
                    else if($menu['submenu']=="pm")
                        echo "Payment Management";
                    else if($menu['submenu']=="pj_pm")
                        echo "Project Management";
                    else if($menu['submenu']=="l_pem")
                        echo "Permanent Employees";
                    else if($menu['submenu']=="l_pa")
                        echo "Project Labor Assignment";
                    else if($menu['submenu']=="l_sc")
                        echo "Sub-Contractors";
                    else if($menu['submenu']=="prm")
                        echo "Proforma Management";
                    else if($menu['submenu']=="ppm")
                        echo "Payment Management";
                    else if($menu['submenu']=="stm")
                        echo "Stock Management";
                    else if($menu['submenu']=="sm")
                        echo "Supplier Management";
                    else if($menu['submenu']=="em")
                        echo "Expense Management";
                    else if($menu['submenu']=="pdm")
                        echo "Supplier Invoices";
                    else if($menu['submenu']=="p_rm")
                        echo "Production reports";
                    else if($menu['submenu']=="p_pm")
                        echo "Product registration";
                    else if($menu['submenu']=="p_prm")
                        echo "Product recipe management";
                    else if($menu['submenu']=="pmbs")
                        echo "Stock Management";
                    else if($menu['submenu']=="empr")
                        echo "Register expenses";
                    else if($menu['submenu']=="pmbyid")
                        echo "Expense Management";
                    else if($menu['submenu']=="p_ioi")
                        echo "Internal production order";
                    else if($menu['submenu']=="p_iop")
                        echo "Internal order production";
                    else if($menu['submenu']=="r_cc" || $menu['submenu']=="r_sc" || $menu['submenu']=="r_ec" || $menu['submenu']=="r_vc" || $menu['submenu']=="r_tc")
                        echo "Reports & Statistics";
                    ?></li>
                    <?php if($menu['second-submenu']!="NONE"):?>
                        <li class="breadcrumb-item active">
                        <?=$menu['second-submenu']?>
                        </li>
                    <?php endif;?>
                </ol>
            </nav>
        </div><!-- End Page Title