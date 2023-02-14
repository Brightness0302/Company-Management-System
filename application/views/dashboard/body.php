<!-- ======= Hero Section ======= -->
<?php $menu = $this->session->flashdata('menu');?>
<?=$isShow?>
<body style="font-size: 13px !important;" class="<?=(($isShow=="true")?"toggle-sidebar":"")?>">
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="<?=base_url('home/dashboard')?>" class="logo d-flex align-items-center justify-center">
                <img id="logo-image" src="<?=base_url('assets/company/image/'.$company['id']).'.jpg'?>" alt="">
            </a>
            <i class="bi bi-list toggle-sidebar-btn" onclick="setSidebar()"></i>
        </div><!-- End Logo -->

        <div class="logo-span">
            <span class="d-none d-lg-block logo-span-text"><?=str_replace("_"," ", $company['name'])?><label style="font-size: smaller; color: cornflowerblue;">(<?=($company['Coin']=="EURO")?"€":(($company['Coin']=="USD")?"$":(($company['Coin']=="POUND")?"£":(($company['Coin']=="LEI")?"LEI":"")))?>)</label></span>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown">
                    <button type="button" class="nav-link nav-icon border-0" data-bs-toggle="modal"
                        data-bs-target="#ExtralargeModal" onclick="getbackups()">
                        <i class="ri-settings-3-line"></i>
                    </button><!-- End Setting Icon -->
                    <!--  -->

                </li><!-- End Setting Part Nav -->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="<?=base_url('assets/image/img_avatar.png')?>" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?=(($user['rank']==1)?"Administrator":(($user['rank']==3)?"User":""))?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?=$user['username']?></h6>
                            <!-- <span>Blockchain Developer</span> -->
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <!-- <li>
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
                        </li> -->

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
            <?php 
                $user_modules=json_decode($user['module']);
            ?>
            <?php if($user['rank'] == 1 || in_array($modules[0]['id'] - 1, $user_modules)):?>
            <!-- Client component -->
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
            <?php endif;?>

            <?php if($user['rank'] == 1 || in_array($modules[1]['id'] - 1, $user_modules)):?>
            <!-- Supplier Component -->
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
            <?php endif;?>

            <?php if($user['rank'] == 1 || in_array($modules[2]['id'] - 1, $user_modules)):?>
            <!-- Expense Component -->
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
                                    <i class="bi <?=($menu['second-submenu']=="expense - ".$expense['name'])?"bi-circle-fill":"bi-circle"?>"></i><span><?=$expense['name'].' ['.$expense['code'].']'?></span>
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
            <?php endif;?>

            <?php if($user['rank'] == 1 || in_array($modules[3]['id'] - 1, $user_modules)):?>
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
                                    <i class="bi <?=($menu['second-submenu']=="stock - ".$stock['name'])?"bi-circle-fill":"bi-circle"?>"></i><span><?=$stock['name'].' ['.$stock['code'].']'?></span>
                                </a>
                                <?php endforeach;?>
                            </li>
                            <li>
                                <a href="<?=base_url("stock/showproductbystock")?>" style="padding-left: 56px;">
                                    <i class="bi <?=($menu['second-submenu']=="stock - *All")?"bi-circle-fill":"bi-circle"?>"></i><span>All Stocks</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li><!-- End Charts Nav -->
            <?php endif;?>

            <?php if($user['rank'] == 1 || in_array($modules[4]['id'] - 1, $user_modules)):?>
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
            <?php endif;?>

            <?php if($user['rank'] == 1 || in_array($modules[5]['id'] - 1, $user_modules)):?>
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
            <?php endif;?>

            <?php if($user['rank'] == 1 || in_array($modules[6]['id'] - 1, $user_modules)):?>

            <!-- Labor Module -->
            <li class="nav-item">
                <a class="nav-link <?=$menu['menu']=="Labors"?"":"collapsed"?>" data-bs-target="#labors-nav" data-bs-toggle="collapse" href="#">
                    <i class="bx custom-labor-image"></i><span>Labor</span>
                </a>
                <ul id="labors-nav" class="nav-content collapse <?=$menu['menu']=="Labors"?"show":""?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?=base_url("labor/permanentemployee")?>">
                            <i class="bi <?=($menu['submenu']=='l_pem')?"bi-circle-fill":"bi-circle"?>"></i><span>Permanent Employee</span>
                        </a>
                        <a href="<?=base_url("labor/subcontractor")?>">
                            <i class="bi <?=($menu['submenu']=='l_sc')?"bi-circle-fill":"bi-circle"?>"></i><span>Sub-Contractors</span>
                        </a>
                        <a href="<?=base_url("labor/projectassignment")?>">
                            <i class="bi <?=($menu['submenu']=='l_pa')?"bi-circle-fill":"bi-circle"?>"></i><span>Project Labor Assignment</span>
                        </a>
                        <a disabled>
                            <i class="bi <?=($menu['submenu']=='l_wd')?"bi-circle-fill":"bi-circle"?>"></i><span>Working Details</span>
                        </a>
                        <ul id="workingdetails-nav" class="nav-content collapse show" data-bs-parent="#labors-nav">
                            <li>
                                <?php foreach($permanentemployees as $employee):?>
                                <a href="<?=base_url("labor/showworkingdetailsbyemployee?")."type=permanentemployees&employee_id=".$employee['id']?>" style="padding-left: 56px;">
                                    <i class="bi <?=($menu['second-submenu']=="permanentemployees - ".$employee['name'])?"bi-circle-fill":"bi-circle"?>"></i><span><?=$employee['name'].' - Permanent Employee'?></span>
                                </a>
                                <?php endforeach;?>
                                <?php foreach($subcontractors as $employee):?>
                                <a href="<?=base_url("labor/showworkingdetailsbyemployee?")."type=subcontractors&employee_id=".$employee['id']?>" style="padding-left: 56px;">
                                    <i class="bi <?=($menu['second-submenu']=="subcontractors - ".$employee['name'])?"bi-circle-fill":"bi-circle"?>"></i><span><?=$employee['name'].' - Sub Contractor'?></span>
                                </a>
                                <?php endforeach;?>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li><!-- End Labor Module -->
            <?php endif;?>

            <?php if($user['rank'] == 1 || in_array(($modules[7]['id'] - 1), $user_modules)):?>
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
            <?php endif;?>
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
                                                    <optgroup id="backups" label="Select a Restore file">
                                                        <!-- <?php $index=0;?>
                                                        <?php foreach ($backups as $backup):?>
                                                        <?php $index++;?>
                                                            <?php sscanf($backup,"%d_%d_%d_%d_%d_%d.sql", $dat, $mon, $Yea, $hou, $min, $sec);
                                                            $dt = new DateTime($Yea.'-'.$mon.'-'.$dat.' '.$hou.':'.$min.':'.$sec);
                                                            $loc = (new DateTime)->getTimezone();
                                                            $dt->setTimezone($loc);?>
                                                            <option value="<?=$backup?>"><?=$backup?></option>
                                                        <?php endforeach;?>
                                                            <option id="custom-select" value=""></option> -->
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="restorefile-upload" id="restorefile-text" class="btn btn-secondary form-control" style="color: red;">
                                                    <i class="fa fa-cloud-upload"></i> Custom select
                                                </label>
                                                <input id="restorefile-upload" name='upload_cont_img' type="file" style="display:none;">
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
                    else if($menu['submenu']=="l_wd")
                        echo "Working Details";
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
        </div><!-- End Page Title -->
