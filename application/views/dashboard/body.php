<!-- ======= Hero Section ======= -->
<?php $menu = $this->session->flashdata('menu');?>
<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="<?=base_url('assets/image/logo.png')?>" alt="">
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
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link <?=$menu['menu']=="Clients"?"":"collapsed"?>" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person-bounding-box"></i><span>Clients</span><i
                        class="bi bi-chevron-down ms-auto"></i>
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
                    <li>
                        <a href="<?=base_url('client/projectmanager')?>">
                            <i class="bi <?=$menu['submenu']=="pjm"?"bi-circle-fill":"bi-circle"?>"></i><span>Project Management</span>
                        </a>
                    </li>                    

                </ul>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link <?=$menu['menu']=="Suppliers"?"":"collapsed"?>" data-bs-target="#supplier-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person-bounding-box"></i><span>Suppliers</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="supplier-nav" class="nav-content collapse <?=$menu['menu']=="Suppliers"?"show":""?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?=base_url('supplier/index')?>">
                            <i class="bi <?=$menu['submenu']=="sm"?"bi-circle-fill":"bi-circle"?>"></i><span>Supplier Management</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?=base_url('stock/index')?>">
                            <i class="bi <?=($menu['submenu']=="stm"||$menu['submenu']=="pmbs")?"bi-circle-fill":"bi-circle"?>"></i><span>Stock Management</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?=base_url('product/index')?>">
                            <i class="bi <?=$menu['submenu']=="pdm"?"bi-circle-fill":"bi-circle"?>"></i><span>Supplier Invoices</span>
                        </a>
                    </li>

                </ul>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bx bxs-cylinder"></i><span>Materials</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>H.slot</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>Sword</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Tables Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                    <i class="bx bxs-diamond"></i><span>Stocks</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>H.slot</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>Sword</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Charts Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                    <i class="bx bx-task"></i><span>Projects</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>H.slot</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>Sword</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Icons Nav -->

            <li class="nav-heading">Projects</li>
            <!-- End Profile Page Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-question-circle"></i>
                    <span>F.A.Q</span>
                </a>
            </li>
            <!-- End F.A.Q Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-envelope"></i>
                    <span>Contact</span>
                </a>
            </li><!-- End Contact Page Nav -->
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
                                <h5 class="card-title">Back Up & Restore Settings</h5>

                                <!-- Bordered Tabs Justified -->
                                <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified"
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
                                    <div class="tab-pane fade show active" id="bordered-justified-backup"
                                        role="tabpanel" aria-labelledby="home-tab">
                                        <!-- Back Up setting Sections -->
                                        <!-- Multi Columns Form -->
                                        <form class="row g-3">
                                            <div class="col-md-6">
                                                <label for="inputEmail5"
                                                    class="form-label text-black">PERIOD</label>
                                                <!-- <input type="email" class="form-control" id="inputEmail5"> -->
                                                <div class="col-sm-10">
                                                    <select class="form-select"
                                                        aria-label="Default select example">
                                                        <option selected>Select your period for Back Up
                                                        </option>
                                                        <option value="1">Every day</option>
                                                        <option value="2">Two days</option>
                                                        <option value="3">Three days</option>
                                                        <option value="1">Four day</option>
                                                        <option value="2">Five days</option>
                                                        <option value="3">Six days</option>
                                                        <option value="3">Seven days</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputPassword5"
                                                    class="form-label text-black">PICK UP DATE</label>
                                                <div class="col-sm-10">
                                                    <input type="date" class="form-control">
                                                </div>
                                            </div>
                                        </form><!-- End Multi Columns Form -->
                                    </div>
                                    <div class="tab-pane fade" id="bordered-justified-restore"
                                        role="tabpanel" aria-labelledby="profile-tab">
                                        <!-- Restore Setting Sections  -->
                                        <form class="row g-3">
                                            <div class="col-md-6">
                                                <label for="inputEmail5"
                                                    class="form-label text-black">PERIOD</label>
                                                <!-- <input type="email" class="form-control" id="inputEmail5"> -->
                                                <div class="col-sm-10">
                                                    <select class="form-select"
                                                        aria-label="Default select example">
                                                        <option selected>Select your period for Back Up
                                                        </option>
                                                        <option value="1">Every day</option>
                                                        <option value="2">Two days</option>
                                                        <option value="3">Three days</option>
                                                        <option value="1">Four day</option>
                                                        <option value="2">Five days</option>
                                                        <option value="3">Six days</option>
                                                        <option value="3">Seven days</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputPassword5"
                                                    class="form-label text-black">PICK UP DATE</label>
                                                <div class="col-sm-10">
                                                    <input type="date" class="form-control">
                                                </div>
                                            </div>
                                        </form><!-- End Multi Columns Form -->
                                    </div>
                                </div><!-- End Bordered Tabs Justified -->

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Confirm</button>
                        <button type="button" class="btn btn-primary" onClick="alert('Saved!!!')">Save
                            changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Extra Large Modal-->
        <div class="pagetitle">
            <h1><?=$menu['menu']?></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><?=$menu['menu']?></a></li>
                    <li class="breadcrumb-item active">
                    <?php
                    if($menu['submenu']=="cm")
                        echo "Client Management";
                    else if($menu['submenu']=="im")
                        echo "Invoice Management";
                    else if($menu['submenu']=="pm")
                        echo "Payment Management";
                    else if($menu['submenu']=="pjm")
                        echo "Project Management";
                    else if($menu['submenu']=="prm")
                        echo "Proforma Management";
                    else if($menu['submenu']=="stm")
                        echo "Stock Management";
                    else if($menu['submenu']=="sm")
                        echo "Supplier Management";
                    else if($menu['submenu']=="pdm")
                        echo "Supplier Invoices";
                    else if($menu['submenu']=="pmbs")
                        echo "Stock Management By Stock";
                    ?></li>
                    <li class="breadcrumb-item active">
                    <?php
                    if($menu['submenu']=="pmbs")
                        echo $stock['name'];
                    ?>
                    </li>
                </ol>
            </nav>
        </div><!-- End Page Title -->