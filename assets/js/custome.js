$(document).ready(function () {
    $('.selct2').select2();

    $(document).off('click', '.clse').on('click', '.clse', function () {
        // alert('here');
        $(this).parent().parent().parent().remove();
    });

    $('ol.sortable').nestedSortable({
        handle: 'div.menu-handle',
        helper: 'clone',
        items: 'li',
        opacity: .6,
        revert: 250,
        tabSize: 25,
        tolerance: 'pointer',
        toleranceElement: '> div',
        isTree: true,
        change: function () {
            $("#output").text("item relocated");
        }
    });

    $(document).off('click', '#serialize_menu').on('click', '#serialize_menu', function (e) {
        e.preventDefault();

        var url = 'save_order';
        var sort = $('ol.sortable').nestedSortable('serialize');
        // alert(url);return false;
        $.ajax({

            url: url,
            type: "POST",
            // contentType: "application/json",  
            dataType: "json",
            data: { "sort": sort },
            success: function (resp) {
                // console.log(resp);return false;
                if (resp.status == "success") {
                    Toastify({
                        text: resp.status_message,
                        duration: 2000,
                        style: {
                            background: "#D44950",
                            color: "#fff",
                        }

                    }).showToast();
                } else {
                    Toastify({
                        text: resp.status_message,
                        duration: 2000,
                        style: {
                            background: "#D44950",
                            color: "#fff",
                        }

                    }).showToast();
                }

            }
        });
    });

    $(document).off('click', '.del_menu').on('click', '.del_menu', function (e) {
        e.preventDefault();

        var url = 'change_show_on_menu_status';
        var id = $(this).attr('id');
        // alert(id);return false;
        $.ajax({

            url: url,
            type: "POST",
            // contentType: "application/json",  
            dataType: "json",
            data: { "id": id },
            success: function (resp) {
                // console.log(resp);return false;
                if (resp.status == "success") {
                    Toastify({
                        text: resp.status_message,
                        duration: 2000,
                        style: {
                            background: "#D44950",
                            color: "#fff",
                        }

                    }).showToast();
                    location.reload();
                } else {
                    Toastify({
                        text: resp.status_message,
                        duration: 2000,
                        style: {
                            background: "#D44950",
                            color: "#fff",
                        }

                    }).showToast();
                }

            }
        });
    });

    $(document).off('click', '.edit_self ').on('click', '.edit_self ', function (e) {
        e.preventDefault();

        var url = 'get_menu_detail_for_form';
        var id = $(this).attr('id');
        // alert(id);return false;
        $.ajax({

            url: url,
            type: "POST",
            // contentType: "application/json",  
            dataType: "json",
            data: { "id": id },
            success: function (resp) {
                if (resp.status == "success") {
                    $('#myModalEdit #PageTitle').val(resp.detail.PageTitle);
                    $('#myModalEdit #PageTitleNepali').val(resp.detail.PageTitleNepali);
                    $('#myModalEdit #link').val(resp.detail.link);
                    $('#myModalEdit #show_type').val(resp.detail.show_type).attr("selected", "selected");;
                    $('#myModalEdit #record_id').val(resp.detail.id);
                    if (resp.detail.Type == 'em') {
                        // $('.url_only').show();
                        $("#url_only").css("display", "block");
                    } else {
                        // $('.url_only').hide();
                        $("#url_only").css("display", "none");
                    }
                    $('#myModalEdit').modal('show');
                } else {
                    Toastify({
                        text: resp.status_message,
                        duration: 2000,
                        style: {
                            background: "#D44950",
                            color: "#fff",
                        }

                    }).showToast();
                }

            }
        });
    });

    $(document).off('click', '.edit_self_service_category ').on('click', '.edit_self_service_category ', function (e) {
        e.preventDefault();
        // alert('hi');
        var url = 'get_menu_detail_for_form';
        var id = $(this).attr('id');
        // alert(id);return false;
        $.ajax({

            url: url,
            type: "POST",
            // contentType: "application/json",  
            dataType: "json",
            data: { "id": id },
            success: function (resp) {
                if (resp.status == "success") {
                    $('#myModalEdit #title').val(resp.detail.title);
                    $('#myModalEdit #title_nepali').val(resp.detail.title_nepali);
                    $('#myModalEdit #record_id').val(resp.detail.id);
                    $('#myModalEdit').modal('show');
                } else {
                    Toastify({
                        text: resp.status_message,
                        duration: 2000,
                        style: {
                            background: "#D44950",
                            color: "#fff",
                        }

                    }).showToast();
                }

            }
        });
    });

    $(document).off('click', '.del_service_category').on('click', '.del_service_category', function (e) {
        e.preventDefault();

        var url = 'change_show_on_menu_status';
        var id = $(this).attr('id');
        // alert(id);return false;
        $.ajax({

            url: url,
            type: "POST",
            // contentType: "application/json",  
            dataType: "json",
            data: { "id": id },
            success: function (resp) {
                // console.log(resp);return false;
                if (resp.status == "success") {
                    Toastify({
                        text: resp.status_message,
                        duration: 2000,
                        style: {
                            background: "#D44950",
                            color: "#fff",
                        }

                    }).showToast();
                    location.reload();
                } else {
                    Toastify({
                        text: resp.status_message,
                        duration: 2000,
                        style: {
                            background: "#D44950",
                            color: "#fff",
                        }

                    }).showToast();
                }

            }
        });
    });

    $(".main-img").click(function () {
        $(".drop_menuss").toggle(0);
    });


    $(".search_icons").click(function () {
        $(".search_box").slideDown('10000');
        $(".search_icons").hide();
        $(".search_icon_hide").show();
    });


    $(".search_icon_hide").click(function () {
        $(".search_box").slideUp('10000');
        $(".search_icon_hide").hide();
        $(".search_icons").show();
    });

});

