
<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.0/b-2.0.0/b-html5-2.0.0/b-print-2.0.0/r-2.2.9/datatables.min.css"/>
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- Favicons-->
    <link rel="icon" href="{{ asset('images/logo.png') }}" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="{{ asset('icon/apple-touch-icon-152x152.png')}}">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="{{ asset('icon/mstile-144x144.png')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <title>HR</title>
    <style type="text/css">
        .sweet_loader {
            width: 140px;
            height: 140px;
            margin: 0 auto;
            animation-duration: 0.5s;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
            animation-name: ro;
            transform-origin: 50% 50%;
            transform: rotate(0) translate(0,0);
        }
        @keyframes ro {
            100% {
                transform: rotate(-360deg) translate(0,0);
            }
        }
    </style>
    
    <style>
        nav ul a,
        nav .brand-logo {
            color: #444;
        }
        
        p {
            line-height: 2rem;
        }
        
        .sidenav-trigger {
            color: #26a69a;
        }
        
        .parallax-container {
            min-height: 522px;
            line-height: 0;
            height: auto;
            color: rgba(255,255,255,.9);
        }
        .parallax-container .section {
            width: 100%;
        }
        
        @media only screen and (max-width : 992px) {
            .parallax-container .section {
                position: absolute;
                top: 40%;
            }
            #index-banner .section {
                top: 10%;
            }
        }
        
        @media only screen and (max-width : 600px) {
            #index-banner .section {
                top: 0;
            }
        }
        
        .icon-block {
            padding: 0 15px;
        }
        .icon-block .material-icons {
            font-size: inherit;
        }
        
        footer.page-footer {
            margin: 0;
        }
        
        span.field-icon {
            float: right;
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            z-index: 2;
        }
        
    </style>
    
    <script type="text/javascript">
        var sweet_loader = '<div class="sweet_loader"><svg viewBox="0 0 140 140" width="140" height="140"><g class="outline"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="rgba(0,0,0,0.1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></g><g class="circle"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="#71BBFF" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="200" stroke-dasharray="300"></path></g></svg></div>';
    </script>
    
</head>
<body>
    <nav class="grey darken-2" role="navigation">
        <div class="nav-wrapper container">
            <a id="logo-container" href="#" class="brand-logo" style="font-size: 4.1rem;"><img src="{{ asset('images/logo.png')}}" alt="Logo" height="50" width="50"></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="{{ url('/login') }}" style='color:white'>Account Login</a></li>
            </ul>
            
            <ul id="slide-out" class="sidenav">
                <li><a href="{{ url('/login') }}" class="black-text">Account Login</a></li>
            </ul>
            <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
    </nav>  
    
    <div id="index-banner" class="parallax-container">
        <div class="section no-pad-bot">
            <div class="container">
                <br><br>
                <h1 class="header center teal-text text-lighten-2">Human Resource Portal</h1>
                <div class="row center">
                    <h5 class="header col s12 light">Attain university status through Unity, Solidarity and Teamwork..</h5>
                </div>
                <div class="row center">
                    <a data-target="registerModal"  href="#registerModal" role="button" class="btn-large waves-effect waves-light teal lighten-1 modal-trigger">Get Started</a>
                </div>
            </div>
        </div>
        <div class="parallax"><img src="{{ asset('images/background1.jpg')}}" alt="Unsplashed background img 1"></div>
    </div>
    <div class="section"></div>
    
    <div class="container">
        <div class="section">
            
            <!--   Icon Section   -->
            <div class="row">
                <div class="col s12 m4 animate__animated animate__backInLeft">
                    <div class="icon-block">
                        <h2 class="center brown-text"><i class="material-icons">flash_on</i></h2>
                        <h5 class="center">Speeds up learning</h5>
                        <p class="light">Strive for academic excellence in instruction, research, extension and production through accreditation.</p>
                    </div>
                </div>
                
                <div class="col s12 m4 animate__animated animate__pulse">
                    <div class="icon-block">
                        <h2 class="center brown-text"><i class="material-icons">group</i></h2>
                        <h5 class="center">Great School Environment</h5>
                        <p class="light">Provide and maintain appropriate technologies, instructional facilities, materials and equipment.

</p>
                    </div>
                </div>
                
                <div class="col s12 m4 animate__animated animate__backInRight">
                    <div class="icon-block">
                        <h2 class="center brown-text"><i class="material-icons">settings</i></h2>
                        <h5 class="center">Easy to work with</h5>
                        <p class="light">Produce quality graduates who are globally competitive to man the needs of business and industry.</p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    
    <div class="parallax-container valign-wrapper">
        <div class="section no-pad-bot">
            <div class="container">
                <div class="row center">
                    <h5 class="header col s12 light" style="font-size: 34px;-webkit-text-stroke: 0.5px #e91212;-webkit-text-fill-color: #fefe00;font-weight: 900;">Provide appropriate and continuing faculty and staff development programs.</h5>
                </div>
            </div>
        </div>
        <div class="parallax"><img src="{{ asset('images/background2.jpg')}}" alt="Unsplashed background img 2"></div>
    </div>
    
    <div class="container">
        <div class="section">
            
            <div class="row">
                <div class="col s12 m6 center">
                    <h3><i class="mdi-content-send brown-text"></i></h3>
                    <h4>Contact Us</h4>
                    <p class="left-align light">
                        Address	:	Nagtahan, Sampaloc, Manila, 1008 Metro Manila</p>
                        <p class="left-align light">Tel	:	8243-9460</p>
                        <p class="left-align light">Tel	:	8243-9467</p>
                        <p class="left-align light">Email	:	earistaofficial@gmail.com</p>
                    </div>
                    <div class="col s12 m6 center">
                        <div class="card-panel grey lighten-3 z-depth-3">
                            <h5>Please fill out this form</h5>
                            <div class="input-field">
                                <input type="text" placeholder="Name" id="name">
                                <label for="name">Name</label>
                            </div>
                            <div class="input-field">
                                <input type="text" placeholder="Email" id="emailContact">
                                <label for="emailContact">Email</label>
                            </div>
                            <div class="input-field">
                                <input type="text" placeholder="Phone" id="phone">
                                <label for="phone">Phone</label>
                            </div>
                            <div class="input-field">
                                <textarea class="materialize-textarea" placeholder="Enter Message" id="message"></textarea>
                                <label for="message">Message</label>
                            </div>
                            <input type="submit" value="Submit" class="btn">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
        
        <div class="parallax-container valign-wrapper">
            <div class="section no-pad-bot">
                <div class="container">
                    <div class="row center">
                        <h5 class="header col s12 light"></h5>
                    </div>
                </div>
            </div>
            <div class="parallax"><img src="{{ asset('images/background3.jpg')}}" alt="Unsplashed background img 3"></div>
        </div>
        
        <div id="loginModal" class="modal modal-fixed-footer" style="overflow-y: visible;">
            <div class="modal-content">
                <h6 id="modalTitle" style="border-bottom: 1px solid teal;padding-bottom: 12px;border-bottom-width: thick;">Account Login</h6>
                <div class="row" id="content" >
                    <div class="row">
                        <form class="col s12" id="loginForm">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="username" type="text" name="username" class="validate">
                                    <label for="username">Username</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="password" type="password" name="password" class="validate">
                                    <label for="password">Password</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat red white-text">Cancel</a>
                <a href="#!" id="btn_login" class="waves-effect waves-green btn-flat green darken-3 white-text">Login</a>
            </div>
        </div>
        
        
        <div id="registerModal" class="modal modal-fixed-footer" style="overflow-y: visible;">
            <div class="modal-content">
                <h6 id="modalTitle" style="border-bottom: 1px solid teal;padding-bottom: 12px;border-bottom-width: thick;">Account Registration</h6>
                <div class="row" id="content" >
                    <div class="row">
                        <form class="col s12" id="registerForm">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="student_no" type="text" class="validate" name="student_no" onkeyup="this.value=this.value.replace(/[^\d]+/,'')">
                                    <label for="student_no">Student No</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 l6">
                                    <input id="first_name" type="text" class="validate" name="fname">
                                    <label for="first_name">First Name</label>
                                </div>
                                <div class="input-field col s12 l6">
                                    <input id="last_name" type="text" class="validate" name="lname">
                                    <label for="last_name">Last Name</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 l6">
                                    <input id="middle_name" type="text" class="validate" name="mname">
                                    <label for="middle_name">Middle Name</label>
                                </div>
                                <div class="input-field col s12 l6">
                                    <select class="validate" name="gender">
                                        <option value="" selected>Choose gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <label>Gender</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 l6">
                                    <input id="email" type="text" class="validate" name="email">
                                    <label for="email">Email</label>
                                </div>
                                <div class="input-field col s12 l6">
                                    <input id="mobile_number" type="text" class="validate" name="contact" placeholder="+639__-___-____" data-slots="_">
                                    <label for="mobile_number">Contact #</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 l6">
                                    <input id="age" type="text" class="validate" name="age">
                                    <label for="age">Age</label>
                                </div>
                                <div class="input-field col s12 l6">
                                    <input id="passwordReg" type="password" class="validate" name="password" max='16'>
                                    <label for="passwordReg">Password</label>
                                    <span toggle="#passwordReg" class="field-icon toggle-password"><span class="material-icons">visibility</span></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <div class="file-field input-field">
                                        <div class="btn">
                                            <span>Profile Image</span>
                                            <input type="file" name="profile_link">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text" placeholder="Upload picture">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" id="btn_modal_close" class="modal-close waves-effect waves-green btn-flat red white-text">Close</a>
                <a href="#!" id="btn_modal_save" class="waves-effect waves-green btn-flat green darken-3 white-text">Register</a>
            </div>
        </div>
        
        <footer class="page-footer grey darken-2">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5 class="white-text">Company Bio</h5>
                        <p class="grey-text text-lighten-4">As a state college, Eulogio “Amang” Rodriguez Institute of Science and Technology (EARIST) believes that education is not an area of knowledge that can be arrogated unto itself by one profession, nor it is a division separate and distinct from the society and the times in which it flourishes. It is a plexus of knowledge and skills applied to the economic, social and moral development of self-actualized and productive citizenry..</p>
                            
                            
                        </div>
                        <div class="col l3 s12">
                            <h5 class="white-text">Locations</h5>
                            <ul>
                                <li><a class="white-text" href="#!">Nagtahan, Sampaloc, Manila</a></li>
                                <li><a class="white-text" href="#!">1008 Metro Manila</a></li>
                            </ul>
                        </div>
                        <div class="col l3 s12">
                            <h5 class="white-text">Connect</h5>
                            <ul>
                                <li><a class="white-text" href="#!">earistaofficial@gmail.com</a></li>
                                <li><a class="white-text" href="https://www.facebook.com/EARISTOfficial/">https://www.facebook.com/EARISTOfficial/</a></li>
                                <li><a class="white-text" href="http://sticaloocan.edu.ph/">http://earist.edu.ph/</a></li>
                                <li><a class="white-text" href="#!">@earistaofficial</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer-copyright">
                    <div class="container">
                        Made by <a class="brown-text text-lighten-3" href="http://materializecss.com">©.</a>
                    </div>
                </div>
            </footer>
            
        </div>
        <!-- END WRAPPER -->
        
    </div>
    <!-- END MAIN -->
    
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.0/b-2.0.0/b-html5-2.0.0/b-print-2.0.0/r-2.2.9/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    
    <script>
        
        $(window).load(function() {
            $('.sidenav').sidenav();
            M.AutoInit();
            $('.modal').modal({
                dismissible: true, // Modal can be dismissed by clicking outside of the modal
                onOpenEnd: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
                    
                },
                onCloseEnd: function() { // Callback for Modal close
                    $(".modal").css("width", "60%");
                } 
            });
        });
        
        document.addEventListener('DOMContentLoaded', () => {
            for (const el of document.querySelectorAll("[placeholder][data-slots]")) {
                const pattern = el.getAttribute("placeholder"),
                slots = new Set(el.dataset.slots || "_"),
                prev = (j => Array.from(pattern, (c,i) => slots.has(c)? j=i+1: j))(0),
                first = [...pattern].findIndex(c => slots.has(c)),
                accept = new RegExp(el.dataset.accept || "\\d", "g"),
                clean = input => {
                    input = input.match(accept) || [];
                    return Array.from(pattern, c =>
                    input[0] === c || slots.has(c) ? input.shift() || c : c
                    );
                },
                format = () => {
                    const [i, j] = [el.selectionStart, el.selectionEnd].map(i => {
                        i = clean(el.value.slice(0, i)).findIndex(c => slots.has(c));
                        return i<0? prev[prev.length-1]: back? prev[i-1] || first: i;
                    });
                    el.value = clean(el.value).join``;
                    el.setSelectionRange(i, j);
                    back = false;
                };
                let back = false;
                el.addEventListener("keydown", (e) => back = e.key === "Backspace");
                el.addEventListener("input", format);
                el.addEventListener("focus", format);
                el.addEventListener("blur", () => el.value === pattern && (el.value=""));
            }
        });
        
        function validatorMaterializeInput(form){
            
            $(form).find('input.validate:text').each(function(idx){
                if($(this).val().length == 0){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Please input '+$(this).parent().find('label').text()+'.',
                        timer: 1000
                    })
                    $(this).addClass("invalid");
                    throw new Error("Something went badly wrong!");
                }else{
                    $(this).removeClass("invalid").addClass("valid");
                }
            });
            
            $(form).find('input.validate').each(function(idx){
                if ($(this).val().length == 0) {
                    $(this).addClass("is-invalid");
                    throw new Error("Something went badly wrong!");
                } else {
                    if($(this).attr("type") == "email"){
                        var emailpattern=/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                        if(emailpattern.test($(this).val()))
                        {
                            $(this).removeClass("invalid").addClass("valid");
                            throw new Error("Something went badly wrong!");
                        }
                        else
                        {
                            $(this).addClass("invalid");
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: 'Please input '+$(this).parent().find('label').text()+'.',
                                timer: 1000
                            })
                            throw new Error("Something went badly wrong!");
                        }
                    }
                }
            });
            
            $(form).find('select.validate').each(function(idx){
                
                if($(this).val().length == 0){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Please input '+$(this).parent().parent().find('label').text()+'.',
                        timer: 5000
                    })
                    $(this).focus();
                    $(this).parent().find("input").addClass("invalid");
                    throw new Error("Something went badly wrong!");
                }else{
                    $(this).parent().find('input').removeClass("invalid");
                    $(this).parent().find('input').addClass("valid");
                }
            });
            
            $(form).find('input.validate:password').each(function(idx){
                if($(this).val().length == 0){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Please input '+$(this).parent().find('label').text()+'.',
                        timer: 5000
                    })
                    $(this).focus();
                    $(this).addClass("invalid");
                    throw new Error("Something went badly wrong!");
                }else{
                    $(this).removeClass("invalid").addClass("valid");
                }
            });
            
            $(form).find('textarea.validate').each(function(idx){
                if($(this).val().length == 0){
                    $(this).addClass("invalid");
                    throw new Error("Something went badly wrong!");
                }else{
                    $(this).removeClass("invalid").addClass("valid");
                }
            });
            return true;
        }
        
        $("#btn_modal_save").unbind("click").click(function(){
            validatorMaterializeInput("#registerForm");
            var formdata = new FormData($('#registerForm')[0]);
            swal.fire({
                html: '<h4>Please wait.</h4>',
                onRender: function() {
                    $('.swal2-content').prepend(sweet_loader);
                }
            });
            
            $.ajax({
                url : "{{ url('applicant/saveApplicant') }}",
                type : "POST",
                data : formdata,
                processData: false,
                contentType: false,
                success : function(response){
                    if (response.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: response.title,
                            text: response.msg,
                            timer: 1500
                        })
                        $("#modalclose").click();
                        BatchList();
                    }else if (response.status == 2) {
                        Swal.fire({
                            icon: 'info',
                            title: response.title,
                            text: response.msg
                        })
                    }else if (response.status == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: response.title,
                            text: response.msg
                        })
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: "System Error",
                            text: "Please contact developer."
                        })
                    }
                }
            });
        });
        
        var clicked = 0;
        
        $(".toggle-password").click(function (e) {
            e.preventDefault();
            
            $(this).toggleClass("toggle-password");
            if (clicked == 0) {
                $(this).html('<span class="material-icons">visibility_off</span >');
                    clicked = 1;
                } else {
                    $(this).html('<span class="material-icons">visibility</span >');
                        clicked = 0;
                    }
                    
                    var input = $($(this).attr("toggle"));
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });
            </script>
            
        </body>
        
        </html>