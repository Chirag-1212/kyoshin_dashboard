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
        <form action="<?php echo base_url('news/admin/search'); ?> " method="post">
                    
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
                    <label>Date from <span class="req"></span></label>
                         <input type="date" name="date_from" class="form-control" value="">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                    <label>Date to <span class="req"></span></label>
                         <input type="date" name="date_to" class="form-control" value="">
                    </div>
                </div>
                <div class="col-sm-6">
                     <div class="form-group">
                         <label>Title</label>
                        <input type="text" name="Title" class="form-control" placeholder="Title" value="">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                    <label>Status</label>
                       <select name="status" class="form-control selct2" id="type">
                            <option value="1" >Active</option>
                            <option value="0" >Enable</option> 
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="SUB_BTN"><input class="btn btn-sm btn-primary" type="submit" name="submit" value=" search">   </div>
                </div>
            </div> 
        </div>
                  
        </form>
    </div>
</section>