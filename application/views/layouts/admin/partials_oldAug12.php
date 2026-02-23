<script src="<?php echo base_url(); ?>assets/plugin/js/jquery.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugin/js/bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugin/js/fastclick.js"></script>

<script src="<?php echo base_url(); ?>assets/plugin/js/adminlte.min.js"></script>


<script src="<?php echo base_url(); ?>assets/plugin/js/dashboard2.js"></script>

<script src="<?php echo base_url(); ?>assets/plugin/js/demo.js"></script>

<script src="<?php echo base_url('assets/js/'); ?>moment.min.js"></script>

<script src="<?php echo base_url('assets/js/'); ?>daterangepicker.js"></script>

<script src="<?php echo base_url('assets/js/'); ?>summernote-bs4.min.js"></script>

<script src="<?php echo base_url('assets/js/'); ?>custome.js"></script>

<script src="<?php echo base_url('assets/js/'); ?>jquery.mjs.nestedSortable.js"></script>

<script src="<?php echo base_url('assets/plugin/js/select2.min.js'); ?>"></script>

<!-- ckeditor -->
<script src="<?php echo base_url('assets/plugins/ckeditor/ckeditor.js'); ?>"></script>
<!--<script src="//cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>-->


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script src="<?php echo base_url('assets/js/'); ?>jquery.overlayScrollbars.min.js"></script>

<script src="<?php echo base_url('assets/js/'); ?>jquery-ui.min.js"></script>

<script src="<?php echo base_url('assets/js/'); ?>jquery.mjs.nestedSortable.js"></script>
<script>
$(document).ready(function() {
    //select2
    $('.select2').select2();
    //end select 2
    // retrieve forex data from nrb
    $(document).off('click', '#generate_forex').on('click', '#generate_forex', function(e) {
        e.preventDefault();

        $.ajax({

            url: '<?php echo base_url('forex/admin/getForex'); ?>',
            type: "POST",
            // contentType: "application/json",  
            dataType: "json",
            // data: {
            //   "role_id": role_id,
            // },
            success: function(resp) {
                if (resp.status == "success") {
                    window.location.reload();
                } else {
                    // Toastify({

                    //   text: resp.status_message,

                    //   duration: 6000,

                    //   style: {
                    //     background: "linear-gradient(to right, red, yellow)",
                    //   }

                    // }).showToast();
                    alert(resp.status_message);
                }
            }
        });

    });


    // get location latitude and longitude
    $(document).off('change', '#role_id').on('change', '#role_id', function(e) {
        e.preventDefault();
        var role_id = $(this).val();

        $.ajax({

            url: '<?php echo base_url('module/admin/getForm'); ?>',
            type: "POST",
            // contentType: "application/json",  
            dataType: "json",
            data: {
                "role_id": role_id,
            },
            success: function(resp) {
                // console.log(resp.data);return false;
                // var obj = jQuery.parseJSON(resp);
                // console.log(resp.status);return false;
                if (resp.status == "success") {
                    $('#append_persmission').html(resp.data);
                } else {
                    Toastify({

                        text: resp.status_message,

                        duration: 6000,

                        style: {
                            background: "linear-gradient(to right, red, yellow)",
                        }

                    }).showToast();
                    // alert(resp.status_message);
                }
            }
        });

    });

    $(document).off('change', '#page').on('change', '#page', function(e) {
        e.preventDefault();
        var val = $(this).val();
        //   alert(val);
        if (val == 'Home') {
            $('#rate_js').show();
        } else {
            $('#rate_js').hide();
        }
    });

    // on change role get permissions form
    $(document).off('change', '#role_id').on('change', '#role_id', function(e) {
        e.preventDefault();
        var role_id = $(this).val();

        $.ajax({

            url: '<?php echo base_url('module/admin/getForm'); ?>',
            type: "POST",
            // contentType: "application/json",  
            dataType: "json",
            data: {
                "role_id": role_id,
            },
            success: function(resp) {
                // console.log(resp.data);return false;
                // var obj = jQuery.parseJSON(resp);
                // console.log(resp.status);return false;
                if (resp.status == "success") {
                    $('#append_persmission').html(resp.data);
                } else {
                    Toastify({

                        text: resp.status_message,

                        duration: 6000,

                        style: {
                            background: "linear-gradient(to right, red, yellow)",
                        }

                    }).showToast();
                    // alert(resp.status_message);
                }
            }
        });

    });

    //get form for functions for role
    $(document).off('click', '#add_function').on('click', '#add_function', function(e) {
        e.preventDefault();

        // $('#apnd_funct').append('<div class="col-md-4 rmv_modle"> <div class = "form-group"> <label> Function Name <span class = "req" > * </span></label> <span class = "rmv_btn_mdl rmv" > X </span> <input type = "text" name = "function_name[]" class = "form-control" placeholder = "Function Name" value = "" > </div> </div > ');
        $('#apnd_funct').append(
            '<div class="col-md-4 rmv_modle"> <div class="row" ><div class="col-md-6"> <div class="form-group"> <label> Function name <span class="req"> * </span></label> <input type="text" name = "function_name[]" class = "form-control" placeholder = "Function Name" value = ""> </div> </div> <div class="col-md-6"><div class="form-group"> <label> Display name <span class="req"> * </span></label> <input type="text" name="display_name_function[]" class="form-control" placeholder="Display Name" value="" ></div></div></div><span class="rmv_btn_mdl rmv_functns"> X </span> </div> '
        );
    });


    // REMOVE item

    $(document).off('click', '.rmv').on('click', '.rmv', function(e) {
        e.preventDefault();
        // alert('hi');
        $(this).parent().parent().remove();
    });

    // get staff of a department

    $(document).off('change', '#department_id').on('change', '#department_id', function(e) {
        var val = $(this).val();
        // alert(val);
        // return false;
        if (val == '') {
            alert('Select atleast one department');
            return false;
        }
        $.ajax({

            url: '<?php echo base_url('requisition/admin/getStaffOfDepartment'); ?>',
            type: "POST",
            // contentType: "application/json",  
            dataType: "json",
            data: {
                "val": val,
            },
            success: function(resp) {
                if (resp.status == "success") {
                    $('#requested_by').html(resp.data);
                } else {
                    alert(resp.status_message);
                }
            }
        });
        
        
        
    });

    
     $(document).off('change', '#province_id').on('change', '#province_id', function(event) {
        const provinceId = event.target.value;
        const url = event.target.getAttribute('data-url');
        if(provinceId){
              $.ajax({
    
                url: url,
                type: "POST",
                dataType: "json",
                data: {
                    provinceId,
                },
                success: function(resp) {
                    if (resp.status == "error") {
                        Toastify({
    
                            text: resp.status_message,
    
                            duration: 6000,
    
                            style: {
                                background: "linear-gradient(to right, red, yellow)",
                            }
    
                        }).showToast();
                    }
                    $('#district_id').html(resp.data);
                }
            });  
            return
        }
        Toastify({
    
            text: `Please select a valid provience.`,

            duration: 6000,

            style: {
                background: "linear-gradient(to right, red, yellow)",
            }

        }).showToast();
        $('#district_id').htmlhtml(`<option value=""> Select Branch Name </option>`);
        return
        
    });
    
    const exportElement = document.querySelectorAll ('.export-excel');
    
    const exportExcel = (event) =>{
        let url= event.target.getAttribute('data-url');
        if (!event.target.dataset.hasOwnProperty('url')) {
            url = event.target.parentElement.getAttribute('data-url');
        }
        
        const branchId = document.querySelector('#branch_id');
        const fullName = document.querySelector('#full_name');
        const highestEducation = document.querySelector('#highest_education');
         const careerId = document.querySelector('#career_id');
        const obj = {
            'branchId':branchId.value,
            'fullName':fullName.value,
            'highestEducation':highestEducation.value,
            'careerId': careerId.value
        };
        
        $('#loading').css('display', 'block');
        $.ajax({
    
            url: url,
            type: "POST",
            dataType: "json",
            data: obj,
            success: function(resp) {
                
                if(resp.status == 'success'){
                    var newDate = new Date();
                    var $a = $("<a>");
                        $a.attr("href",resp.file);
                        $("body").append($a);
                        $a.attr("download",`applicant-user-information-${newDate.toLocaleString()}.xls`);
                        $a[0].click();
                        $a.remove();
                        Toastify({

                            text: resp.status_message,
        
                            duration: 6000,
        
                            style: {
                                background: "linear-gradient(to right, green, yellow)",
                            }
        
                        }).showToast();
                     setTimeout(function () {
                        $('#loading').css('display', 'none');
                    }, 2000);
                    return
                }
                
                Toastify({

                    text: resp.status_message,

                    duration: 6000,

                    style: {
                        background: "linear-gradient(to right, red, yellow)",
                    }

                }).showToast();
                
            }
        }); 
        
    }
    
    for(let i = 0; exportElement.length >= i; i++){
        if(exportElement[i]){
            exportElement[i].addEventListener('click', exportExcel, false);
        }
        
    }
    
    const typeElement = document.querySelectorAll('.Type')
    const appendCareerForm = document.querySelector('#career');
    
    for(let i = 0; typeElement.length >= i; i++){
        
        if(typeElement[i]){
            appendCareerForm.style.display = 'none';
            const selectedValue = typeElement[i].options[typeElement[i].selectedIndex].value;
            if(selectedValue == 'career'){
                appendCareerForm.style.display = 'block';
            }
            typeElement[i].addEventListener('change', (event) =>{
                const typeValue = event.target.value
                if(typeValue){
                    switch(typeValue){
                        case 'career':
                            appendCareerForm.style.display = 'block';
                            break;
                            default:
                            appendCareerForm.style.display = 'none';
                    }
                    
                }
                
            }, false);
        }
        
    }
    $(document).off('change', '#type').on('change', '#type', function(e) {
        e.preventDefault();
        var val = $(this).val();
        // alert(val);
        if (val == 'others') {
            $('.ext_url').show();
        } else {
            $('.ext_url').hide();
        }
    });

    $(document).off('click', '.featured_image').on('click', '.featured_image', function(e) {
        e.preventDefault();
        // alert('rajesh');return false;
        var url =
            '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&popup=1&field_id=featured_image'); ?>';
        // alert(url);return false;
        var w = 880;
        var h = 570;
        var l = Math.floor((screen.width - w) / 2);
        var t = Math.floor((screen.height - h) / 2);
        var win = window.open(url, 'ResponsiveFilemanager', "scrollbars=1,width=" + w + ",height=" + h +
            ",top=" + t + ",left=" + l);
    });
    $(document).off('click', '.item_image').on('click', '.item_image', function(e) {
        e.preventDefault();
        // alert('rajesh');return false;
        var url =
            '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&popup=1&field_id=item_image'); ?>';
        // alert(url);return false;
        var w = 880;
        var h = 570;
        var l = Math.floor((screen.width - w) / 2);
        var t = Math.floor((screen.height - h) / 2);
        var win = window.open(url, 'ResponsiveFilemanager', "scrollbars=1,width=" + w + ",height=" + h +
            ",top=" + t + ",left=" + l);
    });

    $(document).off('click', '.generalized_img').on('click', '.generalized_img', function(e) {
        e.preventDefault();
        var field_id = $(this).prev().attr('id');
        // alert (field_id);return false;
        // alert(key);
        var url =
            '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&popup=1&field_id='); ?>' +
            field_id;
        var w = 880;
        var h = 570;
        var l = Math.floor((screen.width - w) / 2);
        var t = Math.floor((screen.height - h) / 2);
        var win = window.open(url, 'ResponsiveFilemanager', "scrollbars=1,width=" + w + ",height=" + h +
            ",top=" + t + ",left=" + l);
    })

    CKEDITOR.replace('description', {
        filebrowserBrowseUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>',
        filebrowserUploadUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>',
        filebrowserImageBrowseUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>'
    });

    CKEDITOR.replace('DescriptionNepali', {
        filebrowserBrowseUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>',
        filebrowserUploadUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>',
        filebrowserImageBrowseUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>'
    });

    CKEDITOR.replace('meta_description', {
        filebrowserBrowseUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>',
        filebrowserUploadUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>',
        filebrowserImageBrowseUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>'
    });

    CKEDITOR.replace('map_location', {
        filebrowserBrowseUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>',
        filebrowserUploadUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>',
        filebrowserImageBrowseUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>'
    });

    CKEDITOR.replace('contact_detail', {
        filebrowserBrowseUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>',
        filebrowserUploadUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>',
        filebrowserImageBrowseUrl: '<?php echo base_url('responsive_filemanager/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>'
    });



    // REMOVE functions in module module

    $(document).off('click', '.rmv_functns').on('click', '.rmv_functns', function(e) {
        e.preventDefault();
        // alert('hi');
        $(this).parent().remove();
    });

})
</script>

<?php if($this->session->flashdata('error')){ ?>
    <script>
    Toastify({
        text: "<?php echo $this->session->flashdata('error'); ?>",
        duration: 2000,
        style: {
            background: "#e61d27",
            color: "#fff",
        }
    
    }).showToast();
    </script>
<?php }
if($this->session->flashdata('success')){ ?>
    <script>
    Toastify({
        text: "<?php echo $this->session->flashdata('success'); ?>",
        duration: 2000,
        style: {
            background: "#00c468",
            color: "#fff",
        }
    
    }).showToast();
    
    </script>
<?php } ?>