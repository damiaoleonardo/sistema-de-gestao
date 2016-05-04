<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script type="text/javascript" src="jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="bootstrap-datepicker3.css"/>
        
        <link rel="stylesheet" href="bootstrap-iso.css" />
       <!-- <link rel="stylesheet" href="font-awesome.min.css" />
       <script type="text/javascript" src="formden.js"></script>
       -->
    </head>
    <body>

        <style>.bootstrap-iso .formden_header h2, .bootstrap-iso .formden_header p, .bootstrap-iso form{font-family: Arial, Helvetica, sans-serif; color: black}.bootstrap-iso form button, .bootstrap-iso form button:hover{color: white !important;} .asteriskField{color: red;}</style>
        
        <div class="bootstrap-iso">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <form action="https://formden.com/post/MlKtmY4x/" class="form-horizontal" method="post">
                            <div class="form-group ">
                                <label class="control-label col-sm-2 requiredField" for="date">
                                    Date
                                    <span class="asteriskField">
                                        *
                                    </span>
                                </label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar">
                                            </i>
                                        </div>
                                        <input class="form-control" id="date" name="date" placeholder="YYYY/MM/DD" type="text"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input name="_honey" style="display:none" type="text"/>
                                    <button class="btn btn-primary " name="submit" type="submit">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                var date_input = $('input[name="date"]');
                var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
                date_input.datepicker({
                    format: 'yyyy-mm-dd',
                    container: container,
                    todayHighlight: true,
                    autoclose: true,
                })
            })
        </script>
    </body>
</html>
