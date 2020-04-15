@extends('admin.layout.index')
@section('title','Add More Form Page')
@section('page-name','Add More Form Page')
@section('content')
                <!-- Basic Form Elements Title -->
                <!-- END Form Elements Title -->

                <!-- Basic Form Elements Content -->
                <form action="page_forms_general.html" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onsubmit="return false;">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-text-input">Text Input</label>
                        <div class="col-md-9">
                            <input type="text" id="example-text-input" name="example-text-input" class="form-control" placeholder="Text">
                            <span class="help-block">This is a help text</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-email-input">Email Input</label>
                        <div class="col-md-9">
                            <input type="email" id="example-email-input" name="example-email-input" class="form-control" placeholder="Enter Email">
                            <span class="help-block">Please enter your email</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-password-input">Password</label>
                        <div class="col-md-9">
                            <input type="password" id="example-password-input" name="example-password-input" class="form-control" placeholder="Password">
                            <span class="help-block">Please enter a complex password</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-disabled-input">Disabled Input</label>
                        <div class="col-md-9">
                            <input type="text" id="example-disabled-input" name="example-disabled-input" class="form-control" placeholder="Disabled" disabled="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-textarea-input">Textarea</label>
                        <div class="col-md-9">
                            <textarea id="example-textarea-input" name="example-textarea-input" rows="9" class="form-control" placeholder="Content.."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-select">Select</label>
                        <div class="col-md-9">
                            <select id="example-select" name="example-select" class="form-control" size="1">
                                <option value="0">Please select</option>
                                <option value="1">Option #1</option>
                                <option value="2">Option #2</option>
                                <option value="3">Option #3</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-multiple-select">Multiple select</label>
                        <div class="col-md-9">
                            <select id="example-multiple-select" name="example-multiple-select" class="form-control" size="5" multiple="">
                                <option value="1">Option #1</option>
                                <option value="2">Option #2</option>
                                <option value="3">Option #3</option>
                                <option value="4">Option #4</option>
                                <option value="5">Option #5</option>
                                <option value="6">Option #6</option>
                                <option value="7">Option #7</option>
                                <option value="8">Option #8</option>
                                <option value="9">Option #9</option>
                                <option value="10">Option #10</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Radios</label>
                        <div class="col-md-9">
                            <div class="radio">
                                <label for="example-radio1">
                                    <input type="radio" id="example-radio1" name="example-radios" value="option1"> Option 1
                                </label>
                            </div>
                            <div class="radio">
                                <label for="example-radio2">
                                    <input type="radio" id="example-radio2" name="example-radios" value="option2"> Option 2
                                </label>
                            </div>
                            <div class="radio">
                                <label for="example-radio3">
                                    <input type="radio" id="example-radio3" name="example-radios" value="option3"> Option 3
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Inline Radios</label>
                        <div class="col-md-9">
                            <label class="radio-inline" for="example-inline-radio1">
                                <input type="radio" id="example-inline-radio1" name="example-inline-radios" value="option1"> One
                            </label>
                            <label class="radio-inline" for="example-inline-radio2">
                                <input type="radio" id="example-inline-radio2" name="example-inline-radios" value="option2"> Two
                            </label>
                            <label class="radio-inline" for="example-inline-radio3">
                                <input type="radio" id="example-inline-radio3" name="example-inline-radios" value="option3"> Three
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Checkboxes</label>
                        <div class="col-md-9">
                            <div class="checkbox">
                                <label for="example-checkbox1">
                                    <input type="checkbox" id="example-checkbox1" name="example-checkbox1" value="option1"> Option 1
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="example-checkbox2">
                                    <input type="checkbox" id="example-checkbox2" name="example-checkbox2" value="option2"> Option 2
                                </label>
                            </div>
                            <div class="checkbox">
                                <label for="example-checkbox3">
                                    <input type="checkbox" id="example-checkbox3" name="example-checkbox3" value="option3"> Option 3
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Inline Checkboxes</label>
                        <div class="col-md-9">
                            <label class="checkbox-inline" for="example-inline-checkbox1">
                                <input type="checkbox" id="example-inline-checkbox1" name="example-inline-checkbox1" value="option1"> One
                            </label>
                            <label class="checkbox-inline" for="example-inline-checkbox2">
                                <input type="checkbox" id="example-inline-checkbox2" name="example-inline-checkbox2" value="option2"> Two
                            </label>
                            <label class="checkbox-inline" for="example-inline-checkbox3">
                                <input type="checkbox" id="example-inline-checkbox3" name="example-inline-checkbox3" value="option3"> Three
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-file-input">File input</label>
                        <div class="col-md-9">
                            <input type="file" id="example-file-input" name="example-file-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-file-multiple-input">Multiple File input</label>
                        <div class="col-md-9">
                            <input type="file" id="example-file-multiple-input" name="example-file-multiple-input" multiple="">
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
                            <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                        </div>
                    </div>
                </form>
                <!-- END Basic Form Elements Content -->
@endsection