
	        <!-- #modal-message -->
            <div class="modal fade" id="modal-message">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Media Manager</h4>
                        </div>
                        <div class="modal-body">
                            
                            <!-- The file upload form used as target for the file upload widget -->
                            <form id="fileupload" action="{{url('/backend/file/upload')}}" method="POST" enctype="multipart/form-data">
                                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                <div class="row fileupload-buttonbar">
                                    <div class="col-lg-7">
                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                        <span class="btnu btn btn-success fileinput-button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Upload Images...</span>
                                            <input type="file" name="files[]" multiple >
                                        </span>
                                        <!-- <button type="submit" class="btn btn-primary start">
                                            <i class="glyphicon glyphicon-upload"></i>
                                            <span>Start upload</span>
                                        </button>
                                        <button type="reset" class="btn btn-warning cancel">
                                            <i class="glyphicon glyphicon-ban-circle"></i>
                                            <span>Cancel upload</span>
                                        </button>
                                        <button type="button" class="btn btn-danger delete">
                                            <i class="glyphicon glyphicon-trash"></i>
                                            <span>Delete</span>
                                        </button>
                                        <input type="checkbox" class="toggle"> -->
                                        <!-- The global file processing state -->
                                        <span class="fileupload-process"></span>
                                    </div>
                                    <!-- The global progress state -->
                                    <div class="col-lg-5 fileupload-progress fade">
                                        <!-- The global progress bar -->
                                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                        </div>
                                        <!-- The extended global progress state -->
                                        <div class="progress-extended">&nbsp;</div>
                                    </div>
                                </div>
                                <!-- The table listing the files available for upload/download -->
                                <h3 class="text-center">Drag and Drop Files Here to upload.</h3>
                                <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                            </form>
                            <br>

                            
                        </div>
                        <div class="modal-footer">
                        <div class="col-md-12" id="load_more" data-lastid="">
                        <div class="row" style="margin-bottom: 5px;">
                        <h4 class="text-left">Choose Image(s)</h4>
                        <div class="superbox" id="gallery-manager">



                       
                        </div>
                        </div>
                        </div>
                            <a href="#" class="pull-left btn btn-default btn-sm"><i class="fa fa-refresh"></i> Load More Images</a>
                            <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cancel</a>
                            <a href="javascript:;" data-id="" data-url="" id="insert_image" class="btn btn-sm btn-primary">Insert Image</a>
                        </div>
                    </div>
                </div>
            </div>