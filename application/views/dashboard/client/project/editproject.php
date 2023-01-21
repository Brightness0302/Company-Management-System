<!-- ======= Hero Section ======= -->

<body>
    <section id="hero" class="align-items-center" data-aos="fade-up" data-aos-delay="100">
        <div>
            <a href="<?=base_url('client/projectmanager')?>"><button class="backbutton w-8 sm:w-12 h-8 sm:h-12 text-sm sm:text-2xl"
                    title="Add New Company">&#8249;</button></a>
        </div>
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>Edit Project</h1>
                </div>
            </div>

            <div class="card adduser_container">
                <div class="card-body">
                    <!-- Floating Labels Form -->
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="projectname" placeholder="ProjectName" value="<?=$project['name']?>">
                                <label for="floatingEmail">Project Name</label>
                            </div>
                        </div>

                        <hr class="p-0">

                        <h4>Project's Assigning</h4>

                        <div class="row">
                            <table id="projecttable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th><div class="row"><div class="col-sm-6">Invoice Number</div><div class="col-sm-6">Billed to</div></th>
                                        <th>Description</th>
                                        <th>Issued Date</th>
                                        <th>Amount/Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table">
                                    <?php foreach ($invoices as $index => $invoice):?>
                                    <tr>
                                        <td><?=($index+1)?></td>
                                        <td><div class="row"><div id="invoiceid" class="col-sm-6"><?=$invoice['id']?></div><div class="col-sm-6">
                                            <?php 
                                                $result;
                                                foreach ($clients as $client){
                                                    if ($client['id'] == $invoice['client_id']) {
                                                        $result = $client;
                                                    }
                                                }
                                                echo str_replace("_"," ", $result['name']);
                                            ?></div></td>
                                        <td><?=$invoice['input_inputreference']?></td>
                                        <td><?=$invoice['date_of_issue']?></td>
                                        <td><?=$invoice['total']?>/<?=$invoice['ispaid']?"Paid":"Unpaid"?></td>
                                        <td class="form-inline flex justify-around">
                                            <?php if ($invoice['projectid']==$project['id']):?>
                                            <button class='btn btn-danger' onclick='delAssign(this)'><i class='bi bi-cart-dash-fill'></i></button><p id='Assign' hidden>1</p>
                                            <?php elseif ($invoice['projectid']==0):?>
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
                            <button type="button" class="btn btn-primary w-24" onclick="saveProject('<?=$project['id']?>')">Save</button>
                            <a type="reset" class="btn btn-secondary w-24" href="<?=base_url('client/projectmanager')?>">Cancel</a>
                        </div>
                    </div><!-- End floating Labels Form -->
                </div>
            </div>
        </div>
    </section><!-- End Hero -->