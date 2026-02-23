<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <a class="btn btn-sm btn-primary">Application View</a>
                    </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="application_view">
                        <ul>
                            <li>
                                <p>Full Name : <span><?php echo $detail->fullname; ?></span></p>
                            </li>
                            <li>
                                <p>Email : <span><?php echo $detail->email; ?></span></p>
                            </li>
                            <li>
                                <p>Address : <span><?php echo $detail->address; ?></span></p>
                            </li>
                            <li>
                                <p>Contact : <span><?php echo $detail->phone; ?></span></p>
                            </li>
                            <li>
                                <p>Message : <span><?php echo $detail->message; ?></span></p>
                            </li>
                            <li>
                                <p>Created On : <span><?php echo $detail->created_on; ?></span></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>