<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site_settings->short_name; ?></title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugin/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugin/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugin/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugin/css/AdminLTE.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugin/css/blue.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script nonce="e4808b81-7fd8-4956-bd4f-660288d08b2f">
    (function(w, d) {
        ! function(j, k, l, m) {
            j[l] = j[l] || {};
            j[l].executed = [];
            j.zaraz = {
                deferred: [],
                listeners: []
            };
            j.zaraz.q = [];
            j.zaraz._f = function(n) {
                return async function() {
                    var o = Array.prototype.slice.call(arguments);
                    j.zaraz.q.push({
                        m: n,
                        a: o
                    })
                }
            };
            for (const p of ["track", "set", "debug"]) j.zaraz[p] = j.zaraz._f(p);
            j.zaraz.init = () => {
                var q = k.getElementsByTagName(m)[0],
                    r = k.createElement(m),
                    s = k.getElementsByTagName("title")[0];
                s && (j[l].t = k.getElementsByTagName("title")[0].text);
                j[l].x = Math.random();
                j[l].w = j.screen.width;
                j[l].h = j.screen.height;
                j[l].j = j.innerHeight;
                j[l].e = j.innerWidth;
                j[l].l = j.location.href;
                j[l].r = k.referrer;
                j[l].k = j.screen.colorDepth;
                j[l].n = k.characterSet;
                j[l].o = (new Date).getTimezoneOffset();
                if (j.dataLayer)
                    for (const w of Object.entries(Object.entries(dataLayer).reduce(((x, y) => ({
                            ...x[1],
                            ...y[1]
                        })), {}))) zaraz.set(w[0], w[1], {
                        scope: "page"
                    });
                j[l].q = [];
                for (; j.zaraz.q.length;) {
                    const z = j.zaraz.q.shift();
                    j[l].q.push(z)
                }
                r.defer = !0;
                for (const A of [localStorage, sessionStorage]) Object.keys(A || {}).filter((C => C.startsWith(
                    "_zaraz_"))).forEach((B => {
                    try {
                        j[l]["z_" + B.slice(7)] = JSON.parse(A.getItem(B))
                    } catch {
                        j[l]["z_" + B.slice(7)] = A.getItem(B)
                    }
                }));
                r.referrerPolicy = "origin";
                r.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(j[l])));
                q.parentNode.insertBefore(r, q)
            };
            ["complete", "interactive"].includes(k.readyState) ? zaraz.init() : j.addEventListener(
                "DOMContentLoaded", zaraz.init)
        }(w, d, "zarazData", "script");
    })(window, document);
    </script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <!-- <a href="<?php echo  base_url('login'); ?>"><img width="100px" src="<?php echo base_url().$site_settings->fav; ?>" alt=""></a> -->

        </div>

        <div class="login-box-body">
            <div class="login-box-msg">
                 <img width="300px" src="<?php echo base_url().$site_settings->logo; ?>" alt="<?php echo $site_settings->short_name; ?>">
            </div>
           
            <!-- <h2 class="login-box-msg"><b><?php echo $site_settings->short_name; ?></b></h2> -->

            <form action="" method="post">
                <div class="form-group has-feedback">
                    <input type="text" name="username" class="form-control" placeholder="Username"
                        value="<?php echo set_value('username'); ?>">
                    <span class="fa fa-user form-control-feedback"></span>
                    <?php echo form_error('username'); ?>
                </div>
                <div class="form-group has-feedback" style="position:relative;">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password"
                        value="<?php echo set_value('password'); ?>">

                    <!-- Eye Icon -->
                    <span toggle="#password" 
                        class="fa fa-eye toggle-password" 
                        style="position:absolute; right:10px; top:10px; cursor:pointer;">
                    </span>

                    <?php echo form_error('password'); ?>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <!-- <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                        </div> -->
                    </div>

                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>

                </div>
            </form>

            <!-- <a href="#">I forgot my password</a><br>
            <a href="register.html" class="text-center">Register a new membership</a> -->
        </div>

    </div>


    <script src="<?php echo base_url(); ?>assets/plugin/js/jquery.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/plugin/js//bootstrap.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/plugin/js/icheck.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugin/js/notify.js"></script>
    <script>
    $(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });

    });
    </script>
    <?php if($this->session->flashdata('error')){ ?>
    <script>
    $.notify("<?php echo $this->session->flashdata('error'); ?>", {
        color: "#fff",
        background: "#D44950",
        close: true
    });
    </script>
    <?php }else{ ?>
    <script>
    $.notify("<?php echo $this->session->flashdata('success'); ?>", {
        color: "#fff",
        background: "#4B7EE0",
        close: true
    });
    </script>
    <script>
        $(document).on('click', '.toggle-password', function () {

            $(this).toggleClass("fa-eye fa-eye-slash");

            var input = $("#password");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });
        </script>
    <?php } ?>
</body>

</html>