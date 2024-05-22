<div class="content-body" style="min-height: 0px !important;">
    <div class="container-fluid">
        <style>
            .nav-header {
                height: 4.5rem;
            }

            b,
            strong {
                font-weight: 400;
                font-family: 'poppins', sans-serif;
            }

            p math {
                font-size: 14px;
                font-weight: 100;
                font-family: 'poppins', sans-serif;
            }

            span p {
                display: -webkit-inline-box;
            }



            p {
                display: -webkit-box;
            }

            .fa-2x {
                font-size: 1.1em;
            }

            .me-2 {
                margin-right: 0.1rem !important;
            }

            .drag-source,
            .drag-target {
                cursor: move;
            }


            .remove-btn {
                cursor: pointer;
                color: red;
                font-weight: bold;
            }

            .paika-fixed- {
                position: fixed;
                width: 100%;
                z-index: 9999;
                padding: 0.5rem;
                background: #fff;
                box-shadow: 0 1px 0 0 #d1dae6, 0 0 1px 0 rgba(133, 149, 166, .4), 0 4px 8px -2px rgba(173, 189, 203, .4);
                /* border: 1px solid #d1dae6;*/
                top: 60px;
            }

            .paika-fixed-left {
                position: fixed;
                width: 100%;
                z-index: 9999;
                top: 60px;
            }




            .header {
                height: 4.5rem;
            }

            .dlabnav {
                width: 20.5rem;
                padding-bottom: 0;
                height: calc(100% - 7.5rem);
                position: absolute;
                top: 4.5rem;
            }

            .btn {
                padding: 7px 1.1rem;
            }

            .card-body {
                padding: 0.6rem;
            }

            .circle::before {
                content: " ";
                position: absolute;
                display: block;
                background-color: #01ca85;
                width: 5px;
                left: 48%;
                top: 25px;
                bottom: 25px;
                z-index: 0;
            }

            .circle::after {
                content: " ";
                position: absolute;
                display: block;
                background-color: #01ca85;
                height: 5px;
                top: 48%;
                left: 25px;
                right: 25px;
                z-index: 0;
            }

            .circle {
                border-radius: 50%;
                height: 84px;
                width: 84px;
                background-color: rgba(1, 202, 133, .1);
                position: relative;
            }

            .item {

                font-weight: 600;
                font-size: 13px;
            }

            input {
                width: 35px;
                border: 0;
                color: #3a5077;
                font-size: 15px;
                font-weight: 600;
                line-height: 20px;
                border-bottom: 2px solid;
            }

            .time-minutes {
                right: 5px;
                top: 3px;
            }

            .paika-round {
                padding: 4px;
                border: 1px solid #e81919;
                border-radius: 40%;
            }

            .question-controls {
                display: none;
            }

            .paika-card {
                height: 550px;
                overflow-x: auto;
                padding-bottom: 0px;
            }

            .paika-card-modal {
                height: 600px;
                overflow-x: auto;
                padding-bottom: 0px;
            }


            [data-header-position="fixed"] .content-body {
                padding-top: 3.5rem;
            }

            .card {
                margin-bottom: 0.4rem;
            }
        </style>
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body paika-fixed">
                        <form id="myQuestion">
                            <input type="hidden" name="empId" id="empId" value="<?= $this->session->userdata('id') ?>" />

                            <input type="hidden" name="pepar_id" id="pepar_id" value="<?= base64_decode($_GET['pepar_id']) ?>" />

                            <div class="row">
                                <div class="col-xl-2 col-lg-2">
                                    <div class="form-group">
                                        <select class="form-control form-control-use" name="question_type" id="question_type">
                                            <?php foreach ($getquestion_type as $val) { ?>
                                                <option value="<?= $val->check_question_id ?>"><?= $val->question_type_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-xl-2 col-lg-2">
                                    <div class="form-group">
                                        <select class="form-control form-control-use" name="capter_id" id="capter_id" multiple- ><!---capter_id[]--->
                                            <?php
                                            $created_by = $this->session->userdata('id');
                                            $pepar_id =  base64_decode($_GET['pepar_id']);
                                            $getTeacherPepar = countChapterQuestion($getTeacher->class_id, $getTeacher->subject_id, $getTeacher->board_id);
                                            foreach ($getTeacherPepar as $val) {
                                                $isChecked = capter_question_exists($val->id, $pepar_id, $created_by) ? 'checked' : ''; ?>
                                                <option value="<?= $val->id ?>"><?= $val->chapter_name ?></option>




                                                <!--<li class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" id="capter_id" name="capter_id[]" value="<?= $val->id ?>" <?= $isChecked ?>>
                                      <label class="form-check-label" for="inlineCheckbox1"><?= $val->chapter_name ?> (<?php questioncount($val->id) ?>)</label>
                                      
                                    </li>-->



                                            <?php }  ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-lg-2">
                                    <div class="form-group">
                                        <input class="form-control form-control-use" placeholder="Enter Question Name" type="text" id="question_name_search" name="question_name_search">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <input type="button" style="padding: 13px 1.1rem" class="btn btn-info btn-block" name="save" id="save" value="Search" onclick="callForForm()">
                                </div>

                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label id="totalMarks" class="col-form-label btn btn-default btn-block" style="border: 1px solid;">Total Marks: 0</label>

                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-form-label btn btn-default btn-block" style="border: 1px solid;">Time: <input name="paperTime" class="form-control-use" value="" id="paperTime"> <span class="text-primary">Edit</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <script src="<?= base_url() ?>assets/jquery-3.2.1.min.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
            <script src="https://code.jquery.com/jquery-git.js"></script>
            
            <style>
                .question_parent #sortable1,
                .question_parent #sortable2 {
                    width: 100%;
                    min-height: 20px;
                    list-style-type: none;
                    margin: 0;
                    padding: 5px 0 0 0;
                    float: left;
                    margin-right: 10px;
                }

                .question_parent #sortable1>li,
                .question_parent #sortable2>li {
                    margin: 0 5px 0px 5px;
                    font-size: 1.2em;
                    width: 100%;
                    position: relative;
                    box-sizing: border-box;
                    /* background: #eee; */
                    padding: 20px;
                }


                .question_parent #sortable2 li li .actionTab {
                    display: none;
                }

                .question_parent .removeActiveMerge li.list-group-item {
                    margin-top: 20px;
                }

                .question_parent .inserted-list {
                    display: flex;
                    list-style-type: disc;
                    padding: 0;
                    margin: 0 0 0 6px;
                    text-align: center;
                }

                .question_parent .inserted-list li {
                    list-style-type: disc;
                    padding: 0 6px;
                    margin: 0 10px;
                    font-size: 14px;
                    font-weight: bold;
                }

                .question_parent .actionTab {
                    /* margin-left: auto; */
                    margin-top: -14px;
                }

                .question_parent .question_wrapper .btn {
                    margin-left: 10px;
                    color: #555 !important;
                    font-size: 20px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 28px;
                    width: 28px;
                    border: 1px solid #3a5077;
                    border-radius: 2px;
                    background-color: #fff;
                    padding: 4px 6px;
                    font-weight: bold;
                }

                .question_parent .setActive .itemMerge {
                    background-color: #555 !important;
                    color: #fff !important;
                    /* display: none; */
                }

                .question_parent .hideActive li .itemMerge,
                .question_parent .removeActiveMerge .itemMerge,
                .question_parent .setActive li .itemMerge,
                .question_parent .list-group .list-group-item .list-group-item .itemMerge,
                .question_parent #sortable1 .itemMerge {
                    display: none;
                }

                .question_parent .hideActive .setActive .itemMerge {
                    display: flex;
                }

                .question_parent .question_wrapper.closeMerge {
                    min-height: 100px;
                    margin-top: 20px;
                    background: #f1f5ff;
                    padding: 6px 15px;
                    position: relative;
                }

                .question_parent .q_head {
                    color: #172b4d;
                    font-size: 15px;
                    font-weight: 600;
                    margin-bottom: 16px;
                }

                .question_parent .marks {
                    margin-left: auto;
                    margin-top: -14px;
                    color: #555;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 28px;
                    border: 1px solid #3a5077;
                    border-radius: 2px;
                    background-color: #fff;
                    padding: 4px 6px 4px 6px;
                    font-weight: normal;
                    font-size: 13px;
                    visibility: hidden;
                }

                .question_parent .marks input {
                    margin-right: 4px;
                    padding: 0;
                    outline: 0;
                    width: 28px;
                    text-align: center;
                    border: 0px;
                }

                .question_parent #sortable2 .marks {
                    visibility: visible;
                }

                .question_parent #sortable2 li li .marks {
                    visibility: hidden;
                }

                .question_parent #sortable2 li li .marks,
                .question_parent #sortable2 li li .actionTab {
                    margin-top: 0;
                }

                .question_parent p {
                    font-size: 14px;
                    color: #3a5077;
                }
            </style>



            <div class="row question_parent">
                <div class="col-xl-6">
                    <div class="card paika-card">
                        <div class="card-header">
                            <h4 class="card-title-">Suggested Questions </h4>
                        </div>
                        <div class="card-body">
                            <div class="row ">

                                <input type="hidden" name="total_count" id="total_count" value="" />

                                <?php $i = 1; ?>
                                <div class="col-xl-12">
                                    <span class="box" id="box1">
                                        <ul id="sortable1" class="list-group connectedSortable records-container">
                                        </ul>
                                    </span>
                                    <button id="load-more" class="btn btn-default" style="border: 1px solid;color: #d653c1;">Load More Question</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $pepar_id =  base64_decode($_GET['pepar_id']); ?>
                <div class="col-xl-6">
                    <div class="card paika-card">
                        <div class="card-header">
                            <h4 class="card-title" style="font-size: 15px;">Added Question</h4> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <h4>
                                <a class="btn btn-default nav-link bell-link " href="javascript:void(0);" onclick="formquestion(<?= $pepar_id ?>)" style="border: 1px solid;color: #d653c1;">Add Your Question</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php //print_r($draftTeacherPepar); 
                                ?>
                                <form>
                                    <div class="drag-target">
                                        <div class="drop_question" style="background:#d1dae659;padding:5px">
                                            <div class="cursor-pointer circle mx-auto mt-3"></div>
                                            <p class="text-center">Click Question here</p>
                                        </div>
                                        <!-- <div class="box" id="box2"></div> -->
                                        <ul id="sortable2" class="list-group connectedSortable">

                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                let activeParent;

                // Set the active parent when Merge button is clicked
                function setActiveParent(button) {
                    $('.setActive').removeClass('setActive');
                    activeParent = $(button).closest("li").addClass('setActive').addClass('setMerge');
                    $(button).closest("#sortable2").addClass('hideActive');
                    $(button).closest("li").find(".closeMerge").detach();
                    $(button).closest("li").append('<div class="question_wrapper closeMerge"><div class="q_head d-flex align-items-center"><label class="d-block">Question</label> <span class="add-button btn btn-primary bi bi-x ms-auto" onclick="closeMerge(this)"></span></div><p>You can add the alternate question by Simply click the Add Button</div>');
                }

                function closeMerge(button) {
                    activeParent = null;
                    $(button).closest("#sortable2").removeClass('hideActive');
                    $(button).closest("li.setActive").removeClass('setActive').removeClass('setMerge');
                    $(button).closest("li").find(".closeMerge").detach();
                }

                /*  function createMergeButton() {
                     return $('<div class="actionTab d-flex"><a class="itemMerge btn btn-sm btn-primary bi bi-sign-merge-right" onclick="setActiveParent(this)"></a></div>');
                 } */

                $("#sortable1 > li").each(function() {
                    $(this).find('.q_head').append(createMergeButton()); // Add Merge button initially
                    $(this).find('.q_head .actionTab').append('<span class="add-button btn btn-primary bi bi-plus" onclick="moveItem(this)"></span>');

                });

                $("#sortable2 > li").each(function() {
                    $(this).find('.q_head').append(createMergeButton()); // Add Merge button initially
                    $(this).find('.q_head .actionTab').append('<span class="add-button btn btn-primary bi bi-x" onclick="moveItem(this)"></span>');

                });
                            
                function checkQuesCount() {
                   
                    var question_type = $("#own_question_type").val();
                    //alert(question_type);
                    if (question_type == '') {
                        var question_type = $("#question_type").val();
                        //alert(question_type);
                    }
                    if (question_type == 5) {
                        mcq = mcq + 1;
                    }
                    if (question_type == 4) {
                        csq = csq + 1;
                    }
                    if (question_type == 3) {
                        lq = lq + 1;
                    }
                    if (question_type == 2) {
                        sq = sq + 1;
                    }
                    if (question_type == 1) {
                        vsq = vsq + 1;
                    }
                    console.log("question_type1", question_type,"mcq ", mcq, "csq ", csq,"lq ", lq,"sq ", sq,"vsq ", vsq);
                     

                }

                function checkQuesCountMinus() {
                    var question_type = $("#own_question_type").val();
                    if (question_type == '') {
                        var question_type = $("#question_type").val();
                        //alert(question_type);
                    }
                    console.log("question_type2", question_type);
                    if (question_type == 5) {
                        mcq = mcq - 1;
                    }

                    if (question_type == 4) {
                        csq = csq - 1;
                    }
                    if (question_type == 3) {
                        lq = lq - 1;
                    }
                    if (question_type == 2) {
                        sq = sq - 1;
                    }
                    if (question_type == 1) {
                        vsq = vsq - 1;
                    }
                    console.log("mcq ", mcq);
                    console.log("csq ", csq);
                    console.log("lq ", lq);
                    console.log("sq ", sq);
                    console.log("vsq ", vsq);

                }
                var mcq = 0;
                var csq = 0;
                var lq = 0;
                var sq = 0;
                var vsq = 0;

                function moveItem(button) {
                   

                    let li = $(button).closest('li');
                    let sourceList = li.parent();
                  
                    let targetList = sourceList.attr("id") === "sortable1" ? "#sortable2" : "#sortable1";
                    //console.log(targetList,"sourceListsourceList");

                    var buttonTextCheck = targetList === "#sortable2" ? "bi-x" : "bi-plus";
                    var question_type = $("#own_question_type").val();
                    if (question_type == '') {
                        var question_type = $("#question_type").val();
                    }
                  //  console.log("question_type3", question_type);
                    
                    if (buttonTextCheck == 'bi-x' && !activeParent) {
                        <?php foreach($getquestion_type as $val){?>
                            
                            if (question_type == <?= $val->check_question_id ?> && mcq == <?= $val->question_mark ?>) {
                                
                                alert("Limit Exceed! You already added <?= $val->question_mark ?> <?= $val->question_type_name ?>  questions.");
                                return false;
                            }
                            
                           <?php }?>
                        
                       // checkQuesCount();
                        
                       /*if (question_type == 5 && mcq == 12<?//= $getTeacher->mcq ?>) {
                            alert("Limit Exceed! You already added <?= $getTeacher->mcq ?> MCQ questions.");
                            return false;
                        }
                        if (question_type == 4 && csq == 4<?//= $getTeacher->case_study ?>) {
                            alert("Limit Exceed! You already added <?= $getTeacher->case_study ?> Case Study questions.");
                            return false;
                        }
                        if (question_type == 3 && lq == 3<?//= $getTeacher->long_question ?>) {
                            alert("Limit Exceed! You already added <?= $getTeacher->long_question ?> Long questions.");
                            return false;
                        }
                        if (question_type == 2 && sq == 2<?//= $getTeacher->shot_question ?>) {
                            alert("Limit Exceed! You already added <?= $getTeacher->shot_question ?> Short questions.");
                            return false;
                        }
                        if (question_type == 1 && vsq == 1<?//= $getTeacher->vshot_question ?>) {
                            alert("Limit Exceed! You already added <?= $getTeacher->vshot_question ?> Very Short questions.");
                            return false;
                        }*/
                        
                       
                    }
                    
                    
                    
                    
                    

                    let isRemoveButton = $(button).closest('.setMerge').length > 0 && $(button).hasClass("bi-x");

                    let childClicked = $(button).closest('#sortable2 > li > li .add-button').length;
                    // console.log("childClicked",childClicked);
                    if (buttonTextCheck == 'bi-plus' && childClicked == 0) {
                        checkQuesCountMinus();
                    }
                    if (isRemoveButton) {
                        $(button).closest("#sortable2").removeClass('hideActive');
                        $(button).closest("#sortable2 > li").removeClass('setActive').removeClass('setMerge').removeClass('removeActiveMerge')
                        let detachedItems = li.find(".list-group-item").detach();
                        $(targetList).append(detachedItems);
                        activeParent = null;
                    }

                    if (activeParent && targetList === "#sortable2") {
                        activeParent.append(li);
                        activeParent.find(".closeMerge").detach();
                        activeParent = null;
                        $(button).closest(".setActive").addClass('removeActiveMerge');
                        $(button).closest("#sortable2").removeClass('hideActive');

                    } else {

                        activeParent = null;
                        $(targetList).append(li);
                    }

                    let buttonText = targetList === "#sortable2" ? "bi-x" : "bi-plus";

                    li.find(".add-button").removeClass("bi-x").removeClass("bi-plus").addClass(buttonText);

                    buttonText = targetList === "#sortable1" ? "bi-plus" : "bi-x";
                    li.find(".add-button").removeClass("bi-x").addClass(buttonText);

                    $("#sortable1").children('li').each(function() {
                        $(this).find('.bi-x').removeClass("bi-x").addClass('bi-plus');
                    });

                    // console.log("targetList", targetList, buttonText)

                    let questionCounter = 0;
                    sourceList.children('li').each(function() {
                        $(this).find('.question-number').text(++questionCounter);
                    });

                    questionCounter = 0;
                    $(targetList).children('li').each(function() {
                        $(this).find('.question-number').text(++questionCounter);
                    });
                    enableDisableSaveButton();
                }

               
   
               
                $("#add-list").on("click", function() {
                    // Append the specified code to sortable2
                    let newItem = '<li class="list-group-item c">' +
                        '<div class="question_wrapper">' +
                        '<div class="q_head d-flex align-items-center">' +
                        '<label class="d-block">Question <span class="question-number">2</span></label>' +
                        '<div class="marks"><input type="text" value="14">Marks</div>' +
                        '<div class="actionTab d-flex">' +
                        '<a class="itemMerge btn btn-sm btn-primary bi bi-sign-merge-right" onclick="setActiveParent(this)"></a>' +
                        '<span class="add-button btn btn-primary bi bi-x" onclick="moveItem(this)"></span>' +
                        '</div>' +
                        '</div>' +
                        '<p>Describe the alimentary canal of man.</p>' +
                        '<ul class="inserted-list">' +
                        '<li>First item</li>' +
                        '<li>Second item</li>' +
                        '<li>Third item</li>' +
                        '<li>Fourth item</li>' +
                        '</ul>' +
                        '</div>' +
                        '</li>';
                    $("#sortable2").append(newItem);
                    let questionCounter = 1;
                    $("#sortable2").children('li').each(function() {
                        $(this).find('.question-number').text(questionCounter++);
                    });
                });

             


                function updateQuestionNumbers() {
                    $(".box").each(function() {
                        var questions = $(this).find('.draggable');
                        questions.each(function(index) {
                            // $(this).attr('data-index', index + 1);
                            $(this).find('strong').text('Question ' + (index + 1) + ':');
                        });
                    });
                }

                function updateQuestionNumbers() {
                    $("#sortable2").each(function() {
                        var questions = $(this).find('.draggable');
                        questions.each(function(index) {
                            $(this).attr('data-index', index + 1);
                            $(this).find('.question-number').text(index + 1);
                            // $(this).find('strong').text('Question ' + (index + 1) + ':');
                        });
                    });
                }

                function updateTotalMarks() {
                    var totalMarks = 0;
                    $("#sortable2 .marks-input").each(function() {
                        var marks = parseInt($(this).val()) || 0;
                        totalMarks += marks;
                    });

                    // Display the total marks above the second box
                    $("#totalMarks").text("Total Marks: " + totalMarks);
                }

                function enableDisableSaveButton() {
                    var $box2Questions = $("#sortable2 .draggable");

                    if ($box2Questions.length > 0) {
                        $('#saveInstrtaction').prop('disabled', false);
                        $('#saveQuestionsBtn').prop('disabled', false);
                        $('#fsaveQuestionsBtn').prop('disabled', false);
                        $('#psaveQuestionsBtn').prop('disabled', false);
                    } else {
                        $('#saveInstrtaction').prop('disabled', true);
                        $('#saveQuestionsBtn').prop('disabled', true);
                        $('#fsaveQuestionsBtn').prop('disabled', true);
                        $('#psaveQuestionsBtn').prop('disabled', true);
                    }
                }
            </script>

            <div class="col-xl-12">
                <div class="card-footer- d-flex justify-content-between align-items-center flex-wrap ">
                    <div class="mb-2"></div>
                    <div class="mb-2" style="display: flex;justify-content: space-between;align-items: center;flex-wrap: wrap;padding: 10px 2.1rem;">
                     

                    <button id="psaveQuestionsBtn" onclick="previewquestion(<?= $pepar_id ?>)" class="btn btn-warning btn-lg " style="padding: 10px 2.1rem;margin: 5px;"><i class="far fa-check-circle me-2"></i> Preview </button>

                        <button id="saveQuestionsBtn" disabled onclick="saveQuestions(0)" class="btn btn-success btn-lg " style="padding: 13px 2.1rem;margin: 5px;"><i class="far fa-check-circle me-2"></i> Save </button>
                        <button id="fsaveQuestionsBtn" disabled onclick="saveQuestions(1)" class="btn btn-success btn-lg " style="padding: 13px 2.1rem;margin: 5px;"><i class="far fa-check-circle me-2"></i> Final Save </button>
                        <a href="javascript:void(0);" class="btn btn-info btn-lg" style="padding: 13px 2.1rem;margin: 5px;" onclick="getInstruction(<?= $pepar_id ?>)"><i class="far fa-check-circle me-2"></i>Next Process</a>
                    </div>
                </div>

            </div>

        </div>
  
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dragSources = document.querySelectorAll('.drag-source');
                const dragTarget = document.querySelector('.drag-target');

                let draggedItemIndex = -1;
                let draggedItem = null;
                let clickedItemIndex = -1;

                function handleDragStart(e) {
                    draggedItemIndex = Array.from(dragSources).indexOf(e.target);
                    draggedItem = e.target;
                    e.dataTransfer.effectAllowed = 'move';
                }

                function handleDragOver(e) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                }

                function handleDragEnter(e) {
                    e.target.classList.add('over');
                }

                function handleDragLeave(e) {
                    e.target.classList.remove('over');
                }

                function handleDrop(e) {
                    e.stopPropagation();

                    function cloneAndAppend(item, index) {
                        const clonedItem = dragSources[index].cloneNode(true);
                        addRemoveButton(clonedItem);
                        e.target.appendChild(clonedItem);
                    }

                    if (clickedItemIndex < dragSources.length) {
                        cloneAndAppend(dragSources[clickedItemIndex], clickedItemIndex);
                        clickedItemIndex++;
                    }

                    if (draggedItemIndex < dragSources.length) {
                        cloneAndAppend(dragSources[draggedItemIndex], draggedItemIndex);
                        draggedItemIndex++;
                    }

                    draggedItem.style.display = 'none';
                    e.target.classList.remove('over');
                }

                function handleDragEnd() {
                    draggedItemIndex = -1;
                }

                function addRemoveButton(item) {
                    const removeBtn = document.createElement('span');
                    removeBtn.className = 'remove-btn';
                    removeBtn.textContent = 'Remove';

                    removeBtn.addEventListener('click', function() {
                        item.remove();
                    });

                    item.appendChild(removeBtn);
                }

                dragSources.forEach(function(source, index) {
                    source.addEventListener('dragstart', handleDragStart);
                    source.addEventListener('click', function() {
                        clickedItemIndex = index;
                        const clickedItem = source.cloneNode(true);
                        addRemoveButton(clickedItem);
                        dragTarget.appendChild(clickedItem);
                        source.style.display = 'none';
                    });
                });


                dragTarget.addEventListener('dragenter', handleDragEnter);
                dragTarget.addEventListener('dragover', handleDragOver);
                dragTarget.addEventListener('dragleave', handleDragLeave);
                dragTarget.addEventListener('drop', handleDrop);
                dragTarget.addEventListener('dragend', handleDragEnd);


            });



            function callForForm() {
                //alert();
                $("#myTable").html("");
                // var response = '';
                $('.records-container').html('');
                // var filter = true;
                loadRecords(true);
            }



            var offset = 0; // Initial offset value

            // Function to load records
            function loadRecords(filter = false) {
                // console.log(filter);
                // console.log(offset);
                var data = $("#myQuestion").serialize();
                if (filter) {
                    offset = 0;
                }
               //  console.log("data",data+"&offset="+offset+"&type_id="+'<?php echo $_GET['type_id']; ?>');

                data = data + "&offset=" + offset + "&type_id=" + '<?php echo $_GET['type_id']; ?>';

                // console.log("data------",data);

                $.ajax({

                    url: '<?= base_url() ?>teacher_question/fatchAllRecord',
                    method: 'GET',
                    data: data,
                    success: function(responseData) {
                        $('.records-container').append(responseData);
                        
                        updateQuestionNumbers();

                        function updateQuestionNumbers() {
                            $("#sortable1").each(function() {
                                var questions = $(this).find('.draggable');
                                questions.each(function(index) {
                                    $(this).attr('data-index', index + 1);
                                    $(this).find('.question-number').text(index + 1);
                                    // $(this).find('strong').text('Question ' + (index + 1) + ':');
                                });
                            });
                        }
                        enableDisableSaveButton();

                       
                        offset = offset + 20; // Increase offset for the next batch
                        // console.log("offset",offset);

                        var data = $("#myQuestion").serialize();
                        $.ajax({
                            url: '<?= base_url() ?>teacher_question/countAllRecord',
                            type: "get",
                            data: data,
                            beforeSend: function() {
                                $('.ajax-loader').show();
                            },
                            success: function(data) {
                                var totalRecord = data;


                                $(".card-title-").html("Suggested Questions: " + data);
                                $("#total_count").val(data);
                                // console.log("offset>totalRecord----",offset," > ",totalRecord);
                                document.getElementById("load-more").style.display = "block";

                                if (offset > totalRecord) {
                                    // console.log("ohh no");
                                    document.getElementById("load-more").style.display = "none";
                                }
                            }
                        });


                    }
                });
            }

            // Initial load
            callForForm(true);

            // Load more button click event
            $('#load-more').on('click', function() {
                loadRecords(false);
            });

            $("#sortable2").on('keyup', '.marks-input', function() {
                updateTotalMarks();
            })

            //save own question created by teacher
            function saveOwnQuestionRecords() {
                var formElement = document.getElementById("myformOwnQues");

                // Access the values of input fields using their names or IDs
                var questionTypeValue = formElement.elements.own_question_type.value;
                // formElement.elements.own_question_type.value = '';
                var currectAnsValue = formElement.elements.currect_ans.value;
                var currectAns2Value = formElement.elements.currect_ans2.value;

                var questionNameValue = tinymce.get('neweditor1').getContent();
                var answer1Value = tinymce.get('neweditor2').getContent();
                var answer2Value = tinymce.get('neweditor3').getContent();
                var answer3Value = tinymce.get('neweditor4').getContent();
                var answer4Value = tinymce.get('neweditor5').getContent();
                var descriptionAnswerValue = tinymce.get('neweditor6').getContent();
               
                var pepardIdValue = formElement.elements.pepar_id.value;
                var typeIdValue = formElement.elements.type_id.value;

                // Use the values as needed in your JavaScript logic or send them to the server

                // For demonstration purposes, display the values in the console
                var formData = {
                    question_type: questionTypeValue,
                    currect_ans: currectAnsValue,
                    currect_ans2: currectAns2Value,
                    question_name: questionNameValue,
                    answer1: answer1Value,
                    answer2: answer2Value,
                    answer3: answer3Value,
                    answer4: answer4Value,
                    description_answer: descriptionAnswerValue,
                    pepar_id: pepardIdValue,
                    type_id: typeIdValue
                };
                // console.log("formData",formData);


                $.ajax({

                    url: '<?= base_url() ?>teacher_question/save_own_question',
                    method: 'POST',
                    data: formData,
                    success: function(responseData) {
                        
                        // console.log("responseData",responseData);  
                        $("#sortable2").append(responseData);
                        let questionCounter = 1;
                        $("#sortable2").children('li').each(function() {
                            $(this).find('.question-number').text(questionCounter++);
                        });
                       // checkQuesCount();
                        // updateQuestionNumbers();

                        updateTotalMarks();

                        // $("#box2 .marks-input").on('keyup', function() {
                        //     updateTotalMarks();
                        // });

                        /* $("#sortable2 .marks-input").off('keyup').on('keyup', function() {
                            updateTotalMarks();
                        }); */
                        enableDisableSaveButton();
                        // Clear the form fields
                        formElement.reset();
                        // Reset CKEditor instances
                        tinymce.get('neweditor1').setContent('');
                        tinymce.get('neweditor2').setContent('');
                        tinymce.get('neweditor3').setContent('');
                        tinymce.get('neweditor4').setContent('');
                        tinymce.get('neweditor5').setContent('');
                        tinymce.get('neweditor6').setContent('');
                        if(responseData==''){
                            console.log("empty");
                            $('#saveQuestionsBtn').css('display', 'block');
                            $('#psaveQuestionsBtn').css('display', 'none');
                            $('#fsaveQuestionsBtn').css('display', 'none');
                        }else{
                            console.log("data exist");
                            $('#saveQuestionsBtn').css('display', 'none');
                            $('#psaveQuestionsBtn').css('display', 'block');
                            $('#fsaveQuestionsBtn').css('display', 'block');
                             
                        }
                        alert("Question Add Successfully");
                        $("#question_modal").modal('hide');


                    }
                });
            }

            checkDraftQuestion();
            function checkDraftQuestion() { 
                var data = {"pepar_id":<?= $pepar_id ?>};
                
                $.ajax({
                    url: '<?= base_url() ?>teacher_question/get_draft_question',
                    method: 'POST',
                    data: data,
                    success: function(responseData) {
                        
                        //  console.log("responseData",responseData);
                        $("#sortable2").append(responseData);
                        let questionCounter = 1;
                        $("#sortable2").children('li').each(function() {
                            $(this).find('.question-number').text(questionCounter++);
                        });
                      //  checkQuesCount();
                        // updateQuestionNumbers();

                        updateTotalMarks();
 
                        enableDisableSaveButton();
                        if(responseData==''){
                            console.log("empty");
                            $('#saveQuestionsBtn').css('display', 'block');
                            $('#psaveQuestionsBtn').css('display', 'none');
                            $('#fsaveQuestionsBtn').css('display', 'none');
                        }else{
                            console.log("data exist");
                            $('#saveQuestionsBtn').css('display', 'none');
                            $('#psaveQuestionsBtn').css('display', 'block');
                            $('#fsaveQuestionsBtn').css('display', 'block');
                             
                        }
                    }
                });
            }
        </script>



    </div>


    <!--------------------------------------Instruction Show-------------------------------------------->

    <script>
        // Function to save questions to the server
        function saveInstruction() {
            saveQuestions(1,"skip");
            redirectUrl = '<?= base_url() ?>teacher_generate_paper?pepar_id=<?= $_GET['pepar_id'] ?>';
            window.location.href = redirectUrl;
        }

        function saveQuestions(DraftStatus,previewStatus='') {
            var $box2Questions = $("#sortable2 .draggable");

            // Check if there are questions in the second box
            if ($box2Questions.length === 0) {
                //alert('No questions to save.');
                return;
            }
            var questionsData = [];


            const listItems = document.querySelectorAll('#sortable2 .list-group-item');

            let resultArray = [];
            let insertedQuestionIds = [];
            var totalMarks = 0;
            for (let i = 0; i < listItems.length; i++) {
                const listItem = listItems[i];
                const questionId = listItem.querySelector('[name="question_id"]').value;

                // Skip if the question id has already been inserted
                if (insertedQuestionIds.includes(questionId)) {
                    continue;
                }

                const marks = listItem.querySelector('[name="qmark"]').value;
                const selfQues = (listItem.querySelector('[name="selfQues"]').value) ? listItem.querySelector('[name="selfQues"]').value : '';
                // console.log("selfQues",selfQues);
                totalMarks += parseInt(marks) || 0;

                // Check if there is a nested list item (complementary question)
                const nestedListItem = listItem.querySelector('.list-group-item');

                if (nestedListItem) {
                    const complementaryQuestionId = nestedListItem.querySelector('[name="question_id"]').value;
                    const nestedSelfQues = (nestedListItem.querySelector('[name="selfQues"]').value) ? nestedListItem.querySelector('[name="selfQues"]').value : '';
                    // console.log("nestedSelfQues",nestedSelfQues);
                    // const complementarySelfQues = nestedListItem.querySelector('[name="selfQues"]').value;
                    // console.log("complementarySelfQues",complementarySelfQues);

                    // Skip if the complementary question id has already been inserted
                    if (insertedQuestionIds.includes(complementaryQuestionId)) {
                        continue;
                    }

                    const isComplementary = {
                        questionId: complementaryQuestionId,
                        marks: "",
                        selfQues: nestedSelfQues,
                        isComplementary: null,
                    };

                    resultArray.push({
                        questionId,
                        marks,
                        selfQues,
                        isComplementary,
                    });

                    insertedQuestionIds.push(questionId, complementaryQuestionId);
                } else {
                    // No nested list item
                    const processedQuestion = {
                        questionId,
                        marks,
                        selfQues,
                        isComplementary: null,
                    };

                    resultArray.push(processedQuestion);
                    insertedQuestionIds.push(questionId);
                }
            }
            var questionList = JSON.stringify(resultArray);
            var questionTypes = {
                "mcq": mcq,
                "csq": csq,
                "lq": lq,
                "sq": sq,
                "vsq": vsq
            };
            const paperTime = $("#paperTime").val();
            if (DraftStatus == 0) {
                var payLoad = {
                    type_id: '<?php echo $_GET['type_id']; ?>',
                    pepar_id: '<?php echo $_GET['pepar_id']; ?>',
                    questions: questionList,
                    totalMarks: totalMarks,
                    paperTime: paperTime,
                    finalSaveStatus: 0,
                    saveAsDraft: 1,
                    questionTypesRecord: JSON.stringify(questionTypes)
                };
            } else {
                var payLoad = {
                    type_id: '<?php echo $_GET['type_id']; ?>',
                    pepar_id: '<?php echo $_GET['pepar_id']; ?>',
                    questions: questionList,
                    totalMarks: totalMarks,
                    paperTime: paperTime,
                    finalSaveStatus: 1,
                    saveAsDraft: 0,
                    questionTypesRecord: JSON.stringify(questionTypes)
                }
            }
            // Send the questionsData array to the server using AJAX
            $.ajax({
                url: '<?= base_url() ?>teacher_question/save_question_list', // Adjust the URL to your server-side script
                type: 'POST',
                data: payLoad,
                success: function(response) {
                    if (DraftStatus == 0) {
                        if(previewStatus==''){
                        alert('Paper saved successfully!');
                        }
                        console.log("data exist");
                        $('#saveQuestionsBtn').css('display', 'none');
                        $('#psaveQuestionsBtn').css('display', 'block');
                        $('#fsaveQuestionsBtn').css('display', 'block');
                    } else {
                        if(previewStatus!='skip'){
                            alert('Paper Created successfully!');
                        }
                        
                        var redirectUrl = '<?= base_url() ?>teacher_generate_paper?pepar_id=' + '<?= $_GET['pepar_id'] ?>';

                        window.location.href = redirectUrl;

                    }

                    // var redirectUrl = '<?= base_url() ?>teacher_generate_paper?pepar_id='+'<?= $_GET['pepar_id'] ?>';

                    // window.location.href = redirectUrl;

                    // You can add further logic or redirection if needed
                },
                error: function(error) {
                    console.error('Error saving questions:', error);
                    alert('Error saving questions. Please try again.');
                }
            });
        }

        function getInstruction(id) {
            $("#instruction_modal").modal('show');
            $("#peparid").val(id);
            $("#edit_instruct").hide();
            get_all_instruction();
        }

        function get_all_instruction() {
            //alert();
            var peparId = $("#peparid").val();
            $.ajax({
                url: '<?= base_url() ?>teacher_instruction/get_all_instruction',
                type: 'GET',
                data: {
                    pepar_id: peparId
                },
                success: function(data) {
                    $("#get_all_instruction").html(data);
                }
            });
        }


        function delete_instruction(id) {
            //alert();          
            $.ajax({
                url: '<?= base_url() ?>teacher_instruction/delete_instruction',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    get_all_instruction();
                }
            });
        }




        function save_instruction() {
            var instruction_name = $("#instruction_name").val();

            if (instruction_name === '') {
                $("#error_Instruction").text("Please fill instruction name");
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>teacher_instruction/ajax_add',
                    data: {
                        instruction_name: instruction_name,
                        pepar_id: $("#pepar_id").val(),
                    },
                    success: function(return_data) {
                        $('#form')[0].reset();
                        get_all_instruction();
                    }
                });
            }
        }


        function edit_instruction(id) {
            $("#edit_instruct").show();
            $("#save_instruct").hide();
            $.ajax({
                url: '<?= base_url() ?>teacher_instruction/edit_instruction/' + id,
                type: 'GET',
                dataType: "JSON",
                success: function(data) {
                    $('[name="id"]').val(data.id);
                    $('[name="instruction_name"]').val(data.instruction_name);
                    $('#instruction_modal').modal('show'); // show bootstrap modal when complete loaded

                }
            });


        }


        function edit_instruction_form() {
            var instruction_name = $("#instruction_name").val();

            if (instruction_name === '') {
                $("#error_Instruction").text("Please fill instruction name");
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>teacher_instruction/ajax_update',
                    data: {
                        instruction_name: instruction_name,
                        id: $("#id").val()
                    },
                    success: function(return_data) {
                        $("#edit_instruct").hide();
                        $("#save_instruct").show();
                        $('#form')[0].reset();
                        get_all_instruction();

                    }
                });
            }
        }
    </script>

    <div class="modal fade bd-example-modal-lg" id="instruction_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 686px;margin: 0rem auto;position: relative;left: 29%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Question Paper Instruction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="d-flex align-items-center mb-4 flex-wrap">
                            <h4 class="fs-20 font-w600  me-auto">Add Instruction</h4>
                            <div>
                                <!-- <a href="<?= base_url() ?>teacher_generate_paper?pepar_id=<?= $_GET['pepar_id'] ?>" id="saveInstrtaction" disabled class="btn btn-info btn-lg" style="padding: 10px 3.1rem;">Skip & Next</a> -->
                                <button id="saveInstrtaction" disabled onclick="saveInstruction()" class="btn btn-info btn-lg" style="padding: 10px 3.1rem;">Skip & Next</button>

                            </div>
                        </div>



                        <form class="d-flex align-items-center" id="form">
                            <input type="hidden" value="" name="id" id="id" />
                            <input type="hidden" value="" name="peparid" id="peparid" />

                            <div class="mb-2 mx-sm-3 col-md-8">
                                <label class="sr-only">Enter Instruction</label>
                                <input type="text" name="instruction_name" id="instruction_name" class="form-control" id="exampleFirstName" placeholder="">
                                <span id="error_Instruction" class="text-danger"></span>
                            </div>

                            <button type="button" class="btn btn-primary" id="save_instruct" onclick="save_instruction()" style="    padding: 13px 1.1rem;">Add Instruction</button>
                            <button type="button" class="btn btn-primary" id="edit_instruct" onclick="edit_instruction_form()" style="    padding: 13px 1.1rem;">Edit Instruction</button>
                        </form>


                    </div>
                </div>


                <div class="modal-body ">
                    <div class="col-md-12 mb-1 paika-card-modal">
                        <div class="row" id="get_all_instruction"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!--------------------------------------Question Add-------------------------------------------->

    <script>
        function formquestion(id) {
            $("#question_modal").modal('show');
            $("#peparid").val(id);
            $("#edit_instruct").hide();
            get_all_instruction();
        }

        const delay = (delayInms) => {
            return new Promise(resolve => setTimeout(resolve, delayInms));
        };

        const previewquestion = async (id) => {
             
           saveQuestions(0,"previewStatus")
           let delayres = await delay(1000);
           
           $("#previewData").html('');
            var data = {"pepar_id": id};
                
            $.ajax({
                url: '<?= base_url() ?>teacher_generate_paper/preview_question_pdf',
                method: 'POST',
                data: data,
                success: function(responseData) {
                    // console.log("responseData",responseData);
                    $("#previewData").append(responseData);
                    $("#preview_question_modal").modal('show'); 
                     
                }
            });
        }
    </script>

    <!-- preview questions -->
    <div class="modal fade bd-example-modal-lg" id="preview_question_modal" tabindex="-1" role="dialog" aria-hidden="true" >
        <div class="modal-dialog modal-lg" style="max-width: 90%;margin: 0rem auto;position: relative;" >
            <div class="modal-content" style="background-image: url(<?= base_url() ?>assets/images/watermark.png);background-attachment: fixed;pointer-events: none;">
                <div class="modal-header">
                    <h5 class="modal-title">Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="previewData"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- add question modal -->
    <div class="modal fade bd-example-modal-lg" id="question_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 686px;margin: 0rem auto;position: relative;left: 29%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Added Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myformOwnQues">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group  ">
                                    <label class="form-label">Question Type*</label>
                                    <select class="form-control form-control-use" name="own_question_type" id="own_question_type" onchange="getQuestion(this.value)">
                                        <option value="">Select Type</option>
                                        <?php
                                        foreach ($getquestiontype as $val) { ?>
                                            <option value="<?= $val->id ?>"><?= $val->question_type_name ?></option>
                                        <?php   } ?>
                                    </select>
                                    <?php echo form_error('question_type'); ?>
                                </div>
                            </div>


                            <div class="col-md-4 mb-3" id="firstand">
                                <div class="form-group">
                                    <label>Currect Answer</label>
                                    <select name="currect_ans" class="form-control">
                                        <option value="">Select </option>
                                        <?php foreach ($getcorrect_answer as $val) { ?>
                                            <option value="<?= $val->id ?>"><?= $val->correct_answer ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php echo form_error('currect_ans'); ?>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3" id="mutiques">
                                <div class="form-group">
                                    <label>Currect Answer 2</label>
                                    <select name="currect_ans2" class="form-control">
                                        <option value="">Select </option>
                                        <?php foreach ($getcorrect_answer as $val) { ?>
                                            <option value="<?= @$val->id ?>"><?= @$val->correct_answer ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>




                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>Question</label>
                                    <textarea id="editor1" name="question_name" rows="10" cols="80"> <?php echo set_value('question_name') ?></textarea>
                                    <?php echo form_error('question_name'); ?>
                                </div>
                            </div>
                        </div>



                        <div class="row" id="descid">

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Question A </label>
                                    <textarea id="editor2" name="answer1" rows="10" cols="80" style="height: 200px;"> <?php echo set_value('answer1') ?></textarea>
                                    <?php echo form_error('answer1'); ?>
                                </div>

                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Question B </label>
                                    <textarea id="editor3" name="answer2" rows="10" cols="80" style="height: 200px;"> <?php echo set_value('answer2') ?></textarea>
                                    <?php echo form_error('answer2'); ?>
                                </div>

                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Question C </label>
                                    <textarea id="editor4" name="answer3" rows="10" cols="80" style="height: 200px;"> <?php echo set_value('answer3') ?></textarea>

                                    <?php echo form_error('answer3'); ?>
                                </div>

                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label>Question D </label>
                                    <textarea id="editor5" name="answer4" rows="5" cols="40" style="height: 168px !important;"> <?php echo set_value('answer4') ?></textarea>

                                    <?php echo form_error('answer4'); ?>
                                </div>

                            </div>




                        </div>
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>Answer Description</label><!--neweditor6--->
                                    <textarea id="editor6" name="description_answer" rows="10" cols="80"> <?php echo set_value('description_answer') ?></textarea>
                                    <?php echo form_error('description_answer'); ?>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="pepar_id" id="pepar_id" value="<?= base64_decode($_GET['pepar_id']) ?>" />
                        <input type="hidden" name="type_id" id="type_id" value="<?= $_GET['type_id'] ?>" />


                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                            <button type="button" onclick="saveOwnQuestionRecords()" class="btn btn-primary">Save changes</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
   <!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/<?php adminAPI()?>/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
  });
</script>



    <script>
        function getQuestion(id) {
            if (id == 5) {
                $("#mutiques").hide();
                $("#descid").show();
                $("#firstand").show();
            } else {
                $("#descid").hide();
                $("#mutiques").hide();
                $("#firstand").hide();
            }
        }
    </script>
    
    
    