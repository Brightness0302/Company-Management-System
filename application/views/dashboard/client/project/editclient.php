<!-- ======= Hero Section ======= -->

<body>
    <section id="hero" class="align-items-center">
        <div data-aos="fade-up" data-aos-delay="100">
            <a href="<?=base_url('client/projectmanager')?>"><button class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Company">&#8249;</button></a>
        </div>
        <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Assign Projects to Client(<?=$client['name']?>)</h1>
                </div>
            </div>

            <div class="card adduser_container">
                <div class="card-body">
                    <!-- Floating Labels Form -->
                    <div class="row g-3">
                        <div class="row">
                            <table id="projecttable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Project Name</th>
                                        <th>Invoices</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableclient">
                                    <?php foreach ($projects as $index => $project):?>
                                    <tr>
                                        <td><?=($index+1)?></td>
                                        <td id="projectname"><?=$project['name']?></td>
                                        <td>
                                            <div class="col-sm-10 m-auto">
                                                <select class="w-full form-select">
                                                    <?php
                                                        $length = 0;
                                                        foreach ($invoices as $invoice){
                                                            if ($project['id'] == $invoice['projectid']) {
                                                                $length++;
                                                                echo "<option>".$invoice['id']."</option>";
                                                            }
                                                        }
                                                        if ($length == 0) {
                                                            echo "<option>None Invoices</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="form-inline flex justify-around">
                                            <?php if ($client['id']==$project['clientid']):?>
                                            <button class='btn btn-danger' onclick='delAssign(this)'><i class='bi bi-cart-dash-fill'></i></button><p id='Assign' hidden>1</p>
                                            <?php elseif ($project['clientid']==0):?>
                                            <button class="btn btn-primary" onclick="addAssign(this)"><i class="bi bi-cart-plus"></i></button><p id="Assign" hidden>0</p>
                                            <?php else:?>
                                            <button class="btn btn-success" disabled><i class="bi bi-cart-x-fill"></i></button><p id="Assign" hidden>-1</p>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-primary w-24" onclick="saveClientbyprojects('<?=$client['name']?>')">Save</button>
                            <a type="reset" class="btn btn-secondary w-24" href="<?=base_url('client/projectmanager')?>">Cancel</a>
                        </div>
                    </div><!-- End floating Labels Form -->
                </div>
            </div>
        </div>
    </section><!-- End Hero -->