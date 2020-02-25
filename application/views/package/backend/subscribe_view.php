<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
     <!-- Begin page --> 	
        <div id="wrapper">
            	<?php include('side_menu.php')?>
<div class="content-page">
    <!-- Top Bar Start -->
    <div class="topbar">
        <nav class="navbar-custom">                  
            <ul class="list-inline menu-left mb-0">
                <li class="float-left">
                    <button class="button-menu-mobile open-left disable-btn">
                        <i class="dripicons-menu"></i>
                    </button>
                </li>
                <li>
                    <div class="page-title-box">
                       <h4>Subscribe</h4>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <!-- Top Bar End -->
<hr>
    <!-- Start Page content -->
    <div class="content">
        <div class="container-fluid">

            <div class="card-box">									<div id="showData">
                            <div class="pull-right">
                            </div>
                            <table id="table2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">No.</th>
                                        <th >E-mail</th>
                                        <th style="text-align:center;" >Date Subscribe</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
 <?php $n = 1; 
  $Subscribe =$this->Package_model->list_Subscribe();
    foreach ($Subscribe->result() AS $Data) {?>	
                                        <tr id="row<?php echo $Data->id ?>">
                                            <th scope="row" style="text-align:center;"><?php echo $n ?></th>
                                            <td><?php echo $Data->subscribe ?></td>
                                            <td style="text-align:center;"><?php echo $Data->date_add ?></td>
                                            
                                        </tr>
                                    <?php $n++;}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
              
            </div>

        </div> <!-- container -->

    </div> <!-- content -->

    <footer class="footer text-right">
        <!--2018 © Highdmin. - Coderthemes.com-->
    </footer>

</div>
       