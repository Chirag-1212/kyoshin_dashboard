<style>
    .SUB_BTN .btn {
        width: 90px;
        height: 35px;
        font-size: 15px;
    }
</style>


<section class="content">
    <div class="container-fluid">
        <!--<h2 class="text-center display-4">Search</h2>-->
        <form action="<?php echo base_url('bank_guarantee/admin/search_logged_users'); ?> " method="post">
                    
	    <div class="search_icons">
	        <i title="Click Here" class="zmdi zmdi-search"></i>
	    </div>
	    <div class="search_icon_hide ">
	        <i title="Close" class="zmdi zmdi-close-circle-o"></i>
	    </div>
        <div class="search_box">
            <div class="row"> 
                <div class="col-sm-6">
                     <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Email" value="">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Reference Number</label>
                        <input type="text" name="reference_number" class="form-control" placeholder="Reference Number" value="">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="SUB_BTN"><input class="btn btn-sm btn-primary" type="submit" name="submit" value=" search">   </div>
                </div>
                <!--<div class="col-sm-2">-->
                <!--    <div class="SUB_BTN"><input class="btn btn-sm btn-primary" type="submit" name="pdf" value="Export to pdf" style="width: 100%;">   </div>-->
                <!--</div>-->
            </div> 
        </div>
                  
        </form>
    </div>
</section>