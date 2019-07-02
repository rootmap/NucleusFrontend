<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CmsRootPlugin {

    public function GeneralCss($lib = array()) {
        $content = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
                    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
                    <link rel="icon" href="/favicon.ico" type="image/x-icon">
                    <title> Nucleus  </title>
                    <link  type="text/css"  href=' . $this->baseUrl("css/main.css") . ' rel="stylesheet" />
                    <script type="text/javascript" src=' . $this->baseUrl("js/jquery-1.9.1.js") . '></script>
                    <script type="text/javascript" src=' . $this->baseUrl("js/jquery-migrate-1.0.0.js") . '></script>
                    <script type="text/javascript" src=' . $this->baseUrl("js/jquery_ui_custom.js") . '></script>
                    <script type="text/javascript" src=' . $this->baseUrl("js/plugins/charts/jquery.sparkline.min.js") . '></script>
                    
                    
                    <script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.autosize.js") . '></script>
                    
                    
                    
                    <script type="text/javascript" src=' . $this->baseUrl("js/plugins/ui/jquery.collapsible.min.js") . '></script>
                    
                    <script type="text/javascript" src=' . $this->baseUrl("js/plugins/ui/jquery.jgrowl.min.js") . '></script>
                    <script type="text/javascript" src=' . $this->baseUrl("js/functions/custom.js") . '></script>';

        if (!empty($lib)) {
            foreach ($lib as $css) {
                if ($css == "modal") {
                    $content .=$this->Modal();
                } elseif ($css == "color") {
                    $content .=$this->Color();
                } elseif ($css == "chart") {
                    $content .=$this->Chart();
                } elseif ($css == "form") {
                    $content .=$this->Form();
                } elseif ($css == "select") {
                    $content .=$this->Select();
                } elseif ($css == "button") {
                    $content .=$this->Button();
                } elseif ($css == "editor") {
                    $content .=$this->Editor();
                } elseif ($css == "time") {
                    $content .=$this->Time();
                } elseif ($css == "table") {
                    $content .=$this->Table();
                } elseif ($css == "validate") {
                    $content .=$this->Validate();
                } elseif ($css == "kendo") {
                    $content .=$this->KendoHead();
                }
            }
        }

        return $content;
    }

    private function KendoHead() {
        $content = '<link rel="stylesheet" href=' . $this->baseUrl("kendoui/styles/kendo.common.min.css") . '  />
                  <link rel="stylesheet" href=' . $this->baseUrl("kendoui/styles/kendo.metro.min.css") . '  />';
        
        $content .=$this->KenduCss();
        return $content;
    }

    public function KendoFotter() {
        $content = '<script type="text/javascript" src=' . $this->baseUrl("kendoui/js/kendo.web.min.js") . '></script>';

        return $content;
    }

    public function KendoFilter($filter_data, $prefix = '', $parp = 0) {
        $itemcount = count($filter_data);
        $where = "";
        $intcount = 0;
        $noend = false;
        $nobegin = false;

        if (isset($filter_data["filters"][$parp]["field"])) {
            $filvalcus = $filter_data["filters"][$parp]["value"];
            $filval = $filvalcus;


            switch ($filter_data['filters'][$parp]['operator']) {

                case 'startswith':
                    $compare = " LIKE ";
                    $field = $filter_data["filters"][$parp]["field"];
                    $value = "'%" . $filval . "%' ";
                    break;
                case 'contains':
                    $compare = " LIKE ";
                    $value = " '%" . $filval . "%' ";
                    break;
                case 'doesnotcontain':
                    $compare = " NOT LIKE ";
                    $value = " '%" . $filval . "%' ";
                    break;
                case 'endswith':
                    $compare = " LIKE ";
                    $value = "'%" . $filval . "%'";
                    break;
                case 'eq':
                    $compare = " = ";
                    $value = "'" . $filval . "'";
                    break;
                case 'gt':
                    $compare = ">";
                    $value = "'" . $filval . "'";
                    break;
                case 'lt':
                    $compare = "<";
                    $value = "'" . $filval . "'";
                    break;
                case 'gte':
                    $compare = ">=";
                    $value = "'" . $filval . "'";
                    break;
                case 'lte':
                    $compare = "<=";
                    $value = "'" . $filval . "'";
                    break;
                case 'neq':
                    $compare = " <> ";
                    $value = "'" . $filval . "'";
                    break;
            }
        }



        $param = $prefix . $filter_data["filters"][$parp]["field"] . $compare . $value;
        return $param;
    }

    public function KenduFilterParam($sqlstring, $confilter) {
        $sqlOrderList_filt = "SELECT AllKenduData.* FROM (" . $sqlstring . ") as AllKenduData WHERE " . $confilter;
        return $sqlOrderList_filt;
    }

    public function FrontEndDateSearch($from = '', $to = '') {
        if (isset($_GET[$from]) && isset($_GET[$to])) {
            $cond = '?' . $from . '=' . $_GET[$from] . '&' . $to . '=' . $_GET[$to];
        } else {
            $cond = '';
        }

        return $cond;
    }

    public function BackEndDateSearch($from = '', $to = '', $field = '', $prefix = '', $operation = '') {
        if (isset($_GET[$from]) && isset($_GET[$to])) {
            $cond = $operation . "" . $prefix . "" . $field . ">='" . $_GET[$from] . "' AND " . $prefix . "" . $field . "<='" . $_GET[$to] . "'";
        } else {
            $cond = '';
        }

        return $cond;
    }

    public function BackEndCondCreatorByArray($array = array(''), $field = '', $prefix = '', $operation = '') {
        if (!empty($array)) {
            foreach ($array as $ar):
                $cond = $operation . "" . $prefix . "" . $field . "='" . $ar . "'";
            endforeach;
        } else {
            $cond = '';
        }

        return $cond;
    }

    private function baseUrl($suffix = '') {
        $protocol = strpos($_SERVER['SERVER_SIGNATURE'], '443') !== false ? 'https://' : 'http://';
        //$web_root = $protocol . $_SERVER['HTTP_HOST'] . "/" . "Dropbox/odesk/pos/";
        if ($_SERVER['HTTP_HOST'] == "localhost") {
            $web_root = $protocol . $_SERVER['HTTP_HOST'] . "/" . "Dropbox/account_nucleus/";
        }elseif ($_SERVER['HTTP_HOST'] == "192.168.0.132") {
            $web_root = $protocol . $_SERVER['HTTP_HOST'] . "/" . "Dropbox/account_nucleus/";    
        } else {
            $web_root = $protocol . $_SERVER['HTTP_HOST'] . "/" . "kendo/";
        }

        $suffix = ltrim($suffix, '/');
        return $web_root . trim($suffix);
    }

    private function KenduCss() {
        $content = '<style>
                    span.k-picker-wrap{ padding-bottom:1px; }
                    span.k-dropdown-wrap{ margin-bottom:0px !important;  }
                    .k-input{ margin:0px !important; }
                    .k-i-arrow-s{ margin-top:-3px !important; }
                    .k-dropdown-wrap{ margin-bottom:4px !important; }
                    .k-pager-refresh,.k-textbox,.k-widget{ margin-top:1px !important; }
                    .k-grid-filter{ padding-top:0px !important; }
                    .k-grouping-header{ padding-left:10px !important; }
                    .k-i-clock,.k-add,.k-delete,.k-edit{ margin-top:0px !important; }
                    button.k-button{ padding:5px; font-size:12px; font-weight:bolder; color:#292B29; }
                  </style>';
        return $content;
    }

    private function Modal() {
        $content = '<script type="text/javascript" src="' . $this->baseUrl("js/plugins/bootstrap/bootstrap.min.js") . '"></script>
                    <script type="text/javascript" src="' . $this->baseUrl("js/plugins/bootstrap/bootstrap-bootbox.min.js") . '"></script>';
        return $content;
    }

    private function Color() {
        $content = "
            <script>
            $(document).ready(function () {
            $('.progress .bar.filled-text').progressbar({
                display_text: 1
            });

            $('.slim .bar').progressbar();

            $('.delay .bar').progressbar({
                display_text: 1,
                transition_delay: 2000
            });

            $('.value .bar').progressbar({
                display_text: 1,
                use_percentage: false
            });

            $('.progress .bar.centered-text').progressbar({
                display_text: 2
            });

            $('.progress .no-text').progressbar();
            });
            


        
            </script>";
                $content .='<script type="text/javascript" src="' . $this->baseUrl("js/plugins/bootstrap/bootstrap.min.js") . '"></script>
                    <script type="text/javascript" src="' . $this->baseUrl("js/plugins/bootstrap/bootstrap-bootbox.min.js") . '"></script>
                    <script type="text/javascript" src="' . $this->baseUrl("js/plugins/bootstrap/bootstrap-progressbar.js") . '"></script>
                    <script type="text/javascript" src="' . $this->baseUrl("js/plugins/bootstrap/bootstrap-colorpicker.js") . '"></script>';


        $content .='<script>

            // Loading button
        $("#loading").click(function () {
            var btn = $(this)
            btn.button("loading")
            setTimeout(function () {
              btn.button("reset")
            }, 3000);
            });


        // Typeahead
        $(document).ready(function () {
            $(".typeahead").typeahead();


            // Popover
            $(".popover-test").popover({
                    placement: "left"
            })
            .click(function(e) {
                    e.preventDefault()
            });

            $("a[rel=popover]")
                    .popover()
            .click(function(e) {
                    e.preventDefault()
            })


            // Tooltips
            $(".focustip").tooltip({"trigger":"focus"});
            $(".hovertip").tooltip();
            $(".tooltips, .table, .icons").tooltip({
                    selector: "a[rel=tooltip]"
            });

            });
            
           
        
        </script>';

        return $content;
    }

    private function Chart() {
        $content = '<script type="text/javascript" src=' . $this->baseUrl("js/plugins/charts/excanvas.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/charts/jquery.flot.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/ui/jquery.pie.chart.js") . '></script>
                                <script type="text/javascript" src=' . $this->baseUrl("js/plugins/charts/jquery.flot.resize.js") . '>
                                </script><script type="text/javascript" src=' . $this->baseUrl("js/charts/chart.js") . '></script>';
        $content .='<script>
        $(".piechart > li > div").easyPieChart({
            animate: 2000,
                trackColor:	"#ddd",
                scaleColor:	"#ddd",
                lineWidth: 3,
                barColor: "#d07571",
                size: 94
         });
        </script>';
        return $content;
    }

    private function Form() {
        $content = '<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.maskedinput.min.js") . '></script><script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.tagsinput.min.js") . '></script>
                    <script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.inputlimiter.min.js") . '></script>
                                <script type="text/javascript" src=' . $this->baseUrl("js/plugins/wizard/jquery.form.wizard.js") . '></script>
                    <script type="text/javascript" src=' . $this->baseUrl("js/plugins/wizard/jquery.form.js") . '></script>
                    ';
        $content .='<script>
            $(document).ready(function () {
        $.mask.definitions["~"] = "[+-]";
        $(".maskDate").mask("99/99/9999",{completed:function(){alert("Callback when completed");}});
        $(".maskPhone").mask("(999) 999-9999");
        $(".maskPhoneExt").mask("(999) 999-9999? x99999");
        $(".maskIntPhone").mask("+33 999 999 999");
        $(".maskTin").mask("99-9999999");
        $(".maskSsn").mask("999-99-9999");
        $(".maskProd").mask("a*-999-a999", { placeholder: " " });
        $(".maskEye").mask("~9.99 ~9.99 999");
        $(".maskPo").mask("PO: aaa-999-***");
        $(".maskPct").mask("99%");    
        $(".tags").tagsInput({width:"100%"});    
        $(".lim").inputlimiter({
                limit: 100,
                boxId: "limitingtext",
                boxAttach: false
        });    
        $("#wizard1").formwizard({
                formPluginEnabled: true, 
                validationEnabled: false,
                focusFirstInput : false,
                disableUIStyles : true,

                formOptions :{
                        success: function(data){$("#status1").fadeTo(500,1,function(){ $(this).html("<span>Form was submitted!</span>").fadeTo(5000, 0); })},
                        beforeSubmit: function(data){$("#w1").html("<span>Form was submitted with ajax. Data sent to the server: " + $.param(data) + "</span>");},
                        resetForm: true
                }
        });

        $("#wizard2").formwizard({ 
                formPluginEnabled: true,
                validationEnabled: true,
                focusFirstInput : false,
                disableUIStyles : true,

                formOptions :{
                        success: function(data){$("#status2").fadeTo(500,1,function(){ $(this).html("<span>Form was submitted!</span>").fadeTo(5000, 0); })},
                        beforeSubmit: function(data){$("#w2").html("<span>Form was submitted with ajax. Data sent to the server: " + $.param(data) + "</span>");},
                        dataType: "json",
                        resetForm: true
                },
                validationOptions : {
                        rules: {
                                bazinga: "required",
                                email: { required: true, email: true }
                        },
                        messages: {
                                bazinga: "Bazinga. This note is editable",
                                email: { required: "Please specify your email", email: "Correct format is name@domain.com" }
                        },
                    highlight: function(label) {
                        $(label).closest(".control-group").addClass("error");
                    },
                    success: function(label) {
                        label
                                .text("Success!").addClass("valid")
                                .closest(".control-group").addClass("success");
                    }
                }
        });

        $("#wizard3").formwizard({
                formPluginEnabled: false, 
                validationEnabled: false,
                focusFirstInput : false,
                disableUIStyles : true
        });
        });
        
        </script>';

        return $content;
    }

    private function Select() {
        $content = '<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.dualListBox.js") . '></script>
                                <script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.select2.min.js") . '></script>';


        $content .='<script>
        $.configureBoxes();    
        $(".select").select2({
                minimumResultsForSearch: "-1"
        });

        $(".select-liquid").select2({
                minimumResultsForSearch: "-1",
                width: "auto"
        });

        $(".select-full").select2({
                minimumResultsForSearch: "-1",
                width: "100%"
        });


        $(".select-search").select2();


        $("#loading-data").select2({
                placeholder: "Enter at least 1 character",
                allowClear: true,
                minimumInputLength: 1,
                query: function (query) {
                    var data = {results: []}, i, j, s;
                    for (i = 1; i < 5; i++) {
                        s = "";
                        for (j = 0; j < i; j++) {s = s + query.term;}
                        data.results.push({id: query.term + i, text: s});
                    }
                    query.callback(data);
                }
        });		

        $(".maximum-select").select2({ maximumSelectionSize: 3 });		

        $("#clear-results").select2({
            placeholder: "Select a State",
            allowClear: true
        });

        $(".minimum-select").select2({
            minimumInputLength: 2
        });

        $(".select-disabled").select2(
            "enable", false
        );

        $("#minimum-input-single").select2({
            minimumInputLength: 2
        });
        </script>';

        return $content;
    }

    private function Button() {
        $content = '<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.ibutton.js") . '></script>';

        $content .='<script>
        $(".on_off :checkbox, .on_off :radio").iButton({
                labelOn: "",
                labelOff: "",
                enableDrag: false 
        });

        $(".on_off2 :checkbox, .on_off2 :radio").iButton({
                labelOn: "Yeah",
                labelOff: "Nope",
                enableDrag: false 
        });

        $(".yes_no :checkbox, .yes_no :radio").iButton({
                labelOn: "On",
                labelOff: "Off",
                enableDrag: false
        });

        $(".enabled_disabled :checkbox, .enabled_disabled :radio").iButton({
                labelOn: "Enabled",
                labelOff: "Disabled",
                enableDrag: false
        });
        </script>';

        return $content;
    }

    private function Editor() {
        $content = '<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.cleditor.js") . '></script>';
        $content .='<script>
                    $("#editor").cleditor({
                            width:"100%", 
                            height:"250px",
                            bodyStyle: "margin: 10px; font: 12px Arial,Verdana; cursor:text",
                            docType: "<!DOCTYPE html>",
                            useCSS:true
                    });

        </script>';
        return $content;
    }

    private function Time() {
        $content = '<script type="text/javascript" src=' . $this->baseUrl("js/plugins/ui/jquery.timepicker.min.js") . '></script>';
        $content .='<script>
        $("#defaultValueExample, #time").timepicker({ "scrollDefaultNow": true });

        $("#durationExample").timepicker({
                "minTime": "2:00pm",
                "maxTime": "11:30pm",
                "showDuration": true
        });

        $("#onselectExample").timepicker();
        $("#onselectExample").on("changeTime", function() {
                $("#onselectTarget").text($(this).val());
        });

        $("#timeformatExample1").timepicker({ "timeFormat": "H:i:s" });
        $("#timeformatExample11").timepicker({ "timeFormat": "H:i:s" });
        $("#timeformatExample2").timepicker({ "timeFormat": "h:i A" });
        </script>';

        return $content;
    }

    private function Table() {
        $content = '<script type="text/javascript" src="' . $this->baseUrl("js/plugins/uploader/plupload.js") . '"></script>
                    <script type="text/javascript" src="' . $this->baseUrl("js/plugins/uploader/jquery.plupload.queue.js") . '"></script>    
                    <script type="text/javascript" src="' . $this->baseUrl("js/plugins/ui/jquery.elfinder.js") . '"></script>
                    <script type="text/javascript" src="' . $this->baseUrl("js/plugins/ui/jquery.fancybox.js") . '"></script>
                    <script type="text/javascript" src="' . $this->baseUrl("js/plugins/tables/jquery.dataTables.min.js") . '"></script>';
        $content .='<script>
                    $(".lightbox").fancybox({
                            "padding": 2
                    });
                    var dfg=&#39;<"datatable-header"fl>t<"datatable-footer"ip>&#39;;
                    oTable = $("#data-table").dataTable({
                                "bJQueryUI": false,
                                "bAutoWidth": false,
                                "sPaginationType": "full_numbers",
                                "sDom": dfg,
                                "oLanguage": {
                                        "sLengthMenu": "<span>Show entries:</span> _MENU_"
                                }
                    });
                    $("#uploader").pluploadQueue({
                            runtimes : "html5,html4",
                            url : "php/upload.php",
                            max_file_size : "1kb",
                            unique_names : true,
                            filters : [
                                    {title : "Image files", extensions : "jpg,gif,png"}
                            ]
                    });
                    var elf = $("#file-manager").elfinder({
                            url : "php/connector.php",  // connector URL (REQUIRED)
                            uiOptions : {
                                    // toolbar configuration
                                    toolbar : [
                                            ["back", "forward"],
                                            ["info"],
                                            ["quicklook"],
                                            ["search"]
                                    ]
                            },
                            contextmenu : {
                              // Commands that can be executed for current directory
                              cwd : ["reload", "delim", "info"], 
                              // Commands for only one selected file
                              files : ["select", "open"]
                            }
                    }).elfinder("instance");
                    </script>';

        return $content;
    }

    private function Validate() {
        $content = '<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.validate.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.uniform.min.js") . '></script>';
        $content .='<script>
                            $(".ui-datepicker-month, .style, .dataTables_length select").uniform({ radioClass: "choice" });
                            $("#usualValidate").validate({
                                rules: {
                                        firstname: "required",
                                        minChars: {
                                                required: true,
                                                minlength: 3
                                        },
                                        maxChars: {
                                                required: true,
                                                maxlength: 6
                                        },
                                        mini: {
                                                required: true,
                                                min: 3
                                        },
                                        maxi: {
                                                required: true,
                                                max: 6
                                        },
                                        range: {
                                                required: true,
                                                range: [6, 16]
                                        },
                                        emailField: {
                                                required: true,
                                                email: true
                                        },
                                        urlField: {
                                                required: true,
                                                url: true
                                        },
                                        dateField: {
                                                required: true,
                                                date: true
                                        },
                                        digitsOnly: {
                                                required: true,
                                                digits: true
                                        },
                                        enterPass: {
                                                required: true,
                                                minlength: 5
                                        },
                                        repeatPass: {
                                                required: true,
                                                minlength: 5,
                                                equalTo: "#enterPass"
                                        },
                                        customMessage: "required",
                                        topic: {
                                                required: "#newsletter:checked",
                                                minlength: 2
                                        },
                                        agree: "required"
                                },
                                messages: {
                                        customMessage: {
                                                required: "Bazinga! This message is editable",
                                        },
                                        agree: "Please accept our policy"
                                },
                            highlight: function(label) {
                                $(label).closest(".control-group").addClass("error");
                            },
                            success: function(label) {
                                label
                                        .text("Success!").addClass("valid")
                                        .closest(".control-group").addClass("success");
                            }
                        });
                    </script>';

        return $content;
    }

}
